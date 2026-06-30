<?php include('./header.php'); ?>

<script type="text/javascript">
    $( document ).ready(function() {  


     $("#btn_carga").on('click', function() {
      var id = $('#ddl_opcion').val();
      $('#txt_opcion').val(id);
      var fi = $('#file').val();
      if(id != '' && fi != '')
      {

            var formData = new FormData(document.getElementById("form_img"));
            $.ajax({
                url: '../controlador/cargar_bajasC.php?subir_archivo_server=true',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                dataType:'json',
             // beforeSend: function () {
             //        $("#foto_alumno").attr('src',"../../img/gif/proce.gif");
             //     },
                success: function(response) {
                  if(response == 1)
                  {
                     cargar_datos()
                  }else
                  {
                    Swal.fire( 'Formato del archivo incorrecto','asegurese que el archivo sea (.cvs)','error');

                  }
                }
            });
      }else
      {
         Swal.fire( '','Destino o archivo no seleccionados','error');
      }
    });
  });
  
</script>

<script type="text/javascript">
	function cargar_datos()
  {
     var id = $('#ddl_opcion').val();
      var parametros=
     {
      'id':id,
      };
     $('#myModal').modal('show');
     $.ajax({
         data:  {parametros:parametros},
         url: '../controlador/cargar_bajasC.php?ejecutar_sp=true',
         type:  'post',
         dataType: 'json',
          success:  function (response) {  
            console.log(response);
            if(response==1)
            {
              Swal.fire('carga completada','','success').then(function(){
                location.reload()
              });
            }else
            {
              Swal.fire('No se pudo completar','Asegurese que los datos esten en los formatos correctos y sin (;) punto y comas ó revise la cantidad de items en el archivo','error').then(function(){
                $('#myModal').modal('hide');
              });              
            }
            
                  $('#myModal').modal('hide');
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
          <h1 class="m-0 text-dark">Actualizar bajas,terceros,patrimoniales</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      	<div class="row"> 
      		<div class="col-sm-6">
            <form enctype="multipart/form-data" id="form_img" method="post"> 
             <input type="hidden" id="txt_opcion" name="txt_opcion">     
              <input type="file" name="file" id="file" class="form-control">
              <p><b>Nota:</b> El archivo debera tener un maximo de 10000 items</p>
            </form>
      	    </div>
      	    <div class="col-sm-3">
      		    <select class="form-control" id="ddl_opcion">
      			<option value="">Seleccione destino de datos</option>
                <option value="1">Cargar Bajas</option>
                <option value="2">Cargar Terceros</option>
                <option value="3">Cargar Patrimoniales</option>
      		    </select>

              <!-- <label><input type="checkbox" name="rbl_primera" id="rbl_primera"> Como primera vez</label> -->
      	    </div>
      	     <div class="col-sm-3">
      		    <button class="btn btn-primary" id="btn_carga">Actualizar archivos</button>
      		    <!-- <button class="btn btn-primary" id="btn_carga" onclick="cargar_datos()">archivos</button> -->
              <!-- <button class="btn btn-primary" id="btn_carga" onclick="cargar_datos1()">archivos sp</button> -->
      	    </div>
      	</div>
        <div class="row">
          <br>
          <div class="col-sm-12" id="reporte">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div id="cargar">
          <div class="text-center"><img src="../img/de_sistema/loader_puce.gif" width="100" height="100">SUBIENDO DATOS</div>
        </div>
        <div>
           <div class="progress-group" id="loader">
               <span class="progress-number" id="pro_partes"><b>1/?</b></span><div class="progress sm"><div class="progress-bar progress-bar-aqua" style="width: 1%" id="loader_"></div></div>
           </div>
        </div>        
      </div>      
    </div>
  </div>
</div>

<?php include('./footer.php'); ?>
