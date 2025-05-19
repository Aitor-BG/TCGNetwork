<x-app-layout>
    @php
    $datos = json_decode($registro->properties);
    $nuevos = $datos->attributes ?? null;
    $antiguos = $datos->old ?? null;
@endphp

<td>
    @if ($nuevos)
        <strong>Nuevos valores:</strong>
        <ul class="mb-0">
            @foreach ($nuevos as $clave => $valor)
                <li><strong>{{ ucfirst($clave) }}:</strong> {{ $valor ?? 'null' }}</li>
            @endforeach
        </ul>
    @else
        <em>Sin nuevos valores</em>
    @endif
</td>

<td>
    @if ($antiguos)
        <strong>Valores antiguos:</strong>
        <ul class="mb-0">
            @foreach ($antiguos as $clave => $valor)
                <li><strong>{{ ucfirst($clave) }}:</strong> {{ $valor ?? 'null' }}</li>
            @endforeach
        </ul>
    @else
        <em>Sin valores antiguos</em>
    @endif
</td>

</x-app-layout>