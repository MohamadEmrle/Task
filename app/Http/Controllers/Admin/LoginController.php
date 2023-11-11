<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.pages.login');
    }
    public function store(LoginRequest $request)
    {
        $data = [
            'email'      => $request->email,
            'password'   => $request->password,
        ];
        if(auth()->guard('admin')->attempt($data)) {
            return redirect()->intended('admin/dashboard');
        }
    }
}
