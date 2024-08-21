<?php

namespace App\Http\Controllers;

use App\DataTables\GraduationDataTable;
use App\DataTables\StudyDataTable;
use App\Imports\StudyImport;
use App\Models\Graduation;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Maatwebsite\Excel\Facades\Excel;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function caseProdi($prodi, GraduationDataTable $dataTable)
    {
        $listProdi = [
            'k3' => 'Keselamatan dan Kesehatan Kerja',
            'ti' => 'Teknik Informatika',
            'si' => 'Sistem Informasi',
            'sk' => 'Sistem Komputer',
            'mm' => 'Magister Manajemen',
            'manajemen' => 'Manajemen',
            'arsitektur' => 'Arsitektur',
            'ip' => 'Ilmu Pemerintahan',
            'sipil' => 'Teknik Sipil',
            'akuntansi' => 'Akuntansi',
            'dkv' => 'Desain Komunikasi Visual',
            'pbi' => 'Pendidikan Bahasa Inggris',
            'pwk' => 'Perencanaan Wilayah dan Kota',
            'biologi' => 'Biologi',
            'kimia' => 'Kimia'
        ];

        if (array_key_exists($prodi, $listProdi) && Auth::user()->fps == $prodi) {
            return $this->graduateProdi($prodi, $listProdi[$prodi], $dataTable);
        } else {
            return view('404');
        }
    }

    protected function graduateProdi($prodi, $title, GraduationDataTable $dataTable)
    {
        $listTahun = Graduation::distinct()->pluck('tahun');

        $dataTahun = Graduation::select('tahun', DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'))
            ->where('lama', '<=', 4)
            ->where('npm', 'NOT LIKE', '%P%')
            ->where('prodi', $title)
            ->groupBy('tahun')
            ->get();

        $dataSeluruh = Graduation::select(
            'tahun',
            DB::raw('SUM(CASE WHEN proyeksi_predikat LIKE "%Cum Laude%" THEN 1 ELSE 0 END) AS DP'),
            DB::raw('SUM(CASE WHEN proyeksi_predikat = "Sangat Memuaskan" THEN 1 ELSE 0 END) AS SM'),
            DB::raw('SUM(CASE WHEN proyeksi_predikat = "Memuaskan" THEN 1 ELSE 0 END) AS M')
        )
            ->where('prodi', $title)
            ->groupBy('tahun')
            ->get();

        $dataFourYears = Graduation::select(
            'tahun',
            DB::raw('SUM(CASE WHEN lama < 4 THEN 1 ELSE 0 END) AS lessFourYears'),
            DB::raw('SUM(CASE WHEN lama > 4 THEN 1 ELSE 0 END) AS moreFourYears'),
        )
            ->where('prodi', $title)
            ->where(DB::raw('SUBSTRING(npm, 5, 2)'), '!=', '50')
            ->groupBy('tahun')
            ->get();

        return $dataTable->render('prodiGraduate', compact('title', 'listTahun', 'dataTahun', 'dataFourYears', 'dataSeluruh'));
    }

    public function case($prodi, StudyDataTable $dataTable)
    {
        $listProdi = [
            'k3' => 'Keselamatan dan Kesehatan Kerja',
            'ti' => 'Teknik Informatika',
            'si' => 'Sistem Informasi',
            'sk' => 'Sistem Komputer',
            'mm' => 'Magister Manajemen',
            'manajemen' => 'Manajemen',
            'arsitektur' => 'Arsitektur',
            'ip' => 'Ilmu Pemerintahan',
            'sipil' => 'Teknik Sipil',
            'akuntansi' => 'Akuntansi',
            'dkv' => 'Desain Komunikasi Visual',
            'pbi' => 'Pendidikan Bahasa Inggris',
            'pwk' => 'Perencanaan Wilayah dan Kota',
            'biologi' => 'Biologi',
            'survei' => 'Survei dan Pemetaan',
            'kimia' => 'Kimia'
        ];

        if (array_key_exists($prodi, $listProdi) && Auth::user()->fps == $prodi) {
            return $this->nilaiProdi($prodi, $listProdi[$prodi], $dataTable);
        } else {
            return view('404');
        }
    }

    protected function nilaiProdi($prodi, $title, StudyDataTable $dataTable)
    {
        $listTahun = Study::distinct()->pluck('tahun');

        return $dataTable->render('kaprodi', compact('title', 'listTahun'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'studyFile' => [
                File::types(['xls', 'xlsx'])
            ]
        ], [
            'studyFile.mimes' => 'Format file tidak didukung. Harap unggah file dalam format Excel (XLS atau XLSX).',
        ]);

        Excel::import(new StudyImport(), $request->file('studyFile'));

        return redirect('/nilai')->with('success', 'Data Berhasil Di Import');
    }

    public function prodiMahasiswa()
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Study::findOrFail($id)->delete();
        return redirect('/nilai')->with('success', 'User telah berhasil dihapus!');
    }
}
