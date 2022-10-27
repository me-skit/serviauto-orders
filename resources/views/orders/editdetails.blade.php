<div class="row justify-content-center">
  <div class="col-md-12 col-lg-11">
    <div class="card mb-3">
      <div class="card-header">
        <span class="fw-bold">Detalles</span>
        <button type="button" class="btn btn-success btn-sm float-end" id="btn-add-item">
          <i class="far fa-plus"></i> Agregar
        </button>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-hover table-sm" id="items-table">
              <thead>
                <tr>
                  <td class="col-sm-2 col-md-1 point-75">Cant.</td>
                  <td class="col-sm-7 col-md-5 point-300">Descripcion</td>
                  <td class="text-center col-sm-1 col-md-2 point-90">P/U (Q)</td>
                  <td class="text-center col-sm-1 col-md-2 point-90">Subtotal (Q)</td>
                  <td class="text-center col-sm-1 col-md-2">Acciones</td>
                </tr>
              </thead>
              <tbody id="body-table">
                @foreach ($order->items_order as $key => $item)
                  <tr>
                    <td class="col-sm-2 col-md-1">
                      <input type="number"
                        class="form-control quantity-input"
                        name="items_order[{{ $key }}][quantity]"
                        min="1" max="9999"
                        value="{{ $item->quantity }}"
                        required
                      >
                    </td>
                    <td class="col-sm-7 col-md-5">
                      <input type="text"
                        class="form-control description-input"
                        list="itemList"
                        value="{{ $item->description }}"
                        placeholder="Nombre del artículo o servicio..."
                        required
                      >
                      <input type="hidden" name="items_order[{{ $key }}][item_id]" value="{{ $item->item_id }}">
                      <input type="hidden" name="items_order[{{ $key }}][price_id]" value="{{ $item->price_id }}">
                    </td>
                    <td class="align-middle text-end col-sm-1 col-md-2">{{ number_format($item->sell_price, 2, '.', ',') }}</td>
                    <td class="align-middle text-end col-sm-1 col-md-2">{{ number_format($item->quantity * $item->sell_price, 2, '.', ',') }}</td>
                    <td class="align-middle text-center">
                      <button type="button" class="btn btn-danger btn-sm del-button"><i class="far fa-trash-alt"></i><span class="d-none d-md-inline"> Borrar</span></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <td></td>
                <td class="text-center" colspan="2">TOTAL</td>
                <td class="text-end" id="total-cell">
                  Q 0.00
                </td>
                <td></td>
              </tfoot>
            </table>
            <input type="hidden" id="total" name="total" value="0">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<datalist id="itemList" type="hidden">
  @foreach ($items_list as $item)
    <option data-item-id="{{ $item->id }}" data-price-id="{{ $item->latestPrice->id }}" data-price="{{ $item->latestPrice->sell_price }}">{{ $item->description }}</option>
  @endforeach
</datalist>
