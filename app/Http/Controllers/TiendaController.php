<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function TiendaDashboard(){
        return view("tienda.tienda_dashboard");
    }
}
