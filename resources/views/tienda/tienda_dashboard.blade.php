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
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#ModalAdd">Crear Evento</button>
        </div>

        <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAddLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('tienda.events.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Título del Evento</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Evento</button>
                    </form>


                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today'
                    },
                    events: @json($events),
                    locale: 'es',
                    firstDay: 1
                });

                calendar.render();
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>