@extends('layouts.app')

@section('title')
  <title>SA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-11 d-flex justify-content-between">
        <div class="d-flex">
          <img src = "../images/servi-logo.png" alt="ServiAuto logo" height="130"/>
          <div class="text-center ms-2">
            <h2 class="mb-0 fw-bolder"><i><span class="text-primary">Servi</span><span class="text-danger">Auto</span></i></h2>
            <h6 class="mb-0">Servicios Mecánicos y</h5>
            <h6 class="mt-0">Diagnóstico Computarizado</h5>
            <p class="small mb-0"><i>13 calle 30-45, zona 7, Tikal I</i></p>
            <p class="small mt-0"><i>Tel.: 5928 3710</i></p>
          </div>
        </div>
        <div class="text-center">
          <h6>Orden de</h6>
          <h6>Trabajo</h6>
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
            <h6>Vehículo</h6>
            <div class="row small">
              <div class="col-6">
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    No. placa:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->car->plate }}
                    </b>
                  </div>
                </div>
              </div>
              <div class="col-6">
                @if ($order->car->service_id and ($order->car->service_id == $order->id))
                <div class="row">
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Sig. Servicio:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ number_format($order->car->next_service) }}
                    </b>
                  </div>
                </div>
                @endif
              </div>
            </div>
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
                  <div class="col-5 col-md-4 col-lg-5 border-bottom">
                    Color:
                  </div>
                  <div class="col-7 col-md-8 col-lg-7">
                    <b>
                      {{ $order->car->color }}
                    </b>
                  </div>
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
                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-end align-middle">{{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="text-end align-middle">{{ number_format($item->quantity * $item->price, 2, '.', ',') }}</td>
                        <td></td>                       
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <td></td>
                    <td class="text-center" colspan="2">TOTAL</td>
                    <td class="text-end text-truncate" id="total-cell">
                      {{ $order->total }}
                    </td>
                    <td></td>
                  </tfoot>
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
