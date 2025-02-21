<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function UsuarioDashboard(){
        return view("usuario.usuario_dashboard");
    }
}
