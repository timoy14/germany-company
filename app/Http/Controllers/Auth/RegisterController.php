<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Store a new User
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['user_name' => $request->input('username')]);
        $request->request->remove('username'); 
        $validated = $request->validate([
            'user_name' => 'required|unique:users|max:20',
            'password' => 'required',
        ]);
        
        return User::insert([
            'user_name' => $request->user_name,
            'user_role' => isset($request->user_role) ? $request->user_role : "user",
            'password' => bcrypt($request->password),
        ]);
    }
}
