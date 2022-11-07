@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-11 col-xxl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="p-4 bg-light rounded">
              <h1 class="display-6 mb-0">{{ $client->name }}</h1>
              <hr class="my-0">
              <p class="lead my-0">
                {{ $client->phone_number }}
              </p>

            </div>
          </div>

          {{-- tabs --}}
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Ordenes</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Vehiculos</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
              @include('orders.list')
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">The profile tab</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection