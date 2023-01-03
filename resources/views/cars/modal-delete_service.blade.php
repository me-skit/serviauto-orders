<div class="modal fade" id="delServiceModal" tabindex="-1" aria-labelledby="delServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delServiceModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Servicio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Confirme la eliminación del registro de "siguiente servicio".</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form action="{{ route('cars.remove_service', $order->car->id) . '?code=' . $client->id . '&order=' . $order->id }}" method="POST">
            @csrf
            @method('patch')

            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
      </div>
    </div>
  </div>
</div>