<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function datosOP(Request $request)
    {
        // Parámetros de paginación
        $page = $request->input('page', 1); // Por defecto, comenzamos en la página 1
        $limit = 30; // Mostramos 30 cartas por página (6 filas x 5 columnas)

        // La URL de la API con los parámetros de paginación
        $url = 'https://apitcg.com/api/one-piece/cards?limit=' . $limit . '&page=' . $page;

        // Hacemos la solicitud con el encabezado de la API
        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json(); // Convertimos la respuesta a un array
            return view('api_data', compact('datos', 'page', 'limit')); // Pasamos los datos, la página y el límite a la vista
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
    }

    public function datosPok(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 30;

        $url = 'https://apitcg.com/api/pokemon/cards?limit=' . $limit . '&page=' . $page;

        $respuesta = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
        ])->get($url);

        if ($respuesta->successful()) {
            $datos = $respuesta->json(); // Convertimos la respuesta a un array
            return view('api_data', compact('datos', 'page', 'limit')); // Pasamos los datos, la página y el límite a la vista
        } else {
            return response()->json(['error' => 'Error al conectarse con la API'], 500);
        }
    }
}
