@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-header">
            <span class="fw-bold"><i class="fas fa-car"></i> {{ __('Modificar Datos de Vehículo') }}</span>
          </div>
          <div class="card-body">
            <form action="{{ route('cars.update', $car) . '?code=' . $code }}" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group row mb-3">
                <label for="brand" class="col-md-3 col-form-label text-md-end">{{ __('Marca') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="brand"
                    id="brand"
                    class="form-control @error('brand') is-invalid @enderror"
                    value="{{ old('brand') ?? $car->brand }}"
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
                    value="{{ old('line') ?? $car->line }}"
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
                    value="{{ old('year') ?? $car->year }}"
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
                <label for="color" class="col-md-3 col-form-label text-md-end">{{ __('Color') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="color"
                    id="color"
                    class="form-control @error('color') is-invalid @enderror"
                    value="{{ old('color') ?? $car->color }}"
                    placeholder="Color"
                    required>

                  @error('color')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="plate" class="col-md-3 col-form-label text-md-end">{{ __('Placa') }}<span class="text-danger">*</span></label>
                <div class="col-md-7">
                  <input type="text"
                    name="plate"
                    id="plate"
                    class="form-control @error('plate') is-invalid @enderror"
                    value="{{ old('plate') ?? $car->plate }}"
                    placeholder="Placa"
                    required>

                  @error('plate')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-10 text-end">
                  <a href="{{ route('clients.show', $code) . '?tab=cars' }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{  __('Cancelar') }}</a>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Modificar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection