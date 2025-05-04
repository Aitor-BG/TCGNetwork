<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view("admin.admin_dashboard");
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
