<section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Factor M</h3>
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
              <table class="table table-bordered table-striped dt-responsive tablas">
              <caption>Historial de factor M</caption>
              <thead>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="factor_tag">FACTOR</th>
                  <th id="total_tag">TOTAL</th>
                  <th id="tenergia_tag">TIPO ENERGIA</th>
                  <th id="tfrontera_tag">FRONTERA</th>
                  <th id="tdias_tag">DIAS</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $dataFrt = $_SESSION['frtSession'];
                $item = "frontera_fronteraCliente";
                $valor = $dataFrt[0]["fronteraCliente"];
                $items = ControladorCtrFactorM::ctrMostrarctrFactorM($item, $valor);
                foreach ($items as  $value): ?>
                  <tr>
                        <td><?=$value["anyo"]?></td>
                        <td><?=ControladorValidaciones::monthSelect($value["mes"])?></td>
                        <td><?=$value["factor"]?></td>
                        <td><?=$value["total"]?></td>
                        <td><?=ControladorUtilidades::tipoEnergia($value["tipoEnergia"])?></td>
                        <td><?=$value["frontera_fronteraCliente"]?></td>
                        <td><?=$value["dias"]?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="factor_tag">FACTOR</th>
                  <th id="total_tag">TOTAL</th>
                  <th id="tenergia_tag">TIPO ENERGIA</th>
                  <th id="tfrontera_tag">FRONTERA</th>
                  <th id="tdias_tag">DIAS</th>
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