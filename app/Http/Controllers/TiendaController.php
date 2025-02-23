<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function TiendaDashboard(){
        return view("tienda.tienda_dashboard");
    }

    public function TiendaSegunda(){
        return view("tienda.tienda_torneos");
    }

    public function TiendaTercera(){
        return view("tienda.tienda_stock");
    }

    public function TiendaCuarta(){
        return view("tienda.tienda_distribuidora");
    }
}
