<section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de facturas de la frontera <?=$_SESSION['frtSession'][0]["fronteraCliente"];?></h3>
                  </div>
                </div>
                <div class="row">
                <div class="col-4">
                </div>
                <div class="col-4" >
                      <div class="icon-bar">
                      </div>
                </div>
                <div class="col-4">
                </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive table-hover tablas">
              <caption>Listado de facturas de energia</caption>
              <thead>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="frontera_tag">FRONTERA</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $item = "frontera_fronteraCliente";
                $valor = $_SESSION["identificador"];
                $items = ControladorFactura::ctrMostrarFactura($item, $valor);
                foreach ($items as $key => $value): ?>
                  <tr>
                        <td><?=$value["anyo"]?></td>
                        <td><?=ControladorValidaciones::monthSelect($value["mes"])?></td>
                        <td><a href="/docs/facturas/<?=$value["frontera_fronteraCliente"].'/'.$value["anyo"].$value["mes"].'/'.$value["nameFile"] ?>" target="_blank"><?=$value["frontera_fronteraCliente"]?></a></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="frontera_tag">FRONTERA</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
  </div>
  </section>
</div>
<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>