<style>
 td {font-size: 14px;}
 
 th {font-size: 14px;}

.icon-bar a {
  float: left;
  width: 20%;
  text-align: center;
  /*padding: 12px 0;*/
  transition: all 0.3s ease;
  color: #1187ff;
  font-size: 35px;
  background-color: #ffffff;
 
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

?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de fronteras </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar fronteras </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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
                      <th scope="col">NIU ITALENER</th>
                      <th scope="col">NIU OPERADOR</th>
                      <th scope="col">SEGUIMIENTO</th>
                      <th scope="col">CANT. MIN KV</th>
                      <th scope="col">ACCIONES</th>
                     </tr> 
                    </thead>
                    <tbody>
                    <?php
                      $items = ControladorFronteras::ctrMostrarFronteras($item, $valor);
                        foreach ($items as $key => $value): ?>
                               <tr> 		                  
                                      <td class="details-control" id="td_<?= $value["fronteraCliente"] ?>" vlr="<?= $value["fronteraCliente"]?>"></td>
                                      <td><?= $value["fronteraCliente"] ?></td> 
                                      <td><?= $value["descripcionFrontera"] ?></td> 
                                      <td><?= $value["niuEmpresa"] ?></td> 
                                      <td><?= $value["niuOperador"] ?></td> 
                                      <td><?= $r = ("S" == $value["seguimiento"]) ? "SI" : "NO"; ?></td> 
                                      <td><?= $value["minimoKv"] ?></td> 
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
                        <th scope="col">NIU ITALENER</th>
                        <th scope="col">NIU OPERADOR</th>
                        <th scope="col">SEGUIMIENTO</th>
                        <th scope="col">CANT. MIN KV</th>
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
