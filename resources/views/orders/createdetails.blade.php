<div class="row justify-content-center">
  <div class="col-md-12 col-lg-11">
    <div class="card mb-3">
      <div class="card-header">
        <span class="fw-bold">Detalles</span>
        <button type="button" class="btn btn-success btn-sm float-end" id="btn-add-item">
          <i class="fas fa-plus-circle"></i> Agregar
        </button>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-hover table-sm" id="items-table">
              <thead>
                <tr>
                  <td class="col-sm-2 col-md-1 point-75">Cant.</td>
                  <td class="col-sm-7 col-md-5 point-300">Artículo o Servicio</td>
                  <td class="text-center col-sm-1 col-md-2 point-90">P/U (Q)</td>
                  <td class="text-center col-sm-1 col-md-2 point-90">Subtotal (Q)</td>
                  <td class="text-center col-sm-1 col-md-2">Acciones</td>
                </tr>
              </thead>
              <tbody id="body-table">
                <tr>
                  <td class="col-sm-2 col-md-1">
                    <input type="number"
                      name="order_items[0][quantity]"
                      class="form-control quantity-input"
                      min="1" max="9999"
                      value="1"
                      required
                    >
                  </td>
                  <td class="col-sm-7 col-md-5">
                    <input type="text"
                      name="order_items[0][description]"
                      class="form-control description-input"
                      list="itemList"
                      placeholder="Nombre del artículo o servicio..."
                      required
                    >
                  </td>
                  <td class="align-middle text-end col-sm-1 col-md-2">
                    <input type="text"
                      name="order_items[0][price]"
                      class="form-control text-end price-input"
                      pattern="[0-9]+(\.[0-9]{1,2})?"
                      title="Debe ser un numero con dos decimales maximo"
                      required
                    >
                  </td>
                  <td class="align-middle text-end col-sm-1 col-md-2"></td>
                  <td class="align-middle text-center">
                    <button type="button" class="btn btn-danger btn-sm del-button"><i class="fas fa-trash-alt"></i><span class="d-none d-md-inline"> Borrar</span></button>
                  </td>
                </tr>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<datalist id="itemList" type="hidden">
  @foreach ($items_list as $item)
    <option data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->description }}</option>
  @endforeach
</datalist>
