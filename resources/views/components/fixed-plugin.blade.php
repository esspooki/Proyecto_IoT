<div class="fixed-plugin">
    <style>
      .fixed-plugin .card {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
      }

      .fixed-plugin .card-body {
        overflow-y: auto;
        flex: 1;
        max-height: calc(90vh - 150px);
      }
    </style>
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg ">
      <div class="card-header pb-0 pt-3 ">
        <div class="{{ (Request::is('rtl') ? 'float-end' : 'float-start') }}">
          <h5 class="mt-3 mb-0">Soft UI Configurator</h5>
          <p>Ver opciones para personalizar el dashboard.</p>
        </div>
        <div class="{{ (Request::is('rtl') ? 'float-start mt-4' : 'float-end mt-4') }}">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
      </div>

      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">

        <div class="mt-3">
          <h6 class="mb-0">Tamaño de Fuente</h6>
          <p class="text-sm">Ajusta la escala de texto global para todas las páginas.</p>
        </div>
        <div class="d-flex gap-2 mb-3 font-size-control">
          <button type="button" class="btn btn-outline-secondary btn-sm font-size-button active" data-size="0.8">Small</button>
          <button type="button" class="btn btn-outline-secondary btn-sm font-size-button" data-size="1">Normal</button>
          <button type="button" class="btn btn-outline-secondary btn-sm font-size-button" data-size="1.3">Large</button>
        </div>

        <div class="mt-3">
          <h6 class="mb-0">Modo Oscuro</h6>
          <p class="text-sm">Activa o desactiva el modo oscuro para todo el dashboard.</p>
        </div>
        <div class="form-check form-switch ps-0 mb-3">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="darkModeToggle">
          <label class="form-check-label ms-2" for="darkModeToggle">Habilitar modo oscuro</label>
        </div>


          </a>
        </div>
      </div>
    </div>
  </div>
