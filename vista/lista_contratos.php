<?php include('./header.php'); ?>
<script type="text/javascript">	
    $( document ).ready(function() {
    	lista_contratos();
    })  
   function lista_contratos()
   {
   	var parametros = 
   	{
   		'query':$('#txt_query').val(),
   		'desde':$('#txt_desde').val(),
   		'hasta':$('#txt_hasta').val(),
   		'opcion':$('input[name="cbx_opc"]:checked').val(),
   	}
    $.ajax({
         data:  {parametros,parametros},
         url:   '../controlador/contratoC.php?lista_contratos=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) { 
           	if(response!='')
           	{
           		// console.log(response);
           		$('#tbl_body').html(response);
           	}
          } 
          
       });
   }
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Contratos de seguros</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-sm-3">
      			<a href="contratos.php" class="btn btn-sm btn-success">Nuevo</a>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-3">
      			<b>Buscar proveedor</b>
      			<input type="" name="txt_query" id="txt_query" class="form-control form-control-sm" onkeyup="lista_contratos()">      			
      		</div>
      		<div class="col-sm-4">
      			<div class="row">
      				<div class="col-sm-6">
		      			<b>Desde</b>
		      			<input type="date" name="txt_desde" id="txt_desde" class="form-control form-control-sm" onblur="lista_contratos()">      			
		      		</div>
		      		<div class="col-sm-6">
		      			<b>Hasta</b>
		      			<input type="date" name="txt_hasta" id="txt_hasta" class="form-control form-control-sm" onblur="lista_contratos()">      			
		      		</div>		      				
      			</div>
      			<label><input type="radio" name="cbx_opc" value="1" onclick="lista_contratos()"> Fecha contrato</label>
      			<label><input type="radio" name="cbx_opc" value="2" onclick="lista_contratos()"> Fecha fin contrato</label> 
      			<label><input type="radio" name="cbx_opc" value="0" onclick="lista_contratos()" checked> Ninguno</label>      			
      		</div>
      		
      		
      			
      	</div>
      	<div class="row">
      		<div class="col-sm-12">
      			<table class="table table-hover">
      				<thead>
      					<th>Proveedor</th>
      					<th>Precio prima</th>
      					<th>Fecha contrato</th>
      					<th>Fecha fin</th>
      					<th>Suma asegurada</th>
      				</thead>
      				<tbody id="tbl_body">
      					<tr><td colspan="5">No se encontraton registros</td></tr>
      				</tbody>
      			</table>
      		</div>
      	</div>                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
