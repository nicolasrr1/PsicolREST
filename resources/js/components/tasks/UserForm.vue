<template>
  <div class="justify-content-center align-items-center">
    <div class="cartConten">
      <div class="card" style="width: 58rem">
        <div class="card-body">
          <h5 class="card-title">Formulario de registro</h5>
          <form action="">
            <div class="row">
              <div class="col">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Documento"
                  aria-label="Documento"
                />
              </div>
              <div class="col">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nombre y Apellido "
                  aria-label="Nombre y Apellido "
                />
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Teléfono"
                  aria-label="Teléfono"
                />
              </div>
              <div class="col">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Dirección "
                  aria-label="Dirección "
                />
              </div>
            </div>

            <button type="button" class="btn btn-primary">Primary</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
