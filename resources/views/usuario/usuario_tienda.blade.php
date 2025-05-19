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

        <style>
            .carrito {
                border-left: 2px solid #ccc;
                padding-left: 20px;
                max-height: 100vh;
                overflow-y: auto;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid my-4">
            <div class="row">
                <!-- Productos -->
                <div class="col-md-9">
                    <!-- Filtros -->
                    <div class="mb-4">
                        <h5><x-bi-search />Filtros</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" id="filtro-nombre" class="form-control"
                                    placeholder="Buscar por nombre">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="filtro-tienda" class="form-control"
                                    placeholder="Buscar por tienda">
                            </div>
                            <div class="col-md-2">
                                <input type="number" id="filtro-precio-min" class="form-control"
                                    placeholder="Precio mínimo">
                            </div>
                            <div class="col-md-2">
                                <input type="number" id="filtro-precio-max" class="form-control"
                                    placeholder="Precio máximo">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($productos as $producto)
                            <div class="col-md-4 mb-4 producto" data-nombre="{{ strtolower($producto['nombre']) }}"
                                data-tienda="{{ strtolower($producto['user_name']) }}"
                                data-precio="{{ $producto['precio'] }}">
                                <div class="card">
                                    <img src="..." class="card-img-top" alt="Imagen del producto">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                                        <p class="card-text">{{ $producto['descripcion'] }}</p>
                                        <p><strong>Tienda: </strong>{{ $producto['user_name'] }}</p>
                                        <p><strong>{{ $producto['precio'] }}€</strong></p>
                                        @if ($producto['cantidad'] == 0)
                                            <p class="text-danger">Producto Agotado</p>
                                        @elseif($producto['cantidad'] < 5)
                                            <p class="text-warning">Últimas unidades</p>
                                        @endif
                                        <button class="btn btn-success agregar-carrito" data-id="{{ $producto['id'] }}"
                                            data-nombre="{{ $producto['nombre'] }}" data-precio="{{ $producto['precio'] }}"
                                            @if ($producto['cantidad'] == 0) disabled @endif>
                                            Agregar al carrito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Carrito -->
                <div class="col-md-3 carrito">
                    <h4><x-bi-cart/>Carrito</h4>
                    <ul id="lista-carrito" class="list-group mb-3"></ul>
                    <p><strong>Total: <span id="total">0</span> €</strong></p>
                    @php
                    $route = Auth::user()->role.'.carrito'
                    @endphp
                    <a class="btn btn-success btn-sm" href="{{ route($route) }}">Hacer pedido</a>
                    <button class="btn btn-danger btn-sm" onclick="vaciarCarrito()">Vaciar carrito</button>
                </div>
            </div>
        </div>

        <script>
    function obtenerCarrito() {
        return JSON.parse(sessionStorage.getItem('carrito')) || [];
    }

    function guardarCarrito(carrito) {
        sessionStorage.setItem('carrito', JSON.stringify(carrito));
    }

    function renderizarCarrito() {
        const carrito = obtenerCarrito();
        const lista = document.getElementById('lista-carrito');
        const totalElem = document.getElementById('total');

        if (!lista || !totalElem) return;

        lista.innerHTML = '';
        let total = 0;

        carrito.forEach((item, index) => {
            total += parseFloat(item.precio);
            const li = document.createElement('li');
            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            li.innerHTML = `
                ${item.nombre} - ${item.precio}€
                <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${index})">✕</button>
            `;
            lista.appendChild(li);
        });

        totalElem.textContent = total.toFixed(2);
    }

    function eliminarDelCarrito(index) {
        const carrito = obtenerCarrito();
        carrito.splice(index, 1);
        guardarCarrito(carrito);
        renderizarCarrito();
    }

    function vaciarCarrito() {
        sessionStorage.removeItem('carrito');
        renderizarCarrito();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Botones "Agregar al carrito"
        document.querySelectorAll('.agregar-carrito').forEach(btn => {
            btn.addEventListener('click', () => {
                const producto = {
                    id: btn.dataset.id,
                    nombre: btn.dataset.nombre,
                    precio: btn.dataset.precio
                };
                const carrito = obtenerCarrito();
                carrito.push(producto);
                guardarCarrito(carrito);
                renderizarCarrito();
            });
        });

        renderizarCarrito();
    });

        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
</x-app-layout>