<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8">
    {{ $items->links("pagination::bootstrap-4") }}
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
    <table class="table table-hover table-sm">
      <thead>
          <tr>
              <th class="text-center">No.</th>
              <th >Descripción</th>
              <th class="text-center">Precio</th>
              <th class="text-center">Acciones</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($items as $key => $item)
          <tr>
            <td class="align-middle text-center">{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
            <td class="align-middle text-truncate">{{ $item->description }}</td>
            <td class="align-middle text-end text-truncate">{{ $item->formatted_price }}</td>
            <td class="align-middle text-center text-truncate">
              <a href="{{ route('items.edit', $item->id ) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline"> Modificar</span></a>
              <a href="#" class="btn btn-danger btn-sm btn-delitem" data-bs-toggle="modal" data-bs-target="#delItemModal" data-item="{{ $item->id }}"><i class="fas fa-trash-alt"></i><span class="d-none d-lg-inline"> Eliminar</span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>