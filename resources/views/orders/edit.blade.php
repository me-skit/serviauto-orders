@extends('layouts.app')

@section('content')
  <div class="container">
    <form id="order-form" action="{{ route('orders.update', $order->id) }}" method="POST">
      @csrf
      @method('PATCH')

      <div class="row justify-content-center mb-md-2">
        <div class="col-md-12 col-lg-11">
          <h2><i class="far fa-clipboard-list"></i> Editar Orden<span class="d-none d-md-inline"> de Trabajo</span></h2>
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
                      <label for="client_name" class="col-md-3 col-form-label text-md-end">{{ __('Cliente') }}<span class="text-danger">*</span></label>
                      <div class="col-md-7 col-lg-9">
                        <input class="form-control" 
                          list="clientList" 
                          name="client_name"
                          id="client_name"
                          value="{{ old('client_name') ?? $order->client->name }}"
                          placeholder="Nombre del cliente..."
                          required
                        >
                        <datalist id="clientList" type="hidden">
                          @foreach ($clients as $client)
                            <option data-value="{{ $client->id }}">{{ $client->name }}</option>
                          @endforeach
                        </datalist>
                        <input type="hidden" name="client_id" id="client_id" value="{{  old('client_id') ?? $order->client->id }}">
                      </div>
                  </div>
                </div>
              
                <div class="col-lg-6">
                  <div class="row mb-md-3">
                      <label for="today_date" class="col-md-3 col-form-label text-md-end">{{ __('Fecha') }}</label>
                      <div class="col-md-7 col-lg-4">
                        <input type="text"
                          name="today_date"
                          id="today_date"
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
                      <label for="car_description" class="col-md-3 col-form-label text-md-end">{{ __('Vehículo') }}<span class="text-danger">*</span></label>
                      <div class="col-md-7 col-lg-9">
                        <input type="text"
                          name="car_description"
                          id="car_description"
                          class="form-control @error('car_description') is-invalid @enderror"
                          value="{{ old('car_description') ?? $order->car_description }}"
                          placeholder="Descripción del vehículo"
                          required
                          >

                          @error('car_description')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
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

      @include('orders.editdetails')

      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-11 text-end">
          <a href="{{ route('orders.index') }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{  __('Cancelar') }}</a>
          <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Guardar') }}</button>
        </div>
      </div>

    </form>
  </div>
@endsection