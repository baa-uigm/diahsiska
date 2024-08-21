<?php

namespace App\Http\Controllers;

use App\DataTables\AdminStudy;
use App\DataTables\UserDataTable;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.admin', [
            'title' => 'DASHBOARD',
        ]);
    }

    public function user(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user', [
            'title' => 'USERS',
        ]);
    }

    public function course(AdminStudy $dataTable)
    {
        return $dataTable->render('admin.course', [
            'title' => 'COURSE',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.input', [
            'title' => 'NEW USERS',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nidn' => 'numeric|min:10|unique:users',
                'username' => 'unique:users',
                'email' => 'unique:users',
                'password' => 'min:8',
            ],
            [
                'nidn.numeric' => 'NIDN hanya berupa angka',
                'nidn.min' => 'NIDN tidak valid',
                'nidn.unique' => 'NIDN sudah ada',
                'email.unique' => 'Email sudah ada',
                'username.unique' => 'Username sudah ada',
                'password.min' => 'Password minimal 8 karakter',
            ],
        );

        $data = [
            'nidn' => $request->nidn,
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->input('role'),
            'fps' => $request->input('fps'),
        ];

        User::create($data);

        return redirect('/admin/user')->with('success', 'User telah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function editStudy($id)
    {
        $study = Study::findOrFail($id);
        return view('admin.modal', compact('study'));
    }

    public function updateStudy(Request $request, $id)
    {
        $study = Study::findOrFail($id);
        $study->update($request->all());
        return response()->json(['message' => 'Study updated successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nidn)
    {
        $title = 'EDIT USERS';
        $data = User::where('nidn', $nidn)->first();
        $roles = ['warek' => 'Wakil Rektor', 'dekan' => 'Dekan', 'kaprodi' => 'Ketua Program Studi'];
        $fps = [
            'warek' => 'Wakil Rektor',
            'ilkom' => 'Ilmu Komputer dan Sains',
            'teknik' => 'Teknik',
            'ekonomi' => 'Ekonomi',
            'fipb' => 'Ilmu Pemerintahan dan Budaya',
            'fkip' => 'Keguruan dan Ilmu Pendidikan',
            'mm' => 'Magister Manajemen',
            'm' => 'Manajemen',
            'dkv' => 'Desain Komunikasi Visual',
            'ip' => 'Ilmu Pemerintahan',
            'pbi' => 'Pendidikan Bahasa Inggris',
            'b' => 'Biologi',
            'k' => 'Kimia',
            'si' => 'Sistem Informasi',
            'ti' => 'Teknik Informatika',
            'a' => 'Arsitektur',
            'k3' => 'Keselamatan dan Kesehatan Kerja',
            'sp' => 'Survei Dan Pemetaan',
            'ts' => 'Teknik Sipil',
        ];

        return view('admin.edit', compact('data', 'title', 'roles', 'fps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nidn)
    {
        $user = User::where('nidn', $nidn)->first();

        $request->validate(
            [
                'nama' => 'required',
                'username' => 'required' . ($request->username == $user->username ? '' : '|unique:users'),
                'email' => $request->email == $user->email ? '' : '|unique:users,email',
            ],
            [
                'nama.required' => 'Masukkan nama anda',
                'username.unique' => 'Username sudah ada',
            ],
        );

        $data = [
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password == '' ? $user->password : bcrypt($request->password),
            'role' => $request->input('role'),
            'fps' => $request->input('fps'),
        ];

        if ($request->username == $user->username || User::where('username', $request->username)->count() == 0) {
            if ($request->email == $user->email || User::where('email', $request->email)->count() == 0) {
                $user->where('nidn', $nidn)->update($data);
                return redirect('/admin/user')->with('success', 'User telah berhasil diperbaharui!');
            }
        } else {
            return back()->withErrors(['email' => 'Email yang anda masukkan sudah ada']);
        }

        return redirect('/admin/user')->with('success', 'Data telah berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nidn)
    {
        User::where('nidn', $nidn)->delete();

        return redirect('/admin/user')->with('success', 'User telah berhasil dihapus!');
    }

    public function destroyStudy(string $id)
    {
        Study::where('id', $id)->delete();

        return redirect('/admin/study')->with('success', 'Study telah berhasil dihapus!');
    }
}
