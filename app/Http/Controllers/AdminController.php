<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Producto;
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
        $eventoActivo = Event::where('en_curso',true)->count();
        $eventoNoActivo = Event::where('en_curso',false)->count();
        $eventoVerificado = Event::where('estado','verificado')->count();
        $eventoNoVerificado = Event::where('estado','revision')->count();

        return view('admin.admin_dashboard', compact('totalUsuarios','usuarioTienda','usuarioUser','totalProductos','totalEventos','eventoActivo','eventoNoActivo','eventoVerificado','eventoNoVerificado'));
    }

    public function AdminSegunda()
    {
        $all_events = Event::all();
        $events = [];

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

        return view("admin.admin_notificaciones", compact('events'));
    }


    public function AdminTercera()
    {
        return view("admin.admin_logs");
    }


    public function verificarEvento($id)
    {
        $evento = Event::findOrFail($id);
        $evento->estado = 'verificado';
        $evento->save();
        return redirect()->back()->with('success', 'Evento verificado correctamente.');
    }
}
