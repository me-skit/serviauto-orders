<div class="modal fade" id="finishOrderModal" tabindex="-1" aria-labelledby="finishOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('orders.finish', $order->id) . '?code='. $client->id . ($tab ? '&tab=' . $tab : '') }}" method="POST">
        @csrf
        @method('patch')

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="finishOrderModalLabel"><span class="text-warning"><i class="fas fa-clipboard-check"></i></i></span> Finalizar la orden</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">

        <div class="row">
          <label for="finished" class="col-md-3 col-form-label text-md-end">{{ __('Fecha') }}<span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="date"
              name="finished"
              id="new-date"
              class="form-control text-end"
              value="{{ old('finished') }}"
              required
            >
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

          <button type="submit" class="btn btn-danger">Finalizar</button>
        </div>
      </form>
    </div>
  </div>
</div>