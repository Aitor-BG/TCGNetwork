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
                        <a id="launchEventBtn" class="btn btn-success" href="#">Lanzar Evento</a>
                        <button type="button" id="deleteEventBtn" class="btn btn-danger" (click)="event.remov"
                            data-id="">Eliminar Evento</button>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Editar</button>
                    </div>
                </div>
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
                        document.getElementById('eventDate').textContent = event.start.toLocaleString();
                        document.getElementById('eventInsc').textContent = event.extendedProps.inscritos || 0;
                        document.getElementById('eventPart').textContent = event.extendedProps.participantes || 'Determinado en tienda';

                        var launchButton = document.getElementById('launchEventBtn');
                        if (event.extendedProps.inscritos > 0) {
                            launchButton.style.display = 'inline-block';
                            launchButton.href = '/tienda/gesTorneo/' + event.id;
                        } else {
                            launchButton.style.display = 'none';
                            launchButton.href = '#';
                            console.warn('ID del evento no definido');
                        }


                        var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                        myModal.show();
                    }
                });

                calendar.render();
            });

        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>