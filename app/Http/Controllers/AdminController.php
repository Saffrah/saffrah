<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private $admin_service; 

    public function __construct(AdminService $admin_service = null) 
    {
        $this->admin_service = $admin_service;
    }

    public function getLogin() 
    {
        return view('auth/sign_in');
    }

    public function postLogin(AdminLoginRequest $request) 
    {
        if (Auth::guard('admin')->attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function getRegister() 
    {
        return view('auth/sign_up');    
    }

    public function postRegister(AdminRegisterRequest $request)
    {
        $result = $this->admin_service->save($request->validated());

        if($result)
            return redirect()->route('admin.get.login')->with('success', 'Admin registered successfully!');

        return redirect()->back()->with('failed', 'error!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.get.login');
    }

    public function dashboard() 
    {
        $admin = $this->admin_service->loggedinAdmin();
        
        return view('dashboard.dashboard', compact('admin'));
    }

}
