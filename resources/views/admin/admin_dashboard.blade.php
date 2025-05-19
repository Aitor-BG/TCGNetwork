<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
<div class="container my-5">
        <h1 class="mb-4">Panel de Administración</h1>
        <div class="row g-4">
            <!-- Total Usuarios -->
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios Registrados</h5>
                        <p class="card-text display-4">{{ $totalUsuarios }}</p>
                        <p class="card-text">Tiendas: {{ $usuarioTienda }}<br>Usuarios: {{ $usuarioUser }}</p>
                    </div>
                </div>
            </div>

            <!-- Productos -->
            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Productos Dados de Alta</h5>
                        <p class="card-text display-4">{{ $totalProductos }}</p>
                    </div>
                </div>
            </div>

            <!-- Torneos -->
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Torneos Registrados</h5>
                        <p class="card-text display-4">{{ $totalEventos }}</p>
                        <p class="card-text">En Juego: {{ $eventoActivo }} - Por Comenzar: {{ $eventoNoActivo }}</p>
                        <p class="card-text">Verificado: {{ $eventoVerificado }} - No Verificado: {{ $eventoNoVerificado }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>
