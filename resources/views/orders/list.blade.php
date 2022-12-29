<div class="table-responsive">
  <table class="table table-hover table-sm">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th>Descripción</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Totales</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($list as $key => $order)
        <tr>
          <td  class="align-middle text-center">{{ ($list->currentPage() - 1) * $list->perPage() + $key + 1 }}</td>
          <td class="align-middle text-truncate">{{ $order->car->brand . ' ' . $order->car->line . ' ' . $order->car->color }}<span class="d-none d-md-inline">{{ ', año ' . $order->car->year }}</span><span class="d-none d-sm-inline">{{ ', ' . $order->car->plate }}</span></td>
          <td class="align-middle text-center">{{ date_format(date_create($order->date), 'd/m/Y') }}</td>
          <td class="align-middle text-end text-truncate">{{ $order->total }}</td>
          <td class="align-middle text-center text-truncate">
            <a href="{{ route('orders.show', $order->id) . '?code=' . $client->id }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i><span class="d-none d-lg-inline"> Detalles</span></a>

            @if (!$order->finished)
              <a href="{{ route('orders.edit', $order->id) . '?code=' . $client->id }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Modificar</span></a>                
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
