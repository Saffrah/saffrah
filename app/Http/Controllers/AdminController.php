<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminStoreRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AdminService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->admin_service->get_all();
        
        return view('pages/admins/index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages/admins/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {
        $created = $this->admin_service->store($request->validated());

        if($created['code'] == 200)
            return redirect()->route('admins.get');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if($this->admin_service->delete($request->input())) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

}
