@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-lg-10 col-xl-8 d-flex justify-content-between align-items-baseline">
        <h2><i class="far fa-clipboard-list"></i> Ordenes<span class="d-none d-md-inline"> de Trabajo</span></h2>
        <div>
          <a href="{{ route('orders.create') }}" class="btn btn-success"><i class="far fa-plus"></i><span class="d-none d-md-inline"> Nueva</span></a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8 table-responsive">
        <table class="table table-hover table-sm">
          <thead>
              <tr>
                  <th class="text-center">No.</th>
                  <th class="point-150">Cliente</th>
                  <th class="point-100">Descripción</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center point-90">Totales</th>
                  <th class="text-center point-85">Acciones</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr>
                <td  class="align-middle text-center">{{ $order->id }}</td>
                <td class="align-middle">{{ $order->client->name }}</td>
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
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        {{ $orders->links("pagination::bootstrap-4") }}
      </div>
    </div>    
  </div>
@endsection