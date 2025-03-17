<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class UsuarioController extends Controller
{
    public function UsuarioDashboard(){
        $all_events = Event::all();

        $events = [];
        foreach ($all_events as $event) {
            $events[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => $event->color,
                'details' => $event->details,
                'inscritos' => $event->inscritos,
                'participantes' => $event->participantes,
            ];
        }

        return view('usuario.usuario_dashboard', compact('events'));
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
    public function inscribirEvento(Request $request)
    {
        try {
            $eventId = $request->input('event_id');
            $user = auth()->user(); // Obtiene el usuario autenticado
    
            $event = Event::find($eventId);
    
            if (!$event) {
                return response()->json(['error' => 'Evento no encontrado.'], 404);
            }
    
            $inscritos = $event->inscritos ? explode(',', $event->inscritos) : [];
    
            if (in_array($user->username, $inscritos)) {
                return response()->json(['error' => 'Ya estás inscrito en este evento.'], 400);
            }
    
            $inscritos[] = $user->username;
            $event->inscritos = count($inscritos) ? implode(',', $inscritos) : null;
            $event->save();
    
            return response()->json(['success' => 'Te has inscrito correctamente.']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    
    
}
