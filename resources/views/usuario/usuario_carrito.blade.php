<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Finalizar Compra</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        @php
            $route = Auth::user()->role . '.dashboard';
        @endphp

        <div class="container mt-5">
            <div class="row">
                <!-- Formulario de Facturación -->
                <div class="col-md-9">
                    <h4>Datos de Facturación</h4>
                    <form id="form-facturacion" class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cp" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="cp" pattern="\d{5}" maxlength="5" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" pattern="\d{9}" maxlength="9"
                                required>
                        </div>

                    </form>

                    <div class="mt-3">
                        <a id="btn-pagar" class="btn btn-success disabled" onclick="vaciarCarrito()">
                            Pago y envío
                        </a>
                    </div>
                </div>

                <!-- Carrito -->
                <div class="col-md-3 carrito">
                    <h4><x-bi-cart /> Carrito</h4>
                    <ul id="lista-carrito" class="list-group mb-3"></ul>
                    <p><strong>Total: <span id="total">0</span> €</strong></p>
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

            /*function vaciarCarrito() {
                sessionStorage.removeItem('carrito');
                renderizarCarrito();
            }*/

            /*function vaciarCarrito() {
                const carrito = obtenerCarrito();

                fetch('/usuario/tienda/carrito/compra', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ items: carrito })
                })
                    .then(res => {
                        if (!res.ok) throw new Error('Error procesando la compra');
                        return res.json();
                    })
                    .then(data => {
                        alert(data.message);
                        sessionStorage.removeItem('carrito');
                        renderizarCarrito();
                        // Redirigir al dashboard del rol actual
                        window.location.href = "{{ route($route) }}";
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Hubo un error al procesar tu compra');
                    });
            }*/

            function vaciarCarrito() {
    const carrito = obtenerCarrito();

    if (carrito.length === 0) {
        alert('El carrito está vacío.');
        return;
    }

    const nombre = document.getElementById('nombre').value.trim();
    const direccion = document.getElementById('direccion').value.trim();
    const ciudad = document.getElementById('ciudad').value.trim();
    const codigo_postal = document.getElementById('cp').value.trim();
    const telefono = document.getElementById('telefono').value.trim();

    if (!nombre || !direccion || !ciudad || !codigo_postal || !telefono) {
        alert("Completa todos los campos de facturación.");
        return;
    }

    fetch('/guardar-pedido', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre,
            direccion: direccion,
            ciudad: ciudad,
            'codigo-postal': codigo_postal,
            telefono: telefono,
            contenido: carrito
        })
    })
        .then(res => {
            if (!res.ok) throw new Error('Error procesando la compra');
            return res.json();
        })
        .then(data => {
            alert(data.message);
            sessionStorage.removeItem('carrito');
            renderizarCarrito();
            window.location.href = "{{ route($route) }}";
        })
        .catch(err => {
            console.error(err);
            alert('Hubo un error al procesar tu compra');
        });
}




            function validarFormulario() {
                const form = document.getElementById('form-facturacion');
                const campos = form.querySelectorAll('input');
                let valido = true;

                campos.forEach(campo => {
                    if (!campo.value.trim()) {
                        valido = false;
                    }
                });

                const botonPagar = document.getElementById('btn-pagar');
                botonPagar.classList.toggle('disabled', !valido);
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('form-facturacion').querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', validarFormulario);
                });

                const telefonoInput = document.getElementById('telefono');
                const cpInput = document.getElementById('cp')

                telefonoInput.addEventListener('input', () => {
                    telefonoInput.value = telefonoInput.value.replace(/\D/g, '').slice(0, 9);
                });

                cpInput.addEventListener('input', () => {
                    cpInput.value = cpInput.value.replace(/\D/g, '').slice(0, 9);
                });

                renderizarCarrito();
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>