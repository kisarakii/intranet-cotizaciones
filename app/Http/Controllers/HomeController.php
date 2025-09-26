<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        // Home es privada
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        // Vista sencilla: saludo con nombre + apellido
        return view('home', compact('user'));
    }
}
