@extends('layouts.app')

@section('title')
  <title>SA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11 d-flex justify-content-between">
        <div class="d-flex">
          <img src = "../images/servi-logo.png" alt="ServiAuto logo" height="110"/>
          <div class="text-center ms-2">
            <h2 class="mb-0 fw-bolder"><i><span class="text-primary">Servi</span><span class="text-danger">Auto</span></i></h2>
            <h6 class="mb-0">Servicios Mecánicos y</h5>
            <h6 class="my-0">Diagnóstico Computarizado</h5>
            <p class="small my-0"><i> {{ $order->client->location->address . ', ' . $order->client->location->location }}</i></p>
            <p class="small mt-0"><i>Tel.: {{ $order->client->location->formatted_phone }}</i></p>
          </div>
        </div>
        <div class="text-center">
          <h6>Orden de</br>Trabajo</h6>
          <h6><span class="text-danger fw-bold">SA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></h6>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-3 mb-2">
      <div class="col-md-12 col-lg-11 d-flex justify-content-end">
        <div class="d-print-none">
          <a id="btn-print" href="#" class="btn btn-light ms-1"><i class="fas fa-print"></i><span class="d-none d-md-inline"> Imprimir</span></a>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11">
        <div class="card mb-3">
          <div class="card-header">
            <span class="fw-bold card-title">Datos de la Orden</span>
          </div>
          <div class="card-body">
            <div class="row small">
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Cliente:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->client->name }}
                    </b>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Fecha:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->formatted_date }}
                    </b>
                  </div>
                </div>
              </div>
            </div>

            <br>
            @if ($order->car->next_service)
              <div class="mb-1">
                <h6 class="d-inline">Vehículo</h6>
                <p class="d-inline">(Sigiente servicio: {{ number_format($order->car->next_service) }} {{ $order->car->measure }})</p>
              </div>
            @else
              <h6>Vehículo</h6>
            @endif

            <div class="row small">
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Marca:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->car->brand }}
                    </b>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Linea:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->car->line }}
                    </b>
                  </div>
                </div>
              </div>
            </div>
            <div class="row small">
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Año:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->car->year }}
                    </b>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  @if ($order->car->color)
                    <div class="col-5 col-md-4 col-lg-5 border-bottom">
                      Color:
                    </div>
                    <div class="col-7 col-md-8 col-lg-7">
                      <b>
                        {{ $order->car->color }}
                      </b>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11">
        <div class="card mb-3">
          <div class="card-header">
            <span class="fw-bold">Detalles</span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-hover table-sm" id="items-table">
                  <thead>
                    <tr>
                      <td>Cant.</td>
                      <td>Artículo o Servicio</td>
                      <td class="text-center">P/U (Q)</td>
                      <td class="text-center">Subtotal (Q)</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="body-table">
                    @foreach ($order->items as $item)
                      <tr>
                        <td class="text-center align-middle">{{ $item->is_service ? '*' : $item->quantity }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end align-middle">{{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="text-end align-middle">{{ number_format($item->quantity * $item->price, 2, '.', ',') }}</td>
                        <td></td>
                      </tr>
                    @endforeach
                  
                    <tr style="border-style: solid none none none; border-width: 2px;">
                      <td></td>
                      <td class="text-center" colspan="2">TOTAL</td>
                      <td class="text-end text-truncate" id="total-cell">
                        {{ $order->total }}
                      </td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center d-print-none">
      <div class="col-md-12 col-lg-11 text-end">
        <a href="{{ route('clients.show', $code) . ($tab ? '?tab=' . $tab : '') }}" class="btn btn-secondary me-1"><i class="fas fa-arrow-circle-left"></i> {{  __('Regresar') }}</a>
      </div>
    </div>
  </div>
@endsection
