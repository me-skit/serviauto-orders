<div class="modal fade" id="delCarModal" tabindex="-1" aria-labelledby="delCarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delCarModalLabel"><span class="text-warning"><i class="fas fa-exclamation-triangle"></i></span> Eliminar Datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mx-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-5 border-bottom">
                  Placas:
                </div>
                <div class="col-7 col-sm-8 col-md-9 col-lg-7">
                  <b id="car-info-plate">
                  </b>
                </div>
              </div>
            </div>
          </div>
  
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-5 border-bottom">
                  Marca:
                </div>
                <div class="col-7 col-sm-8 col-md-9 col-lg-7">
                  <b id="car-info-brand">
                  </b>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-5 border-bottom">
                  Line:
                </div>
                <div class="col-7 col-sm-8 col-md-9 col-lg-7">
                  <b id="car-info-line">
                  </b>
                </div>
              </div>
            </div>
          </div>
  
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-5 border-bottom">
                  Año:
                </div>
                <div class="col-7 col-sm-8 col-md-9 col-lg-7">
                  <b id="car-info-year">
                  </b>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-5 col-sm-4 col-md-3 col-lg-5 border-bottom">
                  Color:
                </div>
                <div class="col-7 col-sm-8 col-md-9 col-lg-7">
                  <b id="car-info-color">
                  </b>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form id="deletecar-form" action="#" method="POST" data-root="{{ url('/') }}" data-code="{{ $client->id }}">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
      </div>
    </div>
  </div>
</div>