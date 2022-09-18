<style>
table.dataTable td.details-control:before {
   content: '\f152';
   font-family: 'Font Awesome\ 5 Free';
   cursor: pointer;
   font-size: 22px;
   color: #55a4be;
}
table.dataTable tr.shown td.details-control:before {
  content: '\f150';
  color: black;
}
</style>
<?php
 $item = NULL;
 $valor = NULL;
 if($_SESSION["perfilSesion"] <> 9)
 {
  $item = "clienteFrontera_nitCliente";
  $valor = $_SESSION["identificador"];
 }
 $items = ControladorFronteras::ctrMostrarFronteras($item, $valor);


?>

    
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped dt-responsive tablas" id="example_table" >
                    <caption>Listado de fronteras</caption>
                    <thead>
                     <tr>
                      <th scope="col"></th>
                      <th scope="col">FRONTERA</th>
                      <th scope="col">DESCRIPCION FRONTERA</th>
                      <th scope="col">ACCIONES</th>
                     </tr> 
                    </thead>
                    <tbody>
                    <?php
                        foreach ($items as $value): ?>
                               <tr> 		                  
                                      <td class="details-control" id="td_<?= $value["fronteraCliente"] ?>"  vlr="<?= $value["fronteraCliente"]?>"></td>
                                      <td><?= $value["fronteraCliente"] ?></td> 
                                      <td><?= $value["descripcionFrontera"] ?></td> 
                                      <td>
                                          <div class='btn-group'>
                                            <button class='btn btn-primary px-2.5' onclick=editarFrontera('<?= $value["fronteraCliente"] ?>')  data-toggle='modal' data-target='#modalEditarFrontera'><em class='far fa-edit' aria-hidden='true'></em></button>
                                          </div>
                                          <div class='btn-group'>
                                            <button class='btn btn-primary px-2.5' onclick=reporteFrontera('<?= $value["fronteraCliente"] ?>')  data-toggle='modal' data-target='#modalGeneraraReporte' title='Generar matriz datos'><em class='fas fa-database' aria-hidden='true'></em></button>
                                          </div>
                                      </td>
                               </tr>
                       
                  <?php endforeach; ?> 

                    </tbody>
                      <tfoot>
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">FRONTERA</th>
                        <th scope="col">DESCRIPCION FRONTERA</th>
                        <th scope="col">ACCIONES</th>
                        </tr> 
                      </tfoot>
                </table>
              </div>
        </div>        
      </div>
    </div>
  </section>
</div>

<?php include 'editlistadoFronteras.php' ?>

