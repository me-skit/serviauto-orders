<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8">
    {{ $clients->links("pagination::bootstrap-4") }}
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
    <table class="table table-hover table-sm">
      <thead>
          <tr>
              <th class="text-center">#</th>
              <th>Nombre</th>
              <th>Teléfono(s)</th>
              <th class="text-center">Acciones</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($clients as $key => $client)
          <tr>
            <td class="align-middle text-center">{{ ($clients->currentPage() - 1) * 10 + $key + 1 }}</td>
            <td class="align-middle">{{ $client->name }}</td>
            <td class="align-middle">{{ $client->phone_number }}</td>
            <td class="text-center">
              <a href="{{ route('clients.show', $client->id ) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i><span class="d-none d-md-inline"> Detalles</span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
