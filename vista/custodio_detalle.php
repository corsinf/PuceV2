<?php include('./header.php'); $id='';if(isset($_GET['id'])){ $id = $_GET['id'];} ?>
<script type="text/javascript">
  $( document ).ready(function() {
  	var id = '<?php echo $id; ?>';
  	if(id!='')
  	{
     datos_col(id);
  	}


  	$("#subir_imagen").on('click', function() {
     var fileInput = $('#file_img').get(0).files[0];
  console.info(fileInput);
  
      if(fileInput=='')
      {
        Swal.fire('','Seleccione una imagen','warning');
        return false;
      }

        var formData = new FormData(document.getElementById("form_img"));
         $.ajax({
            url: '../controlador/custodioC.php?cargar_imagen=true',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType:'json',
         // beforeSend: function () {
         //        $("#foto_alumno").attr('src',"../../img/gif/proce.gif");
         //     },
            success: function(response) {
               if(response==-1)
               {
                 Swal.fire(
                  '',
                  'Algo extraño a pasado intente mas tarde.',
                  'error')

               }else if(response ==-2)
               {
                  Swal.fire(
                  '',
                  'Asegurese que el archivo subido sea una imagen.',
                  'error')
               }else
               {
                $('#file_img').empty();
               	var id = '<?php echo $id; ?>';
               	datos_col(id);                
               } 
            }
        });
    });
    // --------------------------
});
     
 
  function datos_col(id)
  { 
    $('#titulo').text('Editar custodio');
    $('#op').text('Editar');
    var custodio='';

    $.ajax({
      data:  {id:id},
      url:   '../controlador/custodioC.php?listar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
          console.log(response);
           $('#txt_nombre').val(response[0].PERSON_NOM); 
           $('#txt_per_no').val(response[0].PERSON_NO); 
           $('#txt_ci').val(response[0].PERSON_CI); 
           $('#txt_email').val(response[0].PERSON_CORREO);
           $('#txt_puesto').val(response[0].PUESTO); 
           $('#txt_unidad').val(response[0].UNIDAD_ORG); 
           $('#txt_direccion').val(response[0].DIRECCION); 
           $('#txt_telefono').val(response[0].TELEFONO); 
           if(response[0].FOTO!='' && response[0].FOTO!=null)
           {
            $('#img_foto').attr('src',response[0].FOTO+'?'+Math.random()); 
            }
           $('#id').val(response[0].ID_PERSON); 
      }
    });
  }

  function delete_datos()
  {
  	var id = '<?php echo $id; ?>';
    Swal.fire({
  title: 'Eliminar Registro?',
  text: "Esta seguro de eliminar este registro?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si'
}).then((result) => {
  if (result.value) {
    eliminar(id);    
  }
})

  }

 
  
  function insertar(parametros)
  {
     $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/custodioC.php?insertar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {  
        if(response == 1)
        {
          $('#myModal').modal('hide');
          Swal.fire(
            '',
            'Operacion realizada con exito.',
            'success'
          )
          consultar_datos();
        }  
               
      }
    });

  }
  function limpiar()
  {
      $('#txt_nombre').val(''); 
      $('#txt_per_no').val(''); 
      $('#txt_ci').val(''); 
      $('#txt_email').val('');
      $('#txt_puesto').val(''); 
      $('#txt_unidad').val(''); 
      $('#id').val(''); 
      $('#titulo').text('Nuevo custodio');
      $('#op').text('Guardar');
           

  }
  function eliminar(id)
  {
     $.ajax({
      data:  {id:id},
      url:   '../controlador/custodioC.php?eliminar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {  
        if(response == 1)
        {
         Swal.fire(
      'Eliminado!',
      'Registro Eliminado.',
      'success'
    )
          consultar_datos();
        }  
               
      }
    });

  }
  function editar_insertar()
  {
     var nom = $('#txt_nombre').val(); 
     var ci = $('#txt_ci').val(); 
     var email= $('#txt_email').val();
     var pue = $('#txt_puesto').val(); 
     var uni = $('#txt_unidad').val(); 
     var per = $('#txt_per_no').val(); 
     var tel = $('#txt_telefono').val(); 
     var dir = $('#txt_direccion').val(); 
     var id = $('#id').val();
    
      var parametros = {
        'nombre':nom,
        'ci':ci,
        'email':email,
        'puesto':pue,
        'unidad':uni,
        'id':id,
        'per':per,
        'tel':tel,
        'dir':dir,
      }
      if(id=='')
        {
          if(nom == '' || ci == '' || email == '' || pue == '' || uni == '' || tel == '' || dir == '')
            {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Asegurese de llenar todo los campos',
               })
            }else
            {
             insertar(parametros)
          }
        }else
        {
            if(nom == '' || ci == '' || email == '' || pue == '' || uni == '' || tel == '' || dir == '')
            {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Asegurese de llenar todo los campos',
               })
            }else
            {
              insertar(parametros);
            }
        }
  }
   function paginacion(num)
{
  $('#txt_pag').val(num);
  var pag = $('#txt_pag').val().split('-');
  var pos = pag[1]/25;
  consultar_datos();
  // alert(pos);
}
function guias_pag(tipo)
{

  var m1 =  $('#txt_pag').val().split('-');
  var m =  $('#txt_pag1').val().split('-');
  var pos = m1[1]/25;
  if (tipo=='+')
  {
    if(pos >= 10)
    {
       var fin =  m[1]*(pos+1);
       var ini = fin-m[1];
       $('#txt_pag').val(ini+'-'+fin);
       consultar_datos();

    }else{
    var fin =  m[1]*(pos+1);
    var ini = fin-m[1];
    $('#txt_pag').val(ini+'-'+fin);
    consultar_datos();
   }

  }else
  {
    if(pos == 1)
    {
      alert('esta en el inicio');
    }else
    {
       var fin =  m[1]*(pos-1);
       var ini = fin-m[1];
       $('#txt_pag').val(ini+'-'+fin); 
       consultar_datos();  
    }
  }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark">Custodios</h1> -->
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
         <input type="hidden" id="txt_pag" name="" value="0-25">
              <input type="hidden" id="txt_pag1" name="" value="0-25">
              <input type="hidden" id="txt_numpag" name="">

          <div class="row">
            <div class="col-sm-12" id="btn_nuevo">
            	<a href="custodio.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
              	<a href="#" class="btn btn-success btn-sm" onclick="location.href = 'custodio_detalle.php'"><i class="fa fa-plus"></i>  Nuevo</a>              
            </div>
          </div>
          <div class="row">
      		<div class="col-sm-4">
      			<form enctype="multipart/form-data" id="form_img" method="post" style="width: inherit;">
           		 	<input type="hidden" name="id" id="id" class="form-control"> 
                  Codigo <br>
           		 	<input type="input" name="txt_per_no" id="txt_per_no" class="form-control form-control-sm" readonly> <br>		       
               		<div class="widget-user-image text-center">
		                <img class="img-circle elevation-2" src="../img/sin_imagen.jpg" alt="User Avatar" id="img_foto" name="img_foto" style="width: 300px;height: 250px;">
		             </div><br>
               		<input type="file" name="file_img" id="file_img" class="form-control form-control-sm">
               		<input type="hidden" name="txt_nom_img" id="txt_nom_img">
               		<button class="btn btn-primary btn-block" id="subir_imagen" type="button">Cargar imagen</button>
           		</form>      	      			
          	</div>
          	<div class="col-sm-8">
          		<div class="row">
      				<div class="col-sm-8">
		          		 Nombre <br>
			        	<input type="input" name="txt_nombre" id="txt_nombre" class="form-control">
		          	</div>
		          	<div class="col-sm-4">          		
				        CI <br>
				        <input type="input" name="txt_ci" id="txt_ci" class="form-control">          		
		          	</div>
		          	<div class="col-sm-6">
		          		  Puesto <br>
			        <input type="input" name="txt_puesto" id="txt_puesto" class="form-control">
		          		
		          	</div>
		          	<div class="col-sm-6">   
		          		Correo <br>
			        <input type="input" name="txt_email" id="txt_email" class="form-control"> 
		          		
		          	</div>
		          	<div class="col-sm-6">   
		          		Telefono <br>
			        <input type="input" name="txt_telefono" id="txt_telefono" class="form-control"> 
		          		
		          	</div>
		          	<div class="col-sm-6">   
		          	  	Unidad ORG <br>
			        	<input type="input" name="txt_unidad" id="txt_unidad" class="form-control">
		         		</div>
		         		 <div class="col-sm-12">   
		          		  Direccion <br>
		          		  <textarea class="form-control" style="resize:none" cols="2" id="txt_direccion" name="txt_direccion"></textarea>
		          		
		          	</div>
          		</div>
         	</div> 
      	 </div>
      	<div class="modal-footer">
	       <button type="button" class="btn btn-primary" id="btn_editar" onclick="editar_insertar()">Guardar</button>
	       <button type="button" class="btn btn-danger" id="btn_eliminar" onclick="delete_datos()">Eliminar</button>
	    </div>

        <!-- Button trigger modal -->

    </section>
  </div>


        <?php include('./footer.php'); ?>
     