<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('login');
    }

    function login(Request $request)
    {
        $request->validate(
            [
                'identity' => 'required',
                'password' => 'required',
            ],
            [
                'identity.required' => 'Username atau Email Wajib Diisi',
                'password.required' => 'Password Wajib Diisi',
            ],
        );

        $credentials = $request->only('identity', 'password');

        if (Auth::attempt(['username' => $credentials['identity'], 'password' => $credentials['password']]) || Auth::attempt(['email' => $credentials['identity'], 'password' => $credentials['password']])) {
            if (Auth::user()->role == 'warek') {
                return redirect('warek');
            } elseif (Auth::user()->role == 'dekan') {
                return redirect('dekan');
            } elseif (Auth::user()->role == 'kaprodi') {
                return redirect('kaprodi');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('admin');
            }
        } else {
            return redirect('')->withErrors('Username atau Password Salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
