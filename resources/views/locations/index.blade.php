@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-lg-10 col-xl-8 d-flex justify-content-between align-items-baseline">
        <h2 id="title" data-default-path="locations" data-query-path="locations/search"><i class="fas fa-car-mechanic"></i> Talleres</h2>
        <div>
          <a href="{{ route('locations.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Nuevo</span></a>
        </div>
      </div>
    </div>

    <div class="row mb-3" id="search-client-div">
      <div class="col-sm-8 col-md-6 col-lg-4 col-xl-3 offset-lg-1 offset-xl-2">
        <div class="input-group">
          <input type="text"
            name="search"
            id="search"
            class="form-control"
            value="{{ old('search') }}"
            placeholder="Busqueda"
            aria-label="Busqueda"
            aria-describedby="search-client-button"
            autofocus
            >
            <span class="input-group-text" id="search-client-button"><i class="fa fa-search"></i></span>
        </div>
      </div>
    </div>

    <div id="pagination">
      @include('locations.pagination')
    </div>
  </div>
  
  @include('locations.modal-delete')
@endsection
