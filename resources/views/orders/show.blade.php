@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-md-2">
      <div class="col-md-12 col-lg-11 d-flex justify-content-between">
        <h2><i class="far fa-clipboard-list-check"></i> Orden de Trabajo</h2>
        <a href="#" class="btn btn-warning align-self-center{{ $order->items->count() ? '' : ' disabled' }}" role="button" aria-disabled="{{ $order->items->count() ? 'false' : 'true' }}" data-bs-toggle="modal" data-bs-target="#finishOrderModal">
          <i class="fas fa-calendar-check"></i>
          <span class="d-none d-md-inline"> Finalizar</span>
        </a>
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
                    <label for="date" class="col-md-3 col-form-label text-md-end">{{ __('Fecha') }}</label>
                    <div class="col-md-7 col-lg-4">
                      <input type="date"
                        name="date"
                        id="date"
                        class="form-control text-end"
                        value="{{ $order->date }}"
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
                        value="{{ $order->car->description }}"
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
                      <td>Artículo o Servicio</td>
                      <td class="text-center">P/U (Q)</td>
                      <td class="text-center">Subtotal (Q)</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="body-table">
                    @foreach ($order->items as $item)
                      <tr>
                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end align-middle">{{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="text-end align-middle">{{ number_format($item->quantity * $item->price, 2, '.', ',') }}</td>
                        <td></td>                       
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <td></td>
                    <td class="text-center" colspan="2">TOTAL</td>
                    <td class="text-end text-truncate" id="total-cell">
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
        <a href="{{ route('clients.show', $code) }}" class="btn btn-secondary me-1"><i class="far fa-arrow-circle-left"></i> {{  __('Regresar') }}</a>
      </div>
    </div>
  </div>
  
  @include('orders.modal-finish')
@endsection