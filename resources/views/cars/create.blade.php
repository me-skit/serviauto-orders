@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-header">
            <span class="fw-bold"><i class="far fa-car"></i> {{ __('Agregar Datos de Vehículo') }}</span>
          </div>
          <div class="card-body">
            <form action="{{ route('cars.store') . '?code=' . $code }}" method="POST">
              @csrf

              <div class="form-group row mb-3">
                <label for="brand" class="col-md-3 col-form-label text-md-end">{{ __('Marca') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="brand"
                    id="brand"
                    class="form-control @error('brand') is-invalid @enderror"
                    value="{{ old('brand') }}"
                    placeholder="Marca"
                    required
                    autofocus>

                  @error('brand')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="line" class="col-md-3 col-form-label text-md-end">{{ __('Linea') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="line"
                    id="line"
                    class="form-control @error('line') is-invalid @enderror"
                    value="{{ old('line') }}"
                    placeholder="Linea"
                    required>

                  @error('line')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="year" class="col-md-3 col-form-label text-md-end">{{ __('Año') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="number"
                    name="year"
                    id="year"
                    class="form-control @error('year') is-invalid @enderror"
                    value="{{ old('year') }}"
                    placeholder="Año"
                    required>

                  @error('year')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="color" class="col-md-3 col-form-label text-md-end">{{ __('Color') }}</label>
                <div class="col-md-7">
                  <input type="text"
                    name="color"
                    id="color"
                    class="form-control @error('color') is-invalid @enderror"
                    value="{{ old('color') }}"
                    placeholder="Color">

                  @error('color')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="engine_number" class="col-md-3 col-form-label text-md-end">{{ __('Motor') }}</label>
                <div class="col-md-7">
                  <input type="text"
                    name="engine_number"
                    id="engine_number"
                    class="form-control @error('engine_number') is-invalid @enderror"
                    value="{{ old('engine_number') }}"
                    placeholder="Número de motor">

                  @error('engine_number')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="cc" class="col-md-3 col-form-label text-md-end">{{ __('CC') }}</label>
                <div class="col-md-7">
                  <input type="text"
                    name="cc"
                    id="cc"
                    class="form-control @error('cc') is-invalid @enderror"
                    value="{{ old('cc') }}"
                    pattern="(([1-9]\d{0,2}(,\d{3})*)|([1-9]\d*))"
                    title="Debe ser un número como: 1,000 o 1,000,000"
                    placeholder="Centímetros cúbicos">

                  @error('cc')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="chassis_number" class="col-md-3 col-form-label text-md-end">{{ __('Chasis') }}</label>
                <div class="col-md-7">
                  <input type="text"
                    name="chassis_number"
                    id="chassis_number"
                    class="form-control @error('chassis_number') is-invalid @enderror"
                    value="{{ old('chassis_number') }}"
                    placeholder="Número de chasis">

                  @error('chassis_number')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-10 text-end">
                  <a href="{{ route('clients.show', $code) . '?tab=cars' }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{  __('Cancelar') }}</a>
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