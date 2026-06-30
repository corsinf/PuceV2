<?php include('./header.php'); $id=''; ?>
<script type="text/javascript">
   $( document ).ready(function() {
     autocoplet_tipo();
     autocoplet_arti();
    var id = '<?php if(isset($_GET["usuario"])){ $id = $_GET["usuario"]; echo $_GET["usuario"];} ?>';
   	console.log(id);
   	if(id!='')
   	{
   		Editar(id)
   	}


    $("#subir_imagen").on('click', function() {

       var fileInput = $('#file_img').val();  
       var id = $('#txt_id').val();
      if(id=='')
      {
        Swal.fire('','Asegurese de llenar los datos primero','warning');
        return false;
      }
      if(fileInput=='')
      {
        Swal.fire('','Seleccione una imagen','warning');
        return false;
      }


        var formData = new FormData(document.getElementById("form_img"));
         $.ajax({
            url: '../controlador/usuariosC.php?cargar_imagen=true',
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
                $('#file_img').val('');  
                var id = '<?php echo $id; ?>';
                Editar(id);        
               } 
            }
        });
    });
    // --------------------------

    });

   	function autocoplet_tipo(){
      $('#ddl_tipo_usuario').select2({
        placeholder: 'Seleccione una tipo de usuario',
        width:'90%',
        ajax: {
          url:   '../controlador/usuariosC.php?tipo=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            // console.log(data);
            return {
              results: data
            };
          },
          cache: true
        }
      });


      document.onkeydown = checkKey;   
  }

  function Editar(id)
  {
     // $('#nuevo_tipo_usuario').modal('show');
     // $('#btn_opcion').text('Editar');
     // $('#exampleModalLongTitle').text('Editar tipo de usuario');
     var parametros = 
  	{
  		'id':id,
  		'query':'',
  	}
    $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?datos_usuarios=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) { 
           console.log(response);
           // if(response[0].maestro ==1)
           // {
           //   $('#rbl_si').prop('checked',true);
           //   $('#rbl_no').prop('checked',false);
           // }else
           // {

           //   $('#rbl_no').prop('checked',true);
           //   $('#rbl_si').prop('checked',false);
           // }
           $('#txt_nombre').val(response[0].nombres);
           $('#txt_ci').val(response[0].ci);
           $('#txt_telefono').val(response[0].tel);
  	       $('#txt_emial').val(response[0].email);
  	       $('#ddl_tipo_usuario').append($('<option>',{value: response[0].idt, text:response[0].tipo,selected: true }));;
  	       $('#txt_apellido').val(response[0].ape);
  	       $('#txt_pass').val(response[0].pass);
  	       $('#txt_dir').val(response[0].dir);
           $('#txt_usuario_update').val(response[0].id);
           $('#img_foto').attr('src',response[0].foto+'?'+Math.random());
           
          } 
          
       });

   }

  function Eliminar()
  {
    var id = $('#txt_usuario_update').val();
     Swal.fire({
      title: 'Quiere eliminar este registro?',
      text: "Esta seguro de eliminar este registro!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {

    $.ajax({
         data:  {id:id},
         url:   '../controlador/usuariosC.php?eliminar_tipo=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) { 
           if(response==1)
           {
            Swal.fire('','Registro eliminado.','success').then(function(){

              window.location.href = 'usuarios.php';
            });
           } else if(response == -2)
           {
            Swal.fire({
              title: 'El Usuario esta ligado a uno o varios registros y no se podra eliminar.?',
              text: "Desea inhabilitado a este usuario?",
              showDenyButton: true,
              showCancelButton: true,
              confirmButtonText:'Si!',
            }).then((result) => {
                if (result.isConfirmed) {
                  inhabilitar_usuario(id);
                  }
                })
             // Swal.fire('','El Usuario esta ligado a uno o varios registros y no se podra eliminar.','error')
           }else
           {
            Swal.fire('','No se pudo elimnar.','info')
           }
          } 
          
       });}
      });
   }


   function pass()
   {
   	 var pa =document.getElementById("txt_pass");
   	 if(pa.type == 'password')
   	 {
   	 	pa.type = 'text';
   	 }else
   	 {
   	 	pa.type = 'password';
   	 }
   }

  function add_usuario()
  {

  	var nom = $('#txt_nombre').val();
  	var ci = $('#txt_ci').val();
  	var tel = $('#txt_telefono').val();
  	var ema = $('#txt_emial').val();
  	var tip = $('#ddl_tipo_usuario').val();
  	var nic = $('#txt_apellido').val();
  	var pas = $('#txt_pass').val();
  	var dir = $('#txt_dir').val();

    var id = $('#txt_usuario_update').val();
    if(tip=='' || nom=='' || ci=='' || tel=='' || ema==''  || pas=='' || nic=='')
    {
      Swal.fire('','Asegurese de llenar todo los campos.','info')
      return false;
    }

    var datos = $('#form_usuario_new').serialize();
    $.ajax({
         data:  datos,
         url:   '../controlador/usuariosC.php?guardar_usuario=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
           // if (response==1) 
           // {
            // $('#nuevo_tipo_usuario').modal('hide');
            // lista_usuario();
            // lista_usuario_ina();

            if(id!='')
            {
              Swal.fire(
                  '',
                  'Registro Editado.',
                  'success');
            // limpiar();
            }else{
            Swal.fire(
                  '',
                  'Registro agregado.',
                  'success').then(function(){
                    location.href='detalle_usuario.php?usuario='+response;
                  });
          }
            // limpiar();
            // $('#btn_opcion').text('Guardar');
            // $('#exampleModalLongTitle').text('Nuevo tipo de usuario');
           // }else
           // {

           //  // $('#nuevo_tipo_usuario').modal('hide');
           //  Swal.fire(
           //        '',
           //        'No se pudo guardar intente mas tarde.',
           //        'info');

           //  // limpiar();
           //  // $('#btn_opcion').text('Guardar');
           // } 
          } 
          
       });

  }
function checkKey(e) {

    e = e || window.event;

    if (e.keyCode == '38') {
        // up arrow
    }
    else if (e.keyCode == '40') {
        // down arrow
    }
    else if (e.keyCode == '37') {
      $('#btn_izquierda').click();
    }
    else if (e.keyCode == '39') {
      $('#btn_derecha').click();
    }

}
 function autocoplet_arti(){
      $('#ddl_usuario').select2({
        placeholder: 'Buscar cliente',
        width:'90%',
        ajax: {
          url:  '../controlador/usuariosC.php?lista_usuarios_ddl2=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            // console.log(data);
            return {
              results: data
            };
          },
          cache: true
        }
      });
   
  }

  function cargar_busqueda(id)
  {
    window.location.href = 'detalle_usuario.php?usuario='+id;
  }

</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
          <div class="col-sm-12">
             <a class="btn btn-default btn-sm" href="usuarios.php"><i class="fas fa-arrow-left nav-icon"></i> Regresar</a>
            <a class="btn btn-success btn-sm" href="detalle_usuario.php"><i class="fas fa-plus nav-icon"></i> Nuevo</a>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
             <select id="ddl_usuario" onchange="cargar_busqueda(this.value)">
              <option value="">Buscar usuario</option>
            </select>            
          </div>     
          <div class="col-sm-6 text-right">
             <button class="btn btn-default" id="btn_izquierda" onclick="izquierda('U','txt_usuario_update')"> <i class="nav-icon fa fa-arrow-left"></i> </button>
             <button class="btn btn-default" id="btn_derecha" onclick="derecha('U','txt_usuario_update')"> <i class="nav-icon fa fa-arrow-right"></i> </button>
            </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      	<div class="card">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLongTitle">Nuevo usuario</h5> -->
        <div class="col-sm-12 text-right">
        </div>
        
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <form enctype="multipart/form-data" id="form_img" method="post" style="width: inherit;">
                <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $id;?>" class="form-control"> 
                  <div class="widget-user-image text-center">
                    <img class="img-circle elevation-2" src="../img/sin_imagen.jpg" alt="User Avatar" id="img_foto" name="img_foto" style="width: 300px;height: 250px;">
                 </div><br>
                  <input type="file" name="file_img" id="file_img" class="form-control form-control-sm">
                  <input type="hidden" name="txt_nom_img" id="txt_nom_img">
                  <button class="btn btn-primary btn-block" id="subir_imagen" type="button">Cargar imagen</button>
              </form>                     
          </div>
          <div class="col-sm-8">
          
      	<form id="form_usuario_new">
          <div class="row">
            <div class="col-sm-6">
              <b>NOMBRES</b>
              <input type="hidden" name="txt_usuario_update" id="txt_usuario_update">
              <input type="text"  class="form-control form-control-sm" name="txt_nombre" id="txt_nombre" required="">
            </div>
            <div class="col-sm-6">
              <b>APELLIDO</b>
              <input type="text"  class="form-control form-control-sm" name="txt_apellido" id="txt_apellido" required="">
              </div>
            <div class="col-sm-6">
            	<b>CI / RUC  </b>          
              <input type="text"  class="form-control form-control-sm" name="txt_ci" id="txt_ci" required="" onblur="validar_cedula('txt_ci','U')" onkeyup=" solo_numeros('txt_ci');num_caracteres('txt_ci',10)">
            </div>
            <div class="col-sm-6">
            	<b>TELEFONO</b>
              <input type="text"  class="form-control form-control-sm" name="txt_telefono" id="txt_telefono" required="" onkeyup=" solo_numeros('txt_telefono');num_caracteres('txt_telefono',10)">
            </div>
            <div class="col-sm-4">
              <b>EMAIL   </b>         
              <input type="text"  class="form-control form-control-sm" name="txt_emial" id="txt_emial" required="">
            </div>          
            <div class="col-sm-4">
              <b>Perfil de usuario</b>
              <select class="form-control form-control-sm" name="ddl_tipo_usuario" id="ddl_tipo_usuario" required="">
              	<option value="">Seleccione tipo de usuario</option>
              </select>
            </div>          
            
              <div class="col-sm-4">
                <b>PASSWORD</b>
                <div class="input-group input-group-sm">
                <input type="password"  class="form-control form-control-sm" name="txt_pass" id="txt_pass" required="">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat" onclick="pass()"><i class="nav-icon fas fa-eye"></i></button>
                      </span>
                    </div>

              </div>
              <div class="col-sm-4" style="display: none;">
                MAESTRO DE OBRA <br>
                <label><input type="radio" name="rbl_maestro" id="rbl_si" value="1"> SI</label>
                <label><input type="radio" name="rbl_maestro" id="rbl_no" value="0"> NO</label>          
              </div>
              <div class="col-sm-12">
                <b>DIRECCION</b>
                <textarea style="resize:none;" class="form-control" id="txt_dir" name="txt_dir" required=""></textarea>
              </div>
          </div>
        </form>
      </div>
      </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="add_usuario();" id="btn_opcion">Guardar</button>
          <button type="button" class="btn btn-danger" onclick="Eliminar()">Eliminar</button>
        </div>
    </div>
                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
