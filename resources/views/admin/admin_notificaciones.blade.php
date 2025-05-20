<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notificaciones</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>Eventos sin confirmar</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Fecha</th>
                                <th>Evento</th>
                                <th>Detalles</th>
                                <th>Tienda</th>
                                <th>Verificar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (collect($events)->sortBy('date') as $event)
                                <tr class="text-center">
                                    <td>{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}</td>
                                    <td>{{ $event['title'] }}</td>
                                    <td>{{ $event['details'] }}</td>
                                    <td>{{ $event['user_name'] }}</td>
                                    <td>
                                        <form action="{{ route('admin.eventos.verificar', $event['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">V</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Productos Sin Verificar</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Tienda</th>
                                <th>Verificar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (collect($products)->sortBy('date') as $product)
                                <tr class="text-center">
                                    <td>{{ $product['nombre'] }}</td>
                                    <td>{{ $product['descripcion'] }}</td>
                                    <td>{{ $product['precio'] }}€</td>
                                    <td>{{ $product['user_name'] }}</td>
                                    <td>
                                        <form action="{{ route('admin.productos.verificar', $product['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">V</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</x-app-layout>