@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-3">
      <div class="col-md-12 col-lg-10 col-xl-8 d-flex justify-content-between align-items-baseline">
        <h3 id="title" data-default-path="items" data-query-path="items/search"><i class="fas fa-tools"></i> R<span class="d-none d-md-inline">epuestos</span> & S<span class="d-none d-md-inline">ervicios</span></h3>
        <div>
          <a href="{{ route('items.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-inline"> Nuevo</span></a>
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
      @include('items.pagination')
    </div>
  </div>
  
  @include('items.modal-delete')
@endsection
