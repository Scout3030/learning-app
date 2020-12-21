<thead>
    <tr class="text-center">
        <th>{{ __("#ID") }}</th>
        <th>{{ __("Coste total") }}</th>
        <th>{{ __("Cupón") }}</th>
        <th>{{ __("Fecha del pedido") }}</th>
        <th>{{ __("Estado") }}</th>
        <th>{{ __("Número de cursos") }}</th>
        @if(!$detail)
            <th>{{ __("Acciones") }}</th>
        @endif
    </tr>
</thead>
