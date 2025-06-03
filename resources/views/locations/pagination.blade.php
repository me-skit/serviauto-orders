<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8">
    {{ $locations->links("pagination::bootstrap-4") }}
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
    <table class="table table-hover table-sm">
      <thead>
          <tr>
              <th class="text-center">No.</th>
              <th >Lugar</th>
              <th class="text-center">Dirección</th>
              <th class="text-center">Teléfono</th>
              <th class="text-center">Acciones</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($locations as $key => $location)
          <tr>
            <td class="align-middle text-center">{{ ($locations->currentPage() - 1) * $locations->perPage() + $key + 1 }}</td>
            <td class="align-middle text-truncate">{{ $location->location }}</td>
            <td class="align-middle text-end text-truncate">{{ $location->address }}</td>
            <td class="align-middle text-end text-truncate">{{ $location->phone }}</td>
            <td class="align-middle text-center text-truncate">
              <a href="{{ route('locations.edit', $location->id ) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Modificar</span></a>
              <a href="#" class="btn btn-danger btn-sm btn-dellocation" data-bs-toggle="modal" data-bs-target="#delLocationModal" data-location="{{ $location->id }}"><i class="fas fa-trash-alt"></i><span class="d-none d-lg-inline"> Eliminar</span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>