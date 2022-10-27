@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-lg-10 col-xl-8 d-flex justify-content-between align-items-baseline">
        <h2><i class="far fa-tools"></i> R<span class="d-none d-md-inline">epuestos</span> & S<span class="d-none d-md-inline">ervicios</span></h2>
        <div>
          <a href="{{ route('items.create') }}" class="btn btn-success"><i class="far fa-plus"></i> <span class="d-none d-md-inline">Nuevo</span></a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
        <table class="table table-hover table-sm">
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="point-200">Descripción</th>
                  <th class="text-center point-90">Costo</th>
                  <th class="text-center point-90">Precio</th>
                  <th class="text-center point-90">Acciones</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($items as $key => $item)
              <tr>
                <td class="align-middle text-center">{{ ($items->currentPage() - 1) * 10 + $key + 1 }}</td>
                <td class="align-middle">{{ $item->description }}</td>
                <td class="align-middle text-end">{{ $item->latestPrice->cost_currency_format  }}</td>
                <td class="align-middle text-end">{{ $item->latestPrice->price_currency_format }}</td>
                <td class="align-middle text-center">
                  <a href="{{ route('items.edit', $item->id ) }}" class="btn btn-primary btn-sm"><i class="far fa-pencil-alt"></i> <span class="d-none d-md-inline">Modificar</span></a>
                  <a href="{{ route('items.edit', $item->id ) . '?action=update' }}" class="btn btn-danger btn-sm"><i class="far fa-money-bill-wave"></i> <span class="d-none d-md-inline">Nuevo Precio</span></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        {{ $items->links("pagination::bootstrap-4") }}
      </div>
    </div>
  </div>
@endsection
