<div class="modal fade" id="delItemModal" tabindex="-1" aria-labelledby="delItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delItemModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Item</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <b id="item-info-description">
        </b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deleteitem-form" action="#" method="POST" data-root="{{ url('/') }}">
          @csrf
          @method('delete')

          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>