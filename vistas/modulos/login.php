<div id="back"></div>

<div class="login-box">
  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" alt="logo empresa" class="img-responsive" style="padding:30px 100px 0px 50px">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar sesión</p>

      <form  method="post">
        <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordar
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
                    <?php

            $login = new ControladorUsuarios();
            $login -> ctrIngresoUsuario();

            ?>
      </form>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->



  