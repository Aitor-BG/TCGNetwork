<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Producto;
use App\Models\Activity;
use App\Models\Torneo;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        $totalUsuarios = User::count();
        $usuarioTienda = User::where('role', 'tienda')->count();
        $usuarioUser = User::where('role', 'usuario')->count();

        $totalProductos = Producto::count();
        $totalEventos = Event::count();
        $eventoActivo = Event::where('en_curso', true)->count();
        $eventoNoActivo = Event::where('en_curso', false)->count();
        $eventoVerificado = Event::where('estado', 'verificado')->count();
        $eventoNoVerificado = Event::where('estado', 'revision')->count();

        return view('admin.admin_dashboard', compact('totalUsuarios', 'usuarioTienda', 'usuarioUser', 'totalProductos', 'totalEventos', 'eventoActivo', 'eventoNoActivo', 'eventoVerificado', 'eventoNoVerificado'));
    }

    public function AdminSegunda()
    {
        $all_events = Event::all();
        $events = [];
        $all_products = Producto::all();
        $products = [];

        foreach ($all_events as $event) {
            $inscritos = $event->inscritos ? explode(',', $event->inscritos) : [];

            if ($event->estado == 'revision') {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->name,
                    'date' => $event->date,
                    'details' => $event->details,
                    'user_name' => optional($event->user)->name ?? 'Desconocido'
                ];
            }
        }

        foreach ($all_products as $product) {
            if ($product->estado == 'revision') {
                $products[] = [
                    'id'=>$product->id,
                    'nombre'=>$product->nombre,
                    'descripcion'=>$product->descripcion,
                    'precio'=>$product->precio,
                    'user_name'=>optional($product->user)->name ?? 'Desconocido'
                ];
            }
        }

        return view("admin.admin_notificaciones", compact('events','products'));
    }


    public function AdminTercera()
    {
    $logs = Activity::with('causer', 'subject')->latest()->paginate(10);
    return view("admin.admin_logs", compact('logs'));
    }


    public function verificarEvento($id)
    {
        $evento = Event::findOrFail($id);
        $evento->estado = 'verificado';
        $evento->save();
        return redirect()->back()->with('success', 'Evento verificado correctamente.');
    }

    public function verificarProductos($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 'verificado';
        $producto->save();
        return redirect()->back()->with('success', 'Producto verificado correctamente.');
    }
}
