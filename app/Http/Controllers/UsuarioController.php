<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function UsuarioDashboard(){
        return view("usuario.usuario_dashboard");
    }

    public function UsuarioSegunda(){
        return view("usuario.usuario_mazos");
    }

    public function UsuarioTercera(){
        return view("usuario.usuario_tienda");
    }

    public function UsuarioCuarta(){
        return view("usuario.usuario_carrito");
    }
}
