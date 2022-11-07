<div class="table-responsive">
  <table class="table table-hover table-sm">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="point-100">Descripción</th>
            <th class="text-center">Fecha</th>
            <th class="text-center point-90">Totales</th>
            <th class="text-center point-85">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($order_list as $key => $order)
        <tr>
          <td  class="align-middle text-center">{{ ($order_list->currentPage() - 1) * $order_list->perPage() + $key + 1 }}</td>
          <td class="align-middle">{{ $order->car_description }}</td>
          <td class="align-middle text-center">{{ date_format($order->created_at, 'd/m/Y') }}</td>
          <td class="align-middle text-end">{{ $order->total }}</td>
          <td class="align-middle text-center">
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary btn-sm"><i class="far fa-eye"></i><span class="d-none d-md-inline"> Detalles</span></a>
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm"><i class="far fa-pencil-alt"></i><span class="d-none d-md-inline"> Modificar</span></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
