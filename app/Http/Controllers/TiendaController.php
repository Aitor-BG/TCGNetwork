<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Torneo;

class TiendaController extends Controller
{
    public function TiendaDashboard()
    {
        $all_events = Event::all();

        $events = [];

        foreach ($all_events as $event) {
            $inscritos = $event->inscritos ? explode(',', $event->inscritos) : [];
            $events[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
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

    public function store(Request $request)
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
            ['competidor' => $jugador, 'event_id'=>$event->id],
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



}
