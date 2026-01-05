<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(RegisterRequest $request)
    {
        $user = $request->only('name', 'email');
        $user['password'] = Hash::make($request->password);
        User::create($user);

        return redirect()->route('admin');
    }
}
