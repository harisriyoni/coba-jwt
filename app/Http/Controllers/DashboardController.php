<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        Auth::user();
        return response()->json(['message' => 'selamat datang admin']);
    }

    public function user()
    {
        Auth::user();
        return response()->json(['message' => 'selamat datang user']);
    }
}
