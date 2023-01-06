@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-11 col-xxl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="p-2">
              <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                  <h4 class="align-self-end mb-1">{{ $client->name }}</h4>
                  <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-outline-primary ms-2 me-1"><i class="fas fa-pencil-alt"></i></a>
                  <a href="#" class="btn btn-sm btn-outline-danger{{ $can_be_deleted ? '' : ' disabled' }}" role="button" aria-disabled="{{ $can_be_deleted }}" data-bs-toggle="modal" data-bs-target="#delClientModal"><i class="fas fa-trash-alt"></i></a>
                </div>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary my-1"><i class="fas fa-arrow-circle-left"></i><span class="d-none d-lg-inline"> Clientes</span></a>
              </div>
              <hr class="my-0">
              <p class="my-0"><i class="fas fa-phone-rotary"></i> {{ $client->phone_number }}</p>
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
            <li class="nav-item" role="presentation">
              <button class="nav-link{{ ($tab === 'historic') ? ' active': '' }}" id="historic-tab" data-bs-toggle="tab" data-bs-target="#historic-tab-pane" type="button" role="tab" aria-controls="historic-tab-pane" aria-selected="false"><i class="fas fa-history"></i> Historial</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade p-2{{ $tab ? '': ' show active' }}" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
              <div class="text-end">
                <a href="{{ route('orders.create') . '?code=' . $client->id }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Agregar</span></a>
              </div>

              @include('orders.list', ['list' => $active_orders, 'total_sum' => $grand_total, 'sel_tab' => null])
            </div>
            <div class="tab-pane fade p-2{{ ($tab === 'cars') ? ' show active': '' }}" id="cars-tab-pane" role="tabpanel" aria-labelledby="cars-tab" tabindex="0">
              <div class="text-end">
                <a href="{{ route('cars.create') . '?code=' . $client->id }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Agregar</span></a>
              </div>

              @include('cars.list')
            </div>
            <div class="tab-pane fade p-2{{ ($tab === 'historic') ? ' show active': '' }}" id="historic-tab-pane" role="tabpanel" aria-labelledby="historic-tab" tabindex="0">

              @include('orders.list', ['list' => $past_orders, 'total_sum' => null, 'sel_tab' => 'historic'])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('cars.modal-delete')
  @include('clients.modal-delete')
@endsection