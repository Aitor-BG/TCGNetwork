<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Torneo;
use App\Models\Partida;

class TiendaController extends Controller
{
    public function TiendaDashboard()
    {
        $all_events = Event::all();

        $events = [];

        foreach ($all_events as $event) {
            $inscritos = $event->inscritos ? explode(',', $event->inscritos) : [];
            /*$events[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => $event->color,
                'details' => $event->details,
                'inscritos' => count($inscritos),
                'participantes' => $event->participantes,
            ];*/
            $events[] = [
                'id' => $event->id,
                'title' => $event->name,
                'date' => $event->date,
                'color' => $event->color,
                'details' => $event->details,
                'inscritos' => count($inscritos),
                'participantes' => $event->participantes,
            ];
        }

        return view('tienda.tienda_dashboard', compact('events'));
    }

    public function TiendaSegunda()
    {
        return view("tienda.tienda_torneos");
    }

    public function TiendaTercera()
    {
        return view("tienda.tienda_stock");
    }

    public function TiendaCuarta()
    {
        return view("tienda.tienda_distribuidora");
    }

    public function TiendaTorneo()
    {
        return view("tienda.tienda_gesTorneo");
    }

    /*public function store(Request $request)
    {

        // Validación de los datos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'required|string',
            'description' => 'required|string',
            'participantes' => 'required|integer'
        ]);

        $event = new Event();
        $event->name = $validated['title'];
        $event->start_date = $validated['start_date'];
        $event->end_date = $validated['end_date'];
        $event->color = $validated['color'];
        $event->details = $validated['description'];
        $event->participantes = $validated['participantes'];

        // Guardar el evento en la base de datos
        $event->save();

        // Redirigir al dashboard de la tienda
        return redirect()->route('tienda.dashboard');
    }*/

    public function store(Request $request)
    {
        /*$validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'required|string',
            'description' => 'required|string',
            'participantes' => 'required|integer'
        ]);

        $event = new Event();
        $event->name = $validated['title'];
        $event->start_date = $validated['start_date'];
        $event->end_date = $validated['end_date'];
        $event->color = $validated['color'];
        $event->details = $validated['description'];
        $event->participantes = $validated['participantes'];*/

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'color' => 'required|string',
            'description' => 'required|string',
            'participantes' => 'required|integer'
        ]);

        $event = new Event();
        $event->name = $validated['title'];
        $event->date = $validated['date'];
        $event->color = $validated['color'];
        $event->details = $validated['description'];
        $event->participantes = $validated['participantes'];

        $event->save();

        return redirect()->route('tienda.dashboard');
    }

    /*public function eliminar($id)
    {
        // Encontrar el evento por su ID
        $evento = Event::find($id);
    
        if (!$evento) {
            return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
        }
    
        // Eliminar el evento
        $evento->delete();
    
        // Retornar una respuesta exitosa
        return response()->json(['success' => true, 'message' => 'Evento eliminado']);
    }*/

    public function TiendaGestionarTorneo($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->route('tienda.dashboard')->with('error', 'Evento no encontrado');
        }

        $inscritos = $event->inscritos ? explode(',', $event->inscritos) : [];

        foreach ($inscritos as $jugador) {
            Torneo::firstOrCreate(
                ['competidor' => $jugador, 'event_id' => $event->id],
                [
                    'puntos' => 0,
                    'victorias' => 0,
                    'derrotas' => 0,
                    'bye' => 0,
                    'porcentaje1' => 0,
                    'porcentaje2' => 0,
                ]
            );
        }

        $pares = [];
        foreach ($inscritos as $index => $inscrito) {
            if ($index % 2 == 0) {
                $pares[] = [$inscrito, $inscritos[$index + 1] ?? null];
            }
        }

        $clasificacion = Torneo::where('event_id', $event->id)
            ->orderByDesc('puntos')
            ->get();

        return view('tienda.tienda_gesTorneo', [
            'event' => $event,
            'pares' => $pares,
            'inscritos' => $inscritos,
            'clasificacion' => $clasificacion
        ]);
    }

    public function siguienteRonda(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);

        // 1. Procesar resultados de la última ronda antes de generar la nueva
        $ganadores = $request->input('ganador', []);
        $ronda_actual = Partida::where('event_id', $event_id)->max('ronda');

        foreach ($ganadores as $partida_id => $ganador) {
            $partida = Partida::find($partida_id);
            if (!$partida)
                continue;

            $jugador1 = Torneo::where('event_id', $event_id)->where('competidor', $partida->jugador1)->first();
            $jugador2 = $partida->jugador2 ? Torneo::where('event_id', $event_id)->where('competidor', $partida->jugador2)->first() : null;

            if ($ganador === $partida->jugador1) {
                $jugador1->puntos += 3;
                $jugador1->victorias += 1;
                $jugador1->save();

                if ($jugador2) {
                    $jugador2->derrotas += 1;
                    $jugador2->save();
                }

            } elseif ($jugador2 && $ganador === $partida->jugador2) {
                $jugador2->puntos += 3;
                $jugador2->victorias += 1;
                $jugador2->save();

                $jugador1->derrotas += 1;
                $jugador1->save();
            }
        }

        // 2. Generar la siguiente ronda (emparejamientos estilo Swiss)
        $jugadores = Torneo::where('event_id', $event_id)
            ->orderByDesc('puntos')
            ->get();

        $matches = Partida::where('event_id', $event_id)->get();
        $emparejamientos = [];

        while ($jugadores->count() > 1) {
            $jugador1 = $jugadores->shift();

            foreach ($jugadores as $key => $jugador2) {
                $ya_jugaron = $matches->contains(function ($match) use ($jugador1, $jugador2) {
                    return
                        ($match->jugador1 === $jugador1->competidor && $match->jugador2 === $jugador2->competidor) ||
                        ($match->jugador1 === $jugador2->competidor && $match->jugador2 === $jugador1->competidor);
                });

                if (!$ya_jugaron) {
                    $emparejamientos[] = [$jugador1->competidor, $jugador2->competidor];
                    $jugadores->forget($key);
                    break;
                }
            }
        }

        if ($jugadores->count() === 1) {
            $byePlayer = $jugadores->first();
            $emparejamientos[] = [$byePlayer->competidor, null];

            if ($byePlayer->bye == 0) {
                $byePlayer->puntos += 3;
                $byePlayer->bye = 1;
                $byePlayer->save();
            }
        }

        $nueva_ronda = $ronda_actual + 1;

        foreach ($emparejamientos as $par) {
            Partida::create([
                'event_id' => $event_id,
                'jugador1' => $par[0],
                'jugador2' => $par[1],
                'ronda' => $nueva_ronda
            ]);
        }

        return redirect()->back()->with('success', 'Resultados guardados y nueva ronda generada');
    }
    public function mostrarClasificacionFinal($id)
    {
        $event = Event::findOrFail($id);
        $clasificacion = Torneo::where('event_id', $id)
            ->orderByDesc('puntos')
            ->get();

        return view('tienda.tienda_clasificacion_final', compact('event', 'clasificacion'));
    }

}