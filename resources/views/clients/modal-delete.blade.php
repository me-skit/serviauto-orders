<div class="modal fade" id="delClientModal" tabindex="-1" aria-labelledby="delClientModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delClientModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Se eliminarán los datos del cliente.</p>
        <p>Presione "Eliminar" para confirmar eliminación.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form id="deleteitem-form" action="{{ route('clients.destroy', $client->id) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
      </div>
    </div>
  </div>
</div>