<?php

namespace App\Http\Controllers;

use App\{ User, Token };
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register/create');
    }

    public function store(Request $request)
    {
        //TODO: agregar la validacion, ejemplo campos vacios, email invalido, etc

        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();
    }
}
