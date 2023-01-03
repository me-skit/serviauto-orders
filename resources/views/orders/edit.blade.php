@extends('layouts.app')

@section('content')
  <div class="container">
    <form id="order-form" action="{{ route('orders.update', $order->id) . '?code=' . $client->id . ($tab ? '&tab=' . $tab : '') }}" method="POST">
      @csrf
      @method('PATCH')

      <div class="row justify-content-center mb-md-2">
        <div class="col-md-12 col-lg-11 d-flex justify-content-between">
          <h2><i class="fas fa-clipboard-list"></i> Editar Orden<span class="d-none d-md-inline"> de Trabajo</span></h2>
          <a href="#" class="btn btn-danger align-self-center{{ $order->items->count() ? ' disabled' : '' }}" role="button" aria-disabled="{{ $order->items->count() ? 'false' : 'true' }}" data-bs-toggle="modal" data-bs-target="#delOrderModal">
            <i class="fas fa-trash-alt"></i>
            <span class="d-none d-md-inline"> Eliminar</span>
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
                <div class="col-lg-7 col-xl-6">
                  <div class="row mb-md-3">
                    <label for="client" class="col-md-3 col-form-label text-md-end">{{ __('Cliente') }}<span class="text-danger">*</span></label>
                    <div class="col-md-7 col-lg-9">
                      <input type="text"
                        name="client"
                        id="client"
                        class="form-control"
                        value="{{ $client->name }}"
                        readonly
                      >
                    </div>
                  </div>
                </div>
              
                <div class="col-lg-5 col-xl-6">
                  <div class="row mb-md-3">
                    <label for="date" class="col-md-3 col-form-label text-md-end">{{ __('Fecha') }}<span class="text-danger">*</span></label>
                    <div class="col-md-7 col-lg-6 col-xl-4">
                      <input type="date"
                        name="date"
                        id="date"
                        class="form-control text-end"
                        value="{{ old('date') ?? $order->date }}"
                        required
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-7 col-xl-6">
                  <div class="row mb-md-3">
                    <label for="car_id" class="col-md-3 col-form-label text-md-end">{{ __('Vehículo') }}<span class="text-danger">*</span></label>
                    <div class="col-md-7 col-lg-9">
                      <select name="car_id" class="form-select" required>
                        @foreach ($client->cars as $car)
                          <option value="{{ $car->id }}" {{ $car->id == $order->car_id ? 'selected' : '' }}>{{ $car->description }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
             
                <div class="col-lg-5 col-xl-6">
                  <div class="row mb-3">
                      <label for="order_number" class="col-md-3 col-form-label text-md-end">No.</label>
                      <div class="col-md-7 col-lg-6 col-xl-4">
                        <input type="text"
                          name="order_number"
                          id="order_number"
                          class="form-control text-end"
                          value="{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}"
                          readonly
                        >
                      </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-7 col-xl-6">
                  <div class="row mb-md-3">
                    <label for="next_service" class="col-md-3 col-form-label text-md-end">Sig. Servicio</label>
                    <div class="col-md-7 col-lg-9">
                      <input type="text"
                        name="next_service"
                        id="next_service"
                        class="form-control"
                        value="{{ ($order->car->service_id and $order->car->service_id == $order->id) ? number_format($order->car->next_service) : '' }}"
                        pattern="(([1-9]{1,3}(,\d{3})*)|([1-9]\d*))"
                        title="Deben números como 1,000 o 1,000,000"
                        placeholder="Siguente servicio"
                      >
                    </div>
                  </div>
                </div>
              
                <div class="col-lg-5 col-xl-6">
                  <div class="row mb-3">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('orders.editdetails')

      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-11 text-end">
          <a href="{{ route('clients.show', $client) . ($tab ? '?tab=' . $tab : '') }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{  __('Cancelar') }}</a>
          <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Guardar') }}</button>
        </div>
      </div>

    </form>
  </div>

  @include('orders.modal-delete')
@endsection