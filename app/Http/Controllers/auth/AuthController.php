<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();
              
            return redirect()->intended('/home');
        }

        // Autenticación fallida
        return back()->withInput()->withErrors(['error' => 'Credenciales incorrectas']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
