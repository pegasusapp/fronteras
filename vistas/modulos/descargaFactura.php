<style>
 td {font-size: 14px};

 .icon-bar {
  width: 100%;
  background-color: #ffffff; 
  overflow: auto;
  border-style: dashed;
}

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
 <section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de facturas</h3>     
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
                foreach ($items as $key => $value)
                    {
                        echo ' <tr>
                                    <td>'.$value["anyo"].'</td>
                                    <td>'.ControladorValidaciones::monthSelect($value["mes"]).'</td> 
                                    <td><a href="/docs/facturas/'.$value["frontera_fronteraCliente"].'/'.$value["anyo"].$value["mes"].'/'.$value["nameFile"].'" target="_blank">'.$value["frontera_fronteraCliente"].'</a></td>
                                </tr>';
                    }
                ?> 
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