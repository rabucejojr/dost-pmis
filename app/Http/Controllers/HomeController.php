<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'user' => Auth::user(),
        ]);
    }

    public function userPage()
    {
        return Inertia::render('User', [
            'user' => Auth::user(),
        ]);
    }

    public function guestPage()
    {
        return Inertia::render('Guest', [
            'user' => Auth::user(),
        ]);
    }
}
