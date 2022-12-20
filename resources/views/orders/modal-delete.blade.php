<div class="modal fade" id="delOrderModal" tabindex="-1" aria-labelledby="delOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delOrderModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Orden</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Presione "Eliminar" para confirmar eliminación de esta orden.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form id="deleteitem-form" action="{{ route('orders.destroy', $order->id) . '?code=' . $client->id }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
      </div>
    </div>
  </div>
</div>