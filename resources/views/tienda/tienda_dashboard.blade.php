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
    </head>

    <body>
        <div class="container mt-4">
            <div class="row">
                <!-- Calendario -->
                <div class="col-md-6">
                    <div id="calendar"></div>
                </div>

                <!-- Tabla de eventos -->
                <div class="col-md-6">
                    <h4>Eventos próximos</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Evento</th>
                                <th>Inscritos</th>
                                <th>Máx. Part.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (collect($events)->sortBy('date') as $event)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}</td>
                                    <td>{{ $event['title'] }}</td>
                                    <td>{{ $event['inscritos'] ?? 0 }}</td>
                                    <td>{{ $event['participantes'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <a id="launchEventBtn" class="btn btn-success" href="#">Lanzar Evento</a>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Editar</button>
                        <input type="hidden" id="deleteEventId" name="event_id" />
                        <form id="deleteForm" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar Evento</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('tienda.events.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crear Nuevo Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Título del Evento</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Ingrese el título del evento" required>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color del Evento</label>
                                <input type="color" name="color" id="color" class="form-control" value="#000000">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción del evento</label>
                                <input type="textarea" name="description" id="description" class="form-control"
                                    placeholder="Ingresa descripción del evento" required>
                            </div>
                            <div class="mb-3">
                                <label for="participantes" class="form-label">Máximos participantes</label>
                                <input type="number" name="participantes" id="participantes" class="form-control"
                                    placeholder="Ingresa máximo de participantes" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="date" id="date" readonly>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Crear Evento</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    events: @json($events),
                    locale: 'es',
                    firstDay: 1,
                    eventClick: function (info) {
                        var event = info.event;
                        document.getElementById('eventTitle').textContent = event.title;
                        document.getElementById('eventDescription').textContent = event.extendedProps.details || 'Sin descripción';
                        document.getElementById('eventDate').textContent = event.start.toLocaleDateString('es-ES');
                        document.getElementById('eventInsc').textContent = event.extendedProps.inscritos || 0;
                        document.getElementById('eventPart').textContent = event.extendedProps.participantes || 'Determinado en tienda';

                        var launchButton = document.getElementById('launchEventBtn');
                        if (event.extendedProps.inscritos >= 4) {
                            launchButton.style.display = 'inline-block';
                            launchButton.href = '/tienda/gesTorneo/' + event.id;
                        } else {
                            launchButton.style.display = 'none';
                            launchButton.href = '#';
                            console.warn('ID del evento no definido');
                        }

                        document.getElementById('deleteForm').action = '/tienda/eventos/' + event.id + '/eliminar';

                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    },
                    dateClick: function (info) {
                        document.getElementById('date').value = info.dateStr;

                        var createModal = new bootstrap.Modal(document.getElementById('createEventModal'));
                        createModal.show();
                    },

                });

                calendar.render();
            });


        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>