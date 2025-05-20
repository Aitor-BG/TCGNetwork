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
            <button onclick="openCreateModal()" class="btn btn-success">Agregar Producto</button>
            <br>
            <br>
            <div class="row">
                @foreach ($productos as $producto)
                    <!--@if($producto['user_name'] === Auth::user()->username)-->
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 100%;">
                                <img src="..." class="card-img-top" alt="Imagen del producto">
                                <div class="card-body text-center">
                                    <h4 class="card-title">{{ $producto['nombre'] }}</h4>
                                    <p class="card-text">{{ $producto['descripcion'] }}</p>
                                    <p>{{ $producto['precio'] }}€</p>
                                    @if ($producto['cantidad'] < 5)
                                        <p style="color: red;">Últimas unidades</p>
                                    @endif

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button class="btn btn-danger btn-sm"
                                            onclick="actualizarStock({{ $producto['id'] }}, 'disminuir', this)">-</button>
                                        <span id="cantidad-{{ $producto['id'] }}">{{ $producto['cantidad'] }}</span>
                                        <button class="btn btn-success btn-sm"
                                            onclick="actualizarStock({{ $producto['id'] }}, 'incrementar', this)">+</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <!--@endif-->
                @endforeach
            </div>
        </div>

        <!-- Modal Crear Producto -->
        <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('tienda.producto.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createProductModalLabel">Nuevo Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" id="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio (€)</label>
                                <input type="number" name="precio" class="form-control" id="precio" step="0.01"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad en stock</label>
                                <input type="number" name="cantidad" class="form-control" id="cantidad" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function actualizarStock(id, accion) {
                fetch(`/tienda/stock/${id}/${accion}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Error de servidor');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (accion === 'disminuir' && data.cantidad <= 0) {
                            document.getElementById('cantidad-' + id).textContent = 0;
                        } else {
                            document.getElementById('cantidad-' + id).textContent = data.cantidad;
                        }
                    })
                    .catch(err => {
                        console.error("Error al actualizar el stock:", err);
                        alert("Error al actualizar el stock.");
                    });
            }

            function openCreateModal() {
                const modal = new bootstrap.Modal(document.getElementById('createProductModal'));
                modal.show();
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>