<?php include('./header.php'); include('../controlador/usuariosC.php');?>
<script type="text/javascript">
	$( document ).ready(function() {
    lista_usuario();
    lista_usuario_ina();
    autocoplet_tipo();
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
   
  }

  function lista_usuario(parametros=false)
  {
  	if(parametros==false)
  	{
  	 var parametros = 
  	 {
  		'id':'',
  		'query':'',
    	}
   }
    $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?lista_usuarios=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            console.log(response);
           // if (response) 
           // {
            $('#tbl_datos').html(response);
            // $('#tbl_usuarios').html(response);
           // } 
          } 
          
       });
  }

  function lista_usuario_ina(parametros=false)
  {
  	if(parametros==false)
  	{
  	 var parametros = 
  	 {
  		'id':'',
  		'query':'',
    	}
   }
    $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?lista_usuarios_ina=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
           if (response) 
           {
            $('#tbl_usuarios_ina').html(response);
           } 
          } 
          
       });
  }

  function buscar_usuario()
  {
  	var parametros = 
  	{
  		'id':'',
  		'query':$('#txt_query').val(),
  	}
  	lista_usuario(parametros);
  }

  function add_usuario()
  {
  	var nom = $('#txt_nombre').val();
  	var ci = $('#txt_ci').val();
  	var tel = $('#txt_telefono').val();
  	var ema = $('#txt_emial').val();
  	var tip = $('#ddl_tipo_usuario').val();
  	var nic = $('#txt_nick').val();
  	var pas = $('#txt_pass').val();
  	var dir = $('#txt_dir').val();

    var id = $('#txt_usuario_update').val();
    if(tip=='' || nom=='' || ci=='' || tel=='' || ema=='' || nic=='' || pas=='')
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
           if (response==1) 
           {
            $('#nuevo_tipo_usuario').modal('hide');
            lista_usuario();
            lista_usuario_ina();

            if(id!='')
            {
              Swal.fire(
                  '',
                  'Registro Editado.',
                  'success');
            limpiar();
            }else{
            Swal.fire(
                  '',
                  'Registro agregado.',
                  'success');
          }
            limpiar();
            $('#btn_opcion').text('Guardar');
            $('#exampleModalLongTitle').text('Nuevo tipo de usuario');
           }else
           {

            $('#nuevo_tipo_usuario').modal('hide');
            Swal.fire(
                  '',
                  'No se pudo guardar intente mas tarde.',
                  'info');

            limpiar();
            $('#btn_opcion').text('Guardar');
           } 
          } 
          
       });

  }
  function limpiar()
  {
  	$('#txt_nombre').val('');
    $('#txt_ci').val('');
  	$('#txt_telefono').val('');
  	$('#txt_emial').val('');
  	$('#ddl_tipo_usuario').empty();
  	$('#txt_nick').val('');
  	$('#txt_pass').val('');
  	$('#txt_dir').val('');
    $('#txt_usuario_update').val('');

  }

  function Editar(id)
  {
     $('#nuevo_tipo_usuario').modal('show');
     $('#btn_opcion').text('Editar');
     $('#exampleModalLongTitle').text('Editar tipo de usuario');
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
           $('#txt_nombre').val(response[0].nom);
           $('#txt_ci').val(response[0].ci);
           $('#txt_telefono').val(response[0].tel);
  	       $('#txt_emial').val(response[0].email);
  	       $('#ddl_tipo_usuario').append($('<option>',{value: response[0].idt, text:response[0].tipo,selected: true }));;
  	       $('#txt_nick').val(response[0].nick);
  	       $('#txt_pass').val(response[0].pass);
  	       $('#txt_dir').val(response[0].dir);
           $('#txt_usuario_update').val(response[0].id);
           
          } 
          
       });

   }
  function Eliminar(id)
  {
     Swal.fire({
      title: 'Quiere eliminar este registro?',
      text: "Esta seguro de eliminar este registro!",
      type: 'warning',
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
            Swal.fire('','Registro eliminado.','success');
            lista_usuario();
            lista_usuario_ina();
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

   function Habilitar(id)
  {
     Swal.fire({
      title: 'Quiere habilitar este registro?',
      text: "Esta seguro de habilitar este registro!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
        	habilitar_usuario(id);
        }
      });
   }

   function inhabilitar_usuario(id)
   {
    $.ajax({
         data:  {id:id},
         url:   '../controlador/usuariosC.php?usuario_estado=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) { 
           	if (response==1) 
           	{
            lista_usuario();
            lista_usuario_ina();
           		Swal.fire('El usuario  se a inhabilitado!', 'El usuario no podra ingresar al sistema', 'success');

           	}else
           	{
           		Swal.fire('', 'UPs aparecio un problema', 'success');
           	}          
           
          } 
          
       });

   }
   function habilitar_usuario(id)
   {
    $.ajax({
         data:  {id:id},
         url:   '../controlador/usuariosC.php?usuario_estado_=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) { 
           	if (response==1) 
           	{
            Swal.fire('','Registro habilitado.','success');
            lista_usuario();
            lista_usuario_ina();
           	}else
           	{
           		Swal.fire('', 'UPs aparecio un problema', 'success');
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
            <h1 class="m-0 text-dark">Usuario registrados</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-sm-6">
      			<a class="btn btn-success btn-sm" href="detalle_usuario.php"><i class="fas fa-plus nav-icon"></i> Nuevo</a>
      		</div>      		
      	</div><br>
      	<div class="row">
      		<div class="col-sm-3">
      			<input type="text" name="" id="txt_query" onkeyup="buscar_usuario()" class="form-control form-control-sm" placeholder="Buscar usuario por CI o Nombre">
      		</div>
      		
      	</div>

        <div class="row">
                   <div class="card card-solid col-sm-12">
                <div class="card-body pb-0">
                  <div class="row d-flex align-items-stretch" id="tbl_datos">
                    
                           
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0" id="pag">
                      
                    </ul>
                  </nav>
                </div>
              </div>

        <!-- /.card-footer -->


          </div>          
        </div>
  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<div class="modal fade" id="nuevo_tipo_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form_usuario_new">
        <div class="row">
          <div class="col-sm-12">
            <b>NOMBRE COMPLETO</b>
            <input type="hidden" name="txt_usuario_update" id="txt_usuario_update">
            <input type="text"  class="form-control form-control-sm" name="txt_nombre" id="txt_nombre" required="">
          </div>
          <div class="col-sm-6">
          	<b>CI / RUC  </b>          
            <input type="text"  class="form-control form-control-sm" name="txt_ci" id="txt_ci" required="" onblur="validar_cedula('txt_ci','U')" onkeyup=" solo_numeros('txt_ci');num_caracteres('txt_ci',10)">
          </div>
          <div class="col-sm-6">
          	<b>TELEFONO</b>
            <input type="text"  class="form-control form-control-sm" name="txt_telefono" id="txt_telefono" required="" onkeyup=" solo_numeros('txt_telefono');num_caracteres('txt_telefono',10)">
          </div>
          <div class="col-sm-12">
            <b>EMAIL   </b>         
            <input type="text"  class="form-control form-control-sm" name="txt_emial" id="txt_emial" required="">
            <b>TIPO USUARIO</b>
            <select class="form-control form-control-sm" name="ddl_tipo_usuario" id="ddl_tipo_usuario" required="">
            	<option value="">Seleccione tipo de usuario</option>
            </select><br>
            <b>NICK</b>
            <input type="text"  class="form-control form-control-sm" name="txt_nick" id="txt_nick" required="">
            <b>PASSWORD</b>
            <input type="text"  class="form-control form-control-sm" name="txt_pass" id="txt_pass" required="">
            <b>DIRECCION</b>
            <textarea style="resize:none;" class="form-control" id="txt_dir" name="txt_dir" required=""></textarea>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="add_usuario();" id="btn_opcion">Guardar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cerrar</button>
        </div>
    </div>
  </div>
</div>

<?php include('./footer.php'); ?>
