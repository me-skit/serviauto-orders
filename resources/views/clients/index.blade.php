@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-lg-10 col-xl-8 d-flex justify-content-between align-items-baseline">
        <h2><i class="far fa-user-friends"></i> Clientes</h2>
        <div>
          <a href="{{ route('clients.create') }}" class="btn btn-success"><i class="far fa-plus"></i><span class="d-none d-md-inline"> Nuevo</span></a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
        <table class="table table-hover table-sm">
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="point-175">Nombre</th>
                  <th class="point-85">Teléfono(s)</th>
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
                    <a href="{{ route('clients.edit', $client->id ) }}" class="btn btn-primary btn-sm"><i class="far fa-pencil-alt"></i> <span class="d-none d-md-inline">Modificar</span></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        {{ $clients->links("pagination::bootstrap-4") }}
      </div>
    </div>
  </div>
@endsection