<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RedisTagSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect('admin');
                break;
            case 'warek':
                return redirect('warek');
                break;
            case 'dekan':
                return redirect('dekan');
                break;
            case 'kaprodi':
                return redirect('kaprodi');
                break;
            default:
                return view('404');
                break;
        }
    }

    function warek()
    {
        return view('admin', [
            'title' => 'Wakil Rektor',
        ]);
    }

    function dekan()
    {
        return view('admin', [
            'title' => 'Dekan',
        ]);
    }

    function kaprodi()
    {
        return view('admin', [
            'title' => 'Ketua Program Studi',
        ]);
    }
}
