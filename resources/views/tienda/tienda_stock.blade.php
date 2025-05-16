<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stock</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
    <div class="container my-4">
        <div class="row">
            @foreach ($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 100%;">
                        <img src="..." class="card-img-top" alt="Imagen del producto">
                        <div class="card-body">
                            <h4 class="card-title">{{ $producto['nombre'] }}</h4>
                            <p class="card-text">{{ $producto['descripcion'] }}</p>
                            <p>{{ $producto['precio'] }}€</p>
                            @if ($producto['cantidad'] < 5)
                                <p style="color: red;">Últimas unidades</p>
                            @endif
                            <a href="#" class="btn btn-success">Agregar a carrito</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>