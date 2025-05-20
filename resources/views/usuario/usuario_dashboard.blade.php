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
                <div class="col-md-6 mb-4">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-6">
                    @php
                        $username = auth()->user()->username;

                        $eventos = collect($events);

                        $eventosInscrito = $eventos->filter(function ($event) use ($username) {
                            $inscritos = is_array($event['inscritos']) ? $event['inscritos'] : explode(',', $event['inscritos'] ?? '');
                            return in_array($username, $inscritos);
                        })->sortBy('date');

                        $eventosNoInscrito = $eventos->filter(function ($event) use ($username) {
                            $inscritos = is_array($event['inscritos']) ? $event['inscritos'] : explode(',', $event['inscritos'] ?? '');
                            return !in_array($username, $inscritos);
                        })->sortBy('date');
                    @endphp

                    <h4>Eventos participando</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Evento</th>
                                    <th>Inscritos</th>
                                    <th>Máx. Part.</th>
                                    <th>Información</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosInscrito as $event)
                                    @php
                                        $inscritos = is_array($event['inscritos']) ? $event['inscritos'] : explode(',', $event['inscritos'] ?? '');
                                    @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}</td>
                                        <td>{{ $event['title'] }}</td>
                                        <td>{{ count($inscritos) }}</td>
                                        <td>{{ $event['participantes'] ?? 'N/A' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-info-evento"
                                                data-title="{{ $event['title'] }}"
                                                data-description="{{ $event['details'] ?? 'Sin descripción' }}"
                                                data-date="{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}"
                                                data-participantes="{{ $event['participantes'] ?? 'N/A' }}"
                                                data-inscritos="{{ is_array($event['inscritos']) ? implode(',', $event['inscritos']) : ($event['inscritos'] ?? '') }}"
                                                data-tienda="{{ $event['user_name'] ?? 'Desconocido' }}"
                                                data-event-id="{{ $event['id'] }}">Info</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No estás inscrito en ningún evento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h4>Eventos por participar</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Evento</th>
                                    <th>Información</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosNoInscrito as $event)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}</td>
                                        <td>{{ $event['title'] }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-info-evento"
                                                data-title="{{ $event['title'] }}"
                                                data-description="{{ $event['details'] ?? 'Sin descripción' }}"
                                                data-date="{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}"
                                                data-participantes="{{ $event['participantes'] ?? 'N/A' }}"
                                                data-inscritos="{{ is_array($event['inscritos']) ? implode(',', $event['inscritos']) : ($event['inscritos'] ?? '') }}"
                                                data-tienda="{{ $event['user_name'] ?? 'Desconocido' }}"
                                                data-event-id="{{ $event['id'] }}">Info</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Estás inscrito en todos los eventos.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
                        <p><strong>Tienda Organizadora:</strong> <span id="eventTienda"></span></p>
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('calendar');

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: { left: 'prev', center: 'title', right: 'next' },
                    events: @json($events),
                    locale: 'es',
                    firstDay: 1,
                    eventClick: function (info) {
                        const event = info.event;
                        const inscritos = event.extendedProps.inscritos ? event.extendedProps.inscritos.split(',') : [];
                        const username = '{{ auth()->user()->username }}';
                        const btn = document.getElementById('btnInscribir');

                        // Rellenar modal
                        document.getElementById('eventTitle').textContent = event.title;
                        document.getElementById('eventDescription').textContent = event.extendedProps.details || 'Sin descripción';
                        document.getElementById('eventDate').textContent = event.start.toLocaleString('es-ES');
                        document.getElementById('eventInsc').textContent = inscritos.length;
                        document.getElementById('eventPart').textContent = event.extendedProps.participantes || 'Determinado en tienda';
                        document.getElementById('eventTienda').textContent = event.extendedProps.user_name;
                        btn.setAttribute('data-event-id', event.id);

                        // Mostrar/ocultar botón Inscribirme
                        if (inscritos.length == event.extendedProps.participantes && !inscritos.includes(username)) {
                            btn.style.display = 'none';
                        } else {
                            btn.style.display = '';
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

                        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    }
                });

                calendar.render();

                // Botón Inscribir
                document.getElementById('btnInscribir').addEventListener('click', function () {
                    const eventId = this.getAttribute('data-event-id');

                    fetch("{{ route('usuario.inscribir') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ event_id: eventId })
                    })
                        .then(response => response.json())
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

                // BOTONES "INFO" DE TABLA "NO APUNTADO"
                document.querySelectorAll('.btn-info-evento').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        const inscritos = this.dataset.inscritos ? this.dataset.inscritos.split(',') : [];
                        const username = '{{ auth()->user()->username }}';
                        const btnInscribir = document.getElementById('btnInscribir');

                        // Rellenar modal
                        document.getElementById('eventTitle').textContent = this.dataset.title;
                        document.getElementById('eventDescription').textContent = this.dataset.description;
                        document.getElementById('eventDate').textContent = this.dataset.date;
                        document.getElementById('eventInsc').textContent = inscritos.length;
                        document.getElementById('eventPart').textContent = this.dataset.participantes;
                        document.getElementById('eventTienda').textContent = this.dataset.tienda;
                        btnInscribir.setAttribute('data-event-id', this.dataset.eventId);

                        // Mostrar/ocultar botón Inscribirme
                        if (inscritos.length == this.dataset.participantes && !inscritos.includes(username)) {
                            btnInscribir.style.display = 'none';
                        } else {
                            btnInscribir.style.display = '';
                            if (inscritos.includes(username)) {
                                btnInscribir.textContent = 'Desinscribirme';
                                btnInscribir.classList.remove('btn-success');
                                btnInscribir.classList.add('btn-danger');
                            } else {
                                btnInscribir.textContent = 'Inscribirme';
                                btnInscribir.classList.remove('btn-danger');
                                btnInscribir.classList.add('btn-success');
                            }
                        }

                        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    });
                });
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>