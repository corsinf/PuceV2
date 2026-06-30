<?php include('./header.php'); ?>
<script type="text/javascript">
$( document ).ready(function() {
    var id = '<?php echo $_SESSION['INICIO']['ID_USUARIO'];?>';
   	console.log(id);
   	if(id!='')
   	{
   		Editar(id)
   	}

});

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
           $('#txt_nombre').val(response[0].nombres);
           $('#txt_apellido').val(response[0].ape);
           $('#txt_ci').val(response[0].ci);
           $('#txt_telefono').val(response[0].tel);
  	       $('#txt_emial').val(response[0].email);
  	       $('#txt_emial_2').val(response[0].email);
  	       // $('#ddl_tipo_usuario').append($('<option>',{value: response[0].idt, text:response[0].tipo,selected: true }));;
  	       $('#txt_nick').val(response[0].nick);
  	       $('#txt_pass').val(response[0].pass);
  	       var passlen = response[0].pass.length;
  	       $('#pass').text('*'.repeat(passlen));

  	       $('#txt_dir').val(response[0].dir);
           $('#txt_id').val(response[0].id);
           
          } 
          
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


   function confirmar(tipo)
   {
   	 Swal.fire({
      title: 'Quiere guardar nuevas credenciales?',
      text: "Si guarda las crecenciales tendra que iniciar session nuevamente!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
        	if(tipo=='E')
        	{
        		guardar_email();
        	}else
        	{
        		guardar_pass();
        	}
        }
    });
   }

   function guardar_datos_personales()
   {
   	var parametros = 
   	{
   		'nombre':$('#txt_nombre').val(),
   		'apellido':$('#txt_apellido').val(),
   		'ci':$('#txt_ci').val(),
   		'telefono':$('#txt_telefono').val(),
   		'email':$('#txt_emial').val(),
   		'direccion':$('#txt_dir').val(),
   		'id':'<?php echo $_SESSION['INICIO']['ID_USUARIO'];?>',
   	}
   	 $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?guardar_perfil=true',
         type:  'post',
         dataType: 'json',         
           success:  function (response) {  
           	if(response==1)
           	{
           		Swal.fire('Datos guardados','','success');
           	}
           }
       })


   }
   function guardar_email()
   {
   	 var email = $('#txt_emial_2').val();
	   	if(email!='')
	   	{

	   	}else
	   	{
	   		Swal.fire('Email incorrecto','debe llenar el campo de email','info');
	   	}

	var parametros = 
   	{
   		'email':email,
   		'id':'<?php echo $_SESSION['INICIO']['ID_USUARIO'];?>',
   	}
   	 $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?guardar_email=true',
         type:  'post',
         dataType: 'json',         
           success:  function (response) {  
           	if(response==1)
           	{
           		Swal.fire('Email Cambiado','','success').then(function(){
           		cerrar_session();
           		});
           	}
           }
       })

   }
   function guardar_pass()
   {
   	var pass_n= $('#txt_pass_n').val();
   	var pass_c= $('#txt_pass_c').val();
   	if(pass_c=='' || pass_n=='')
   	{
   		Swal.fire('Llene todos los campos','Nueva password o confirmacion vacia','info');
   		return false;
   	}
   	if(pass_c!=pass_n)
   	{
   		Swal.fire('Password no son iguales','Ingrese la misma password','error');
   		return false;
   	}
   	var parametros = 
   	{
   		'pass':pass_c,
   		'id':'<?php echo $_SESSION['INICIO']['ID_USUARIO'];?>',
   	}
   	 $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?guardar_pass=true',
         type:  'post',
         dataType: 'json',         
           success:  function (response) {  
           	if(response==1)
           	{
           		Swal.fire('Password Cambiada','','success').then(function(){
           		cerrar_session();
           		});
           	}
           }
       })

   }
</script>
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">


             <?php //print_r($_SESSION['INICIO']); ?>
      	<div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">
                 <?php echo $_SESSION['INICIO']['USUARIO']; ?></h3>
                <h5 class="widget-user-desc"><?php echo $_SESSION['INICIO']['TIPO']; ?></h3></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="../img/de_sistema/puce_logo.png" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <!-- <h5 class="description-header">3,200</h5> -->
                      <span class="description-text">Datos de accesos</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Email</h5>
                      <span class="description-text"><?php echo $_SESSION['INICIO']['EMAIL'];?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">Password</h5>
                      <span class="description-text" id="pass">**</span>
                    </div>
                  </div>
                </div>
                <div class="row">
	                <div class="col-sm-6">
	                	<b>Nombre:</b>
	                 	<input type="" name="txt_nombre" id="txt_nombre" class="form-control form-control-sm">
	                 	<b>Apellido:</b>
	                 	<input type="" name="txt_apellido" id="txt_apellido" class="form-control form-control-sm">
	                 	<b>CI / RUC:</b>
	                 	<input type="" name="txt_ci" id="txt_ci" class="form-control form-control-sm">
	                 	<b>Telefono:</b>
	                 	<input type="" name="txt_telefono" id="txt_telefono" class="form-control form-control-sm">	                	
	                 	<b>Email:</b>
	                 	<input type="" name="txt_emial" id="txt_emial" class="form-control form-control-sm" readonly>
	                 	<b>Password:</b>
	                 	<div class="input-group input-group-sm">
				          <input type="password" class="form-control form-control-sm" name="txt_pass" id="txt_pass" required="" readonly>
		                  <span class="input-group-append">
		                    <button type="button" class="btn btn-info btn-flat" onclick="pass()"><i class="nav-icon fas fa-eye"></i></button>
		                  </span>
		                </div>
	                 	<b>Direccion:</b>
	                 	<textarea rows="3" class="form-control" style="resize:none;" id="txt_dir"></textarea>
	                 	<div class="modal-footer">
	                 		<button class="btn btn-primary" onclick="guardar_datos_personales()">Guardar</button>
	                 	</div>
	                </div>
	                <div class="col-sm-6">
	                		<br>
	                	<div class="row">
	                		<div class="col-md-12">
					            <div class="card card-secondary collapsed-card">
					              <div class="card-header">
					                <h3 class="card-title">Cambiar email de ingreso</h3>
					                <div class="card-tools">
					                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
					                  </button>
					                </div>
					                <!-- /.card-tools -->
					              </div>
					              <!-- /.card-header -->
					              <div class="card-body" style="display: none;">
					                <b>Email:</b>
					                <input type="" name="txt_emial_2" id="txt_emial_2" class="form-control form-control-sm">
					                <div class="modal-footer">
				                 		<button class="btn btn-primary" onclick="confirmar('E')">Guardar</button>
				                 	</div>
					              </div>
					            </div>
					            <!-- /.card -->
					            <div class="card card-secondary collapsed-card">
					              <div class="card-header">
					                <h3 class="card-title">Cambiar password de ingreso</h3>
					                <div class="card-tools">
					                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
					                  </button>
					                </div>
					                <!-- /.card-tools -->
					              </div>
					              <!-- /.card-header -->
					              <div class="card-body" style="display: none;">
				                 	<b>Nuevo password:</b>
				                 	<input type="password" name="txt_pass_n" id="txt_pass_n" class="form-control form-control-sm">
				                 	<b>confirmar password:</b>
				                 	<input type="password" name="txt_pass_c" id="txt_pass_c" class="form-control form-control-sm">
				                 	<div class="modal-footer">
				                 		<button class="btn btn-primary" onclick="confirmar('P')">Guardar</button>
				                 	</div>
					              </div>
					              <!-- /.card-body -->
					            </div>
					          </div>
	                	</div>
	                	
	                </div>
                	
                </div>
              </div>
            </div>
          </div>




                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
