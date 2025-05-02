<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendario</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Detalles del Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <h5 id="eventTitle"></h5>
                        <p id="eventDescription"></p>
                        <p><strong>Fecha:</strong> <span id="eventDate"></span></p>
                        <p><strong>Participantes:</strong> <span id="eventInsc"></span>/<span id="eventPart"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnInscribir">Inscribirme</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--<script>
                    document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: { left: 'prev', center: 'title', right: 'next' },
                    events: @json($events),
            locale: 'es',
                firstDay: 1,
                    eventClick: function (info) {
                        var event = info.event;
                        document.getElementById('eventTitle').textContent = event.title;
                        document.getElementById('eventDescription').textContent = event.extendedProps.details || 'Sin descripción';
                        document.getElementById('eventDate').textContent = event.start.toLocaleString();

                        let inscritos = event.extendedProps.inscritos ? event.extendedProps.inscritos.split(',') : [];
                        document.getElementById('eventInsc').textContent = inscritos.length;
                        document.getElementById('eventPart').textContent = event.extendedProps.participantes || 'Determinado en tienda';

                        document.getElementById('btnInscribir').setAttribute('data-event-id', event.id);

                        console.log(event.id)

                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    }
                });

            calendar.render();

            document.getElementById('btnInscribir').addEventListener('click', function () {
                let eventId = this.getAttribute('data-event-id');
                console.log("ID del evento:", eventId); // Verifica el ID

                fetch("{{ route('usuario.inscribir') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ event_id: eventId })
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log("Respuesta del servidor:", data);
                        return JSON.parse(data);
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            location.reload();
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            });
        </script>-->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: { left: 'prev', center: 'title', right: 'next' },
                    events: @json($events),
                    locale: 'es',
                    firstDay: 1,
                    eventClick: function (info) {
                        var event = info.event;
                        document.getElementById('eventTitle').textContent = event.title;
                        document.getElementById('eventDescription').textContent = event.extendedProps.details || 'Sin descripción';
                        document.getElementById('eventDate').textContent = event.start.toLocaleString('es-ES');

                        let inscritos = event.extendedProps.inscritos ? event.extendedProps.inscritos.split(',') : [];
                        document.getElementById('eventInsc').textContent = inscritos.length;
                        document.getElementById('eventPart').textContent = event.extendedProps.participantes || 'Determinado en tienda';

                        document.getElementById('btnInscribir').setAttribute('data-event-id', event.id);

                        let username = '{{ auth()->user()->username }}';
                        let btn = document.getElementById('btnInscribir');

                        if (inscritos.length === event.extendedProps.participantes && !inscritos.includes(username)) {
                            // Si el evento está lleno y el usuario no está inscrito, ocultar botón
                            btn.style.display = 'none';
                            btn.href = '#';
                        } else {
                            // Mostrar y ajustar el botón según si el usuario está inscrito o no
                            btn.style.display = ''; // Mostrar el botón por si estaba oculto

                            if (inscritos.includes(username)) {
                                btn.textContent = 'Desinscribirme';
                                btn.classList.remove('btn-success');
                                btn.classList.add('btn-danger');
                            } else {
                                btn.textContent = 'Inscribirme';
                                btn.classList.remove('btn-danger');
                                btn.classList.add('btn-success');
                            }
                        }


                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    }
                });

                calendar.render();

                document.getElementById('btnInscribir').addEventListener('click', function () {
                    let eventId = this.getAttribute('data-event-id');
                    console.log("ID del evento:", eventId); // Verifica el ID

                    fetch("{{ route('usuario.inscribir') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ event_id: eventId })
                    })
                        .then(response => response.json()) // Cambiado a json para manejar la respuesta correctamente
                        .then(data => {
                            console.log("Respuesta del servidor:", data);

                            if (data.success) {
                                alert(data.success);
                                // Cambiar el texto del botón según el estado de inscripción
                                if (data.inscrito) {
                                    document.getElementById('btnInscribir').textContent = 'Desinscribirme';
                                } else {
                                    document.getElementById('btnInscribir').textContent = 'Inscribirme';
                                }
                                location.reload(); // Recargar la página para reflejar los cambios
                            } else {
                                alert(data.error);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>