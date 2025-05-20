<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Event;
use App\Models\Producto;

class UsuarioController extends Controller
{
    public function UsuarioDashboard()
    {
        $all_events = Event::all();

        $events = [];
        foreach ($all_events as $event) {
            $events[] = [
                'id' => $event->id,
                'title' => $event->name,
                'date' => $event->date,
                'color' => $event->color,
                'details' => $event->details,
                'inscritos' => $event->inscritos,
                'participantes' => $event->participantes,
                'user_name' => optional($event->user)->name ?? 'Desconocido'
            ];
        }

        return view('usuario.usuario_dashboard', compact('events'));
    }

    public function UsuarioSegunda()
    {
        return view("usuario.usuario_mazos");
    }

    public function UsuarioTercera()
    { {
            $all_productos = Producto::all();

            $productos = [];

            foreach ($all_productos as $producto) {
                $productos[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio' => $producto->precio,
                    'cantidad' => $producto->cantidad,
                    'user_name' => optional($producto->user)->name ?? 'Desconocido'
                ];
            }
            return view("usuario.usuario_tienda", compact('productos'));
        }
    }

    public function UsuarioCuarta()
    {
        return view("usuario.usuario_carrito");
    }

    public function procesarCompra(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $producto->cantidad = max(0, $producto->cantidad - 1); // Resta 1 por unidad en el carrito
                $producto->save();
            }
        }

        return response()->json(['message' => 'Compra procesada correctamente']);
    }

    public function obtenerDecks()
    {
        return view("usuario.usuario_decks");
    }


    public function apiOnePiece(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 18;

        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        if ($request->has('name')) {
            $query['name'] = $request->input('name');
        }
        if ($request->has('type')) {
            $query['type'] = $request->input('type');
        }
        if ($request->has('color')) {
            $query['color'] = $request->input('color');
        }



        $url = 'https://apitcg.com/api/one-piece/cards?' . http_build_query($query);

        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json();
            return view('usuario.usuario_decksOP', compact('datos', 'page', 'limit'));
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
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

            // Verificar si el usuario ya está inscrito
            if (in_array($user->username, $inscritos)) {
                // Si el usuario está inscrito, lo desinscribimos
                $inscritos = array_diff($inscritos, [$user->username]); // Elimina al usuario de la lista
                $event->inscritos = $inscritos ? implode(',', $inscritos) : null;
                $event->save();

                return response()->json(['success' => 'Te has desinscrito correctamente.', 'inscrito' => false]);
            } else {
                // Si el usuario no está inscrito, lo inscribimos
                $inscritos[] = $user->username;
                $event->inscritos = implode(',', $inscritos);
                $event->save();

                return response()->json(['success' => 'Te has inscrito correctamente.', 'inscrito' => true]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
        }
    }

    public function apiDragonBall(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 18;

        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        if ($request->has('name')) {
            $query['name'] = $request->input('name');
        }
        if ($request->has('cardType')) {
            $query['cardType'] = $request->input('cardType');
        }
        if ($request->has('color')) {
            $query['color'] = $request->input('color');
        }



        $url = 'https://apitcg.com/api/dragon-ball-fusion/cards?' . http_build_query($query);

        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json();
            return view('usuario.usuario_decksDB', compact('datos', 'page', 'limit'));
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
    }

    public function apiDigimon(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 18;

        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        if ($request->has('name')) {
            $query['name'] = $request->input('name');
        }

        $url = 'https://apitcg.com/api/digimon/cards?' . http_build_query($query);

        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json();
            return view('usuario.usuario_decksDG', compact('datos', 'page', 'limit'));
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
    }

        public function apiGundam(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 18;

        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        if ($request->has('name')) {
            $query['name'] = $request->input('name');
        }

        $url = 'https://apitcg.com/api/gundam/cards?' . http_build_query($query);

        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json();
            return view('usuario.usuario_decksGD', compact('datos', 'page', 'limit'));
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
    }
}
