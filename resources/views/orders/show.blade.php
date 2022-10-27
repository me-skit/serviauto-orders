@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-md-2">
      <div class="col-md-12 col-lg-11">
        <h2><i class="far fa-clipboard-list-check"></i> Orden de Trabajo</h2>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11">
        <div class="card mb-3">
          <div class="card-header">
            <span class="fw-bold card-title">Datos Generales</span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="row mb-md-3">
                    <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Cliente') }}</label>
                    <div class="col-md-7 col-lg-9">
                      <input type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ $order->client->name }}"
                        readonly
                      >
                    </div>
                </div>
              </div>
            
              <div class="col-lg-6">
                <div class="row mb-md-3">
                    <label for="created_at" class="col-md-3 col-form-label text-md-end">{{ __('Fecha') }}</label>
                    <div class="col-md-7 col-lg-4">
                      <input type="text"
                        name="created_at"
                        id="created_at"
                        class="form-control text-end"
                        value="{{ date_format($order->created_at, 'd/m/Y') }}"
                        readonly
                      >
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="row mb-md-3">
                    <label for="car_description" class="col-md-3 col-form-label text-md-end">{{ __('Vehículo') }}</label>
                    <div class="col-md-7 col-lg-9">
                      <input type="text"
                        name="car_description"
                        id="car_description"
                        class="form-control @error('car_description') is-invalid @enderror"
                        value="{{ $order->car_description }}"
                        readonly
                        >
                    </div>
                </div>
              </div>
            
              <div class="col-lg-6">
                <div class="row mb-3">
                    <label for="order_number" class="col-md-3 col-form-label text-md-end">No.</label>
                    <div class="col-md-7 col-lg-4">
                      <input type="text"
                        name="order_number"
                        id="order_number"
                        class="form-control text-end"
                        value="{{ str_pad($order->id, 7, '0', STR_PAD_LEFT) }}"
                        readonly
                      >
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11">
        <div class="card mb-3">
          <div class="card-header">
            <span class="fw-bold">Detalles</span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-hover table-sm" id="items-table">
                  <thead>
                    <tr>
                      <td>Cant.</td>
                      <td>Descripcion</td>
                      <td class="text-center">P/U (Q)</td>
                      <td class="text-center">Subtotal (Q)</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="body-table">
                    @foreach ($order->items_order as $item)
                      <tr>
                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end align-middle">{{ number_format($item->sell_price, 2, '.', ',') }}</td>
                        <td class="text-end align-middle">{{ number_format($item->quantity * $item->sell_price, 2, '.', ',') }}</td>
                        <td></td>                       
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <td></td>
                    <td class="text-center" colspan="2">TOTAL</td>
                    <td class="text-end" id="total-cell">
                      {{ $order->total }}
                    </td>
                    <td></td>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11 text-end">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary me-1"><i class="far fa-arrow-circle-left"></i> {{  __('Regresar') }}</a>
      </div>
    </div>
  </div>
@endsection