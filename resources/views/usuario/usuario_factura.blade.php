<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .factura-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .factura-header h1 {
            margin: 0;
        }

        .factura-header p {
            margin: 5px;
        }

        .factura-datos {
            margin-bottom: 30px;
        }

        .factura-datos .col {
            margin-bottom: 10px;
        }

        .factura-datos strong {
            width: 150px;
            display: inline-block;
        }

        .factura-carrito {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .factura-carrito th, .factura-carrito td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .factura-carrito th {
            background-color: #f4f4f4;
        }

        .factura-footer {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="factura-header">
        <h1>Factura de Compra</h1>
        <p>Fecha: {{ date('d/m/Y') }}</p>
    </div>

    <div class="factura-datos">
        <div class="col">
            <strong>Nombre completo:</strong> {{ $facturacion['nombre'] }}
        </div>
        <div class="col">
            <strong>Dirección:</strong> {{ $facturacion['direccion'] }}
        </div>
        <div class="col">
            <strong>Ciudad:</strong> {{ $facturacion['ciudad'] }}
        </div>
        <div class="col">
            <strong>Código Postal:</strong> {{ $facturacion['cp'] }}
        </div>
        <div class="col">
            <strong>Teléfono:</strong> {{ $facturacion['telefono'] }}
        </div>
    </div>

    <div class="factura-carrito">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrito as $item)
                <tr>
                    <td>{{ $item['nombre'] }}</td>
                    <td>{{ $item['precio'] }}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="factura-footer">
        <strong>Total: {{ $total }}€</strong>
    </div>

</body>

</html>
