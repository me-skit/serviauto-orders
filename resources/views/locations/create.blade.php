@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-header">
            <span class="fw-bold"><i class="far fa-car-mechanic"></i> Agregar Taller</span>
          </div>
          <div class="card-body">
            <form action="{{ route('locations.store') }}" method="POST">
              @csrf

              <div class="form-group row mb-3">
                <label for="location" class="col-md-3 col-form-label text-md-end">{{ __('Lugar') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="location"
                    id="location"
                    class="form-control @error('location') is-invalid @enderror"
                    value="{{ old('location') }}"
                    placeholder="Lugar del taller"
                    required
                    autofocus>

                  @error('location')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="address" class="col-md-3 col-form-label text-md-end">{{ __('Dirección') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="address"
                    id="address"
                    class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address') }}"
                    placeholder="Dirección del taller"
                    required>

                  @error('address')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="phone" class="col-md-3 col-form-label text-md-end">{{ __('Teléfono') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="tel"
                    name="phone"
                    id="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}"
                    placeholder="Teléfono del taller"
                    required>

                  @error('phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-10 text-end">
                  <a href="{{ route('locations.index') }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{ __('Cancelar') }}</a>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection