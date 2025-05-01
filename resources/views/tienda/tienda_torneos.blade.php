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
            <h2 class="mb-4">Crear Evento</h2>
            <form action="{{ route('tienda.events.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title" class="form-label">Título del Evento</label>
                    <input type="text" name="title" id="title" class="form-control"
                        placeholder="Ingrese el título del evento" required>
                </div>
                <!--<div class="form-group">
                    <label for="start_date" class="form-label">Fecha de Inicio</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="end_date" class="form-label">Fecha de Fin</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                </div>-->
                <div class="form-group">
                    <label for="date" class="form-label">Fecha de Fin</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="color" class="form-label">Color del Evento</label>
                    <input type="color" name="color" id="color" class="form-control" value="#000000">
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Descripción del evento</label>
                    <input type="textarea" name="description" id="description" class="form-control"
                        placeholder="Ingresa descripción del evento" required>
                </div>
                <div class="form-group">
                    <label for="participantes" class="form-label">Máximos participantes</label>
                    <input type="number" name="participantes" id="participantes" class="form-control"
                        placeholder="Ingresa máximo de participantes" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Guardar Evento</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>