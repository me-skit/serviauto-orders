@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-header">
            <span class="fw-bold"><i class="far fa-user-edit"></i> {{ __('Modificar Datos de Cliente') }}</span>
          </div>
          <div class="card-body">
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group row mb-3">
                <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Nombre') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') ?? $client->name }}"
                    placeholder="Nombre del cliente"
                    required
                    autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="phone_number" class="col-md-3 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                <div class="col-md-7">
                  <input type="text"
                    name="phone_number"
                    id="phone_number"
                    class="form-control @error('phone_number') is-invalid @enderror"
                    value="{{ old('phone_number') ?? $client->phone_number }}"
                    placeholder="Número de teléfono">

                  @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>              

              <div class="row">
                <div class="col-md-10 text-end">
                  <a href="{{ route('clients.index') }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{ __('Cancelar') }}</a>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Guardar')}}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection