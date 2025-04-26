<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:tienda'])->group(function () {
    Route::get('/tienda/dashboard', [TiendaController::class, 'TiendaDashboard'])->name('tienda.dashboard');
    Route::get('/tienda/torneos', [TiendaController::class, 'TiendaSegunda'])->name('tienda.seg');
    Route::get('/tienda/stock', [TiendaController::class, 'TiendaTercera'])->name('tienda.ter');
    Route::get('/tienda/distribuidora', [TiendaController::class, 'TiendaCuarta'])->name('tienda.cua');
    Route::post('/tienda/torneos/events', [TiendaController::class, 'store'])->name('tienda.events.store');
    Route::get('/tienda/gesTorneo/{id}', [TiendaController::class, 'TiendaGestionarTorneo'])->name('tienda.gesTorneo');
    /*Route::get('/tienda/gesTorneo/{id}/siguiente-ronda', [TiendaController::class, 'siguienteRonda'])->name('torneo.siguienteRonda');*/
    Route::post('/tienda/gesTorneo/{id}/siguiente-ronda', [TiendaController::class, 'siguienteRonda'])->name('torneo.siguienteRonda');
    Route::get('/tienda/gesTorneo/{id}/finalizado', [TiendaController::class, 'mostrarClasificacionFinal'])->name('torneo.finalizado');
    /*Route::delete('/tienda/torneos/{id}', [TiendaController::class, 'eliminar'])->name('tienda.events.eliminar');*/
});

Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/usuario/dashboard', [UsuarioController::class, 'UsuarioDashboard'])->name('usuario.dashboard');
    Route::get('/usuario/mazos', [UsuarioController::class, 'UsuarioSegunda'])->name('usuario.seg');
    Route::get('/usuario/tienda', [UsuarioController::class, 'UsuarioTercera'])->name('usuario.ter');
    Route::get('/usuario/carrito', [UsuarioController::class, 'UsuarioCuarta'])->name('usuario.cua');
    Route::get('/usuario/decks', [UsuarioController::class, 'ObtenerDecks'])->name('usuario.decks');
    Route::post('/usuario/dashboard/inscribir', [UsuarioController::class, 'inscribirEvento'])->name('usuario.inscribir');
    Route::get('/usuario/decksOP', [UsuarioController::class, 'apiOnePiece'])->name('usuario.decksOP');
});


require __DIR__ . '/auth.php';
