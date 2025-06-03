<div class="modal fade" id="delLocationModal" tabindex="-1" aria-labelledby="delLocationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delLocationModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Taller:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <b id="location-info-description">
        </b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deletelocation-form" action="#" method="POST" data-root="{{ url('/') }}">
          @csrf
          @method('delete')

          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>