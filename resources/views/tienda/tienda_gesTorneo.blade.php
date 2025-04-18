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
            <!--<h3>{{ $event->name }}</h3>-->
            <h4>Partidas:</h4>
            <table class="table">
                <thead class="text-center">
                    <tr>
                        <th>Jugador 1</th>
                        <th colspan="2">Resultado</th>
                        <th>Jugador 2</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($pares as $par)
                        <tr>
                            <td>{{ $par[0] }}</td>
                            <td>+</td>
                            <td>+</td>
                            <td>{{ $par[1] ?? '-Bye-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><button class="btn btn-info">Siguiente Ronda</button><button class="btn btn-success">Terminar Evento</button></p>
            <h4>Clasificación:</h4>
            <table class="table">
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>