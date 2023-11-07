<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFromRequest;

class AuthController extends Controller
{
    // return view
    public function show_login ()
    {
        return view('login.login_form');
    }

    //request
    //  App\Http\Requests\LoginFromRequest;
    public function login (LoginFromRequest $request)
    {
        dd($request->all());
    }
}
