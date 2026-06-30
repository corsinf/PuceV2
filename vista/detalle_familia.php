<?php include('./header2.php'); $id = ''; if(isset($_GET['id'])){$id=$_GET['id'];} ?>
<script type="text/javascript">
$( document ).ready(function() {
	var id = '<?php echo $id; ?>';
  if(id!='')
  {
	  datos_col(id);
  }

});

  function datos_col(id)
  { 
     var parametros = 
    {
      'id':id,
      'query':'',
    }

    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/familiaC.php?lista=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
           $('#descripcion').val(response[0].text);
           $('#id').val(response[0].id); 
      }
    });
  }



  function editar_insertar()
  {
     // var codigo = $('#codigo').val();
     var descri = $('#descripcion').val();
     var id = $('#id').val();
    
      var parametros = {
        // 'cod':codigo,
        'des':descri,
        'id':id,
      }
      if(id=='')
        {
          if(descri == '')
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
           if(descri == '')
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

   function insertar(parametros)
  {
     $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/familiaC.php?insertar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {  
         if(response == 1)
        {
          Swal.fire('','Operacion realizada con exito.','success').then(function(){          
          location.href = 'familias.php';
         });
        }else if(response==-2)
        {
          Swal.fire('','codigo ya regitrado','info');
        }  
               
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

   function eliminar(id)
  {
     $.ajax({
      data:  {id:id},
      url:   '../controlador/familiaC.php?eliminar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {  
       if(response == 1)
        {
         Swal.fire('Eliminado!','Registro Eliminado.','success').then(function(){          
          location.href = 'colores.php';
         });
        }  
               
      }
    });

  }
</script>
<div class="content">
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detalle marca</h1>
          </div>
        </div>
      </div>
    </div> -->
    <br>
    <section class="content">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-sm-12">
      			<a href="familias.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-5">
  			<input type="hidden" name="id" id="id" class="form-control" hidden="">
  			 <!-- Codigo de color<br> -->
  			 <!-- <input type="input" name="codigo" id="codigo" class="form-control">   -->
  			 Descripcion de familia<br>
  			 <input type="input" name="descripcion" id="descripcion" class="form-control form-control-sm"> 
  			<div class="modal-footer">
		      	<button class="btn btn-primary btn-sm" onclick="editar_insertar()" type="button"><i class="fa fa-save"></i> Guardar</button>
		      	<button class="btn btn-danger btn-sm" onclick="delete_datos()" type="button"><i class="fa fa-trash"></i> Eliminar</button>
		    </div>  
      			  			
      		</div>
      	</div>
      	<br>
      </div>      
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
