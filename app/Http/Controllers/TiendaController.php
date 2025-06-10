<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
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
            if ($event->user_id === auth()->id()) {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->name,
                    'date' => $event->date,
                    'color' => $event->color,
                    'details' => $event->details,
                    'inscritos' => count($inscritos),
                    'participantes' => $event->participantes,
                    'estado' => $event->estado
                ];
            }
        }

        return view('tienda.tienda_dashboard', compact('events'));
    }

    public function TiendaSegunda()
    {
        $all_productos = Producto::all();

        $productos = [];

        foreach ($all_productos as $producto) {
            if ($producto->user_id === auth()->id() && $producto->estado === 'verificado') {
                $productos[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio' => $producto->precio,
                    'cantidad' => $producto->cantidad,
                    'user_name' => optional($producto->user)->name ?? 'Desconocido',
                    'imagen' => $producto->imagen
                ];
            }

        }
        return view("tienda.tienda_stock", compact('productos'));
    }

    public function TiendaTercera()
    {
        $all_productos = Producto::all();

        $productos = [];

        foreach ($all_productos as $producto) {
            if ($producto->estado === 'verificado' && $producto->user_id === 1) {
                $productos[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio' => $producto->precio,
                    'cantidad' => $producto->cantidad,
                    'user_name' => optional($producto->user)->name ?? 'Desconocido',
                    'imagen' => $producto->imagen
                ];
            }

        }
        return view("tienda.tienda_distribuidora", compact('productos'));
    }

    public function TiendaTorneo()
    {
        return view("tienda.tienda_gesTorneo");
    }

    public function store(Request $request)
    {
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
        $event->user_id = auth()->id();

        $event->save();

        return redirect()->route('tienda.dashboard');
    }

    public function eliminarEvento($id)
    {
        $evento = Event::findOrFail($id);
        $evento->estado = 'revision';
        $evento->save();
        return redirect()->back()->with('success', 'Evento eliminado correctamente.');
    }

    public function editarEvento(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'color' => 'required|string',
            'description' => 'required|string',
            'participantes' => 'required|integer'
        ]);

        $event = Event::findOrFail($id);

        // Solo permite editar sus propios eventos
        if ($event->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $event->name = $validated['title'];
        $event->date = $validated['date'];
        $event->color = $validated['color'];
        $event->details = $validated['description'];
        $event->participantes = $validated['participantes'];
        $event->estado = 'revision';

        $event->save();

        return redirect()->route('tienda.dashboard')->with('success', 'Evento actualizado correctamente');
    }

    public function crearProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Guardar imagen en storage/app/public/productos
        $path = $request->file('imagen')->store('productos', 'public');

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'imagen' => $path,
            'user_id' => auth()->id(),
            'estado' => 'revision',
        ]);

        return redirect()->back()->with('success', 'Producto creado correctamente');
    }


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

    /*public function siguienteRonda(Request $request, $event_id)
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

            if ($byePlayer->bye == 0) { //$ronda_actual>=1
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
    }*/

    public function siguienteRonda(Request $request, $event_id)
{
    $event = Event::findOrFail($event_id);
    $rondaActual = $event->ronda;
    $nuevaRonda = $rondaActual + 1;

    // Obtener los jugadores ordenados por puntos y porcentaje2
    $jugadores = Torneo::where('event_id', $event_id)
        ->orderByDesc('puntos')
        ->orderByDesc('porcentaje1')
        ->orderByDesc('porcentaje2')
        ->get();

    // Crear emparejamientos por pares
    for ($i = 0; $i < count($jugadores); $i += 2) {
        if (isset($jugadores[$i + 1])) {
            // Crear partida entre jugador[i] y jugador[i+1]
            Partida::create([
                'event_id' => $event_id,
                'ronda' => $nuevaRonda,
                'jugador1' => $jugadores[$i]->competidor,
                'jugador2' => $jugadores[$i + 1]->competidor,
                'ganador' => null,
            ]);
        } else {
            // Jugador impar: bye (victoria automática)
            Partida::create([
                'event_id' => $event_id,
                'ronda' => $nuevaRonda,
                'jugador1' => $jugadores[$i]->competidor,
                'jugador2' => null,
                'ganador' => $jugadores[$i]->competidor,
            ]);

            $jugadores[$i]->victorias += 1;
            $jugadores[$i]->puntos += 3;
            $jugadores[$i]->save();
        }
    }

    // Actualizar número de rondas en el evento
    $event->ronda = $nuevaRonda;
    $event->save();

    // Cálculo de porcentajes de desempate (DCI 2023)
    $torneos = Torneo::where('event_id', $event_id)->get();
    $partidas = Partida::where('event_id', $event_id)->get();

    foreach ($torneos as $jugador) {
        $totalPartidas = $partidas->filter(function ($p) use ($jugador) {
            return $p->jugador1 === $jugador->competidor || $p->jugador2 === $jugador->competidor;
        });

        $jugadas = $totalPartidas->count();
        $victorias = $jugador->victorias;

        // Porcentaje 1 (Match Win %)
        $porcentaje1 = $jugadas > 0 ? ($victorias / $jugadas) * 100 : 0;

        // Obtener oponentes
        $oponentes = [];
        foreach ($totalPartidas as $p) {
            if ($p->jugador1 === $jugador->competidor && $p->jugador2) {
                $oponentes[] = $p->jugador2;
            } elseif ($p->jugador2 === $jugador->competidor && $p->jugador1) {
                $oponentes[] = $p->jugador1;
            }
        }

        $porcentajeOponentes = [];

        foreach ($oponentes as $oponente) {
            $oponenteStats = Torneo::where('event_id', $event_id)
                ->where('competidor', $oponente)
                ->first();

            if ($oponenteStats) {
                $oponentePartidas = $partidas->filter(function ($p) use ($oponente) {
                    return $p->jugador1 === $oponente || $p->jugador2 === $oponente;
                });

                $oponenteJugadas = $oponentePartidas->count();
                $oponenteVictorias = $oponenteStats->victorias;

                if ($oponenteJugadas > 0) {
                    $winRate = $oponenteVictorias / $oponenteJugadas;
                    $winRate = max($winRate, 0.33); // mínimo del 33%
                    $porcentajeOponentes[] = $winRate * 100;
                }
            }
        }

        $porcentaje2 = count($porcentajeOponentes) > 0
            ? array_sum($porcentajeOponentes) / count($porcentajeOponentes)
            : 0;

        // Guardar los porcentajes
        $jugador->porcentaje1 = round($porcentaje1, 2);
        $jugador->porcentaje2 = round($porcentaje2, 2);
        $jugador->save();
    }

    return redirect()->back()->with('success', 'Nueva ronda generada correctamente.');
}

    public function mostrarClasificacionFinal($id)
    {
        $event = Event::findOrFail($id);
        $clasificacion = Torneo::where('event_id', $id)
            ->orderByDesc('puntos')
            ->get();

        return view('tienda.tienda_clasificacion_final', compact('event', 'clasificacion'));
    }

    public function incrementarProd($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->cantidad += 1;
        $producto->save();

        return response()->json(['cantidad' => $producto->cantidad]);
    }

    public function disminuirProd($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->cantidad > 0) {
            $producto->cantidad -= 1;
            $producto->save();
        }

        return response()->json(['cantidad' => $producto->cantidad]);
    }

}