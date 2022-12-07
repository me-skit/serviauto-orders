@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-11 col-xxl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="p-4 bg-light rounded">
              <div class="d-flex justify-content-between">
                <div class="d-flex">
                  <h1 class="display-6">{{ $client->name }}</h1>
                  <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-outline-primary align-self-center mx-1"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary align-self-center"><i class="fas fa-arrow-circle-left"></i><span class="d-none d-lg-inline"> Listado</span></a>
              </div>
              <hr class="my-0">
              <p class="lead my-0"><i class="fas fa-phone-rotary"></i> {{ $client->phone_number }}</p>
            </div>
          </div>

          {{-- tabs --}}
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link{{ $tab ? '': ' active' }}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><i class="fas fa-clipboard-list"></i> Ordenes</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link{{ ($tab === 'cars') ? ' active': '' }}" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars-tab-pane" type="button" role="tab" aria-controls="cars-tab-pane" aria-selected="false"><i class="fas fa-cars"></i> Vehiculos</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade p-2{{ $tab ? '': ' show active' }}" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
              <div class="text-end">
                <a href="{{ route('orders.create') . '?code=' . $client->id }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Agregar</span></a>
              </div>

              @include('orders.list')
            </div>
            <div class="tab-pane fade p-2{{ ($tab === 'cars') ? ' show active': '' }}" id="cars-tab-pane" role="tabpanel" aria-labelledby="cars-tab" tabindex="0">
              <div class="text-end">
                <a href="{{ route('cars.create') . '?code=' . $client->id }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Agregar</span></a>
              </div>

              @include('cars.list')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('cars.modal-delete')
@endsection