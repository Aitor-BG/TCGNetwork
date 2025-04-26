<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Torneo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
    <div class="container mt-4">
        <h2>Clasificación Final - {{ $event->name }}</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Jugador</th>
                    <th>Puntos</th>
                    <th>Victorias</th>
                    <th>Derrotas</th>
                    <th>Bye</th>
                    <th>%1</th>
                    <th>%2</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clasificacion as $index => $jugador)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jugador->competidor }}</td>
                        <td>{{ $jugador->puntos }}</td>
                        <td>{{ $jugador->victorias }}</td>
                        <td>{{ $jugador->derrotas }}</td>
                        <td>{{ $jugador->bye }}</td>
                        <td>{{ number_format($jugador->porcentaje1, 2) }}%</td>
                        <td>{{ number_format($jugador->porcentaje2, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('tienda.dashboard') }}" class="btn btn-primary">Volver al inicio</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
</x-app-layout>
