<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logs</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registros de Actividad') }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded p-6 overflow-x-auto">
                @if ($logs->count())
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-3 text-gray-700 uppercase text-sm font-medium">Fecha</th>
                                <th class="text-left px-4 py-3 text-gray-700 uppercase text-sm font-medium">Descripción</th>
                                <th class="text-left px-4 py-3 text-gray-700 uppercase text-sm font-medium">Usuario</th>
                                <th class="text-left px-4 py-3 text-gray-700 uppercase text-sm font-medium">Modelo</th>
                                <th class="text-left px-4 py-3 text-gray-700 uppercase text-sm font-medium max-w-2xl">
                                    Cambios</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($logs as $registro)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $registro->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-700">
                                        {{ $registro->description }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ optional($registro->causer)->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ class_basename($registro->subject_type) }}
                                        (ID: {{ $registro->subject_id ?? 'N/A' }})
                                        @if (isset($registro->properties['attributes']['name']))
                                            - "{{ $registro->properties['attributes']['name'] }}"
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-700 max-w-2xl">
                                        @php
                                            $atributos = $registro->properties['attributes'] ?? [];
                                            $anteriores = $registro->properties['old'] ?? [];
                                            $cambios = [];
                                        @endphp

                                        @if (!empty($atributos))
                                            @foreach ($atributos as $key => $nuevoValor)
                                                @php
                                                    $valorAnterior = $anteriores[$key] ?? null;
                                                @endphp

                                                @if (!isset($anteriores[$key]))
                                                    @php
                                                        $cambios[] = ucfirst($key) . ": Añadido → " . $nuevoValor;
                                                    @endphp
                                                @elseif ($valorAnterior != $nuevoValor)
                                                    @php
                                                        $cambios[] = ucfirst($key) . ": " . $valorAnterior . " → " . $nuevoValor;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            {{ implode(', ', $cambios) }}
                                        @else
                                            <span class="italic text-gray-400">Sin cambios detallados</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-500 py-6">No hay registros de actividad para mostrar.</p>
                @endif
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</x-app-layout>