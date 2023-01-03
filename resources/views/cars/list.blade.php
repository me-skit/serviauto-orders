<div class="table-responsive">
  <table class="table table-hover table-sm">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th>Marca</th>
            <th>Linea</th>
            <th>Año</th>
            <th>Color</th>
            <th>Placas</th>
            <th>Servicio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($car_list as $key => $car)
        <tr>
          <td  class="align-middle text-center">{{ ($car_list->currentPage() - 1) * $car_list->perPage() + $key + 1 }}</td>
          <td class="align-middle">{{ $car->brand }}</td>
          <td class="align-middle">{{ $car->line }}</td>
          <td class="align-middle">{{ $car->year }}</td>
          <td class="align-middle">{{ $car->color }}</td>
          <td class="align-middle">{{ $car->plate }}</td>
          <td class="align-middle">
            @if ($car->next_service)
              <a href="{{ $car->service->finished ? route("orders.show", $car->service->id) . '?tab=cars&code=' . $client->id : route("orders.edit", $car->service->id) . '?tab=cars&code=' . $client->id }}">{{ number_format($car->next_service) }}</a>
            @endif
          </td>
          <td class="align-middle text-truncate">
            <a href="{{ route('cars.edit', $car) . '?code=' . $client->id }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Modificar</span></a>
            <a href="#" class="btn btn-danger btn-sm btn-delcar" data-bs-toggle="modal" data-bs-target="#delCarModal" data-car="{{ $car->id }}"><i class="fas fa-trash-alt"></i><span class="d-none d-lg-inline"> Eliminar</span></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
