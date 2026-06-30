<?php include('./header.php'); $id =''; if(isset($_GET['id'])){$id= $_GET['id'];}?>
<script type="text/javascript">
  $( document ).ready(function() {
  	var id = '<?php echo $id;?>';
    if(id!='')
    {
    	datos_col(id);
    }
});
     
  // function consultar_datos(id='')
  // { 
  //   var proyectos='';

  //   $.ajax({
  //     data:  {id:id},
  //     url:   '../controlador/proyectosC.php?lista=true',
  //     type:  'post',
  //     dataType: 'json',
  //     /*beforeSend: function () {   
  //          var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
  //        $('#tabla_').html(spiner);
  //     },*/
  //       success:  function (response) {    
  //       // console.log(response);   
  //       $.each(response, function(i, item){
  //         console.log(item);
  //       proyectos+='<tr><td>'+item.id+'</td><td>'+item.pro+'</td><td>'+item.enti+'</td><td>'+item.deno+'</td><td>'+item.desc+'</td><td>'+item.valde.date.substr(0,10)+'</td><td>'+item.vala.date.substr(0,10)+'</td><td>'+item.exp.date.substr(0,10)+'</td><td>';
       
  //       if($('#elimina').val()==1 || $('#dba').val()==1)
  //       {
  //         proyectos+='<button class="btn btn-danger" tittle="Eliminar" onclick="delete_datos(\''+item.id+'\')"><i class="fa fa-trash"></i></button>';
  //       }if($('#editar').val()==1 || $('#dba').val()==1)
  //       {
  //         proyectos+='<button class="btn btn-primary" tittle="Editar" onclick="datos_col(\''+item.id+'\')" data-toggle="modal" data-target="#myModal"><i class="fa fa-paint-brush"></i></button>';
  //       }
  //       });      
  //       $('#tbl_datos').html(proyectos);            
  //     }
  //   });
  // }

  function datos_col(id)
  { 
    // $('#titulo').text('Editar Proyecto');
    // $('#op').text('Editar');
    var proyectos='';

    $.ajax({
      data:  {id:id},
      url:   '../controlador/proyectosC.php?lista=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
           $('#codigo').val(response[0].id); 
           $('#txt_fin').val(response[0].pro);
           $('#txt_enti').val(response[0].enti);
           $('#txt_deno').val(response[0].deno);
           $('#txt_descri').val(response[0].desc);
           $('#txt_valde').val(response[0].valde.date.substr(0,10));
           $('#txt_vala').val(response[0].vala.date.substr(0,10));
           $('#txt_expi').val(response[0].exp.date.substr(0,10));
      }
    });
  }

  function delete_datos(id)
  {
  	var id = '<?php echo $id;?>';
  	if(id!=''){
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
  }else
  {
  	Swal.fire('Registro no seleccionado','asegurese de escoger un registro','info');
  }

  }

  // function buscar(buscar)
  // {
  //    var proyectos='';

  //   $.ajax({
  //     data:  {buscar:buscar},
  //     url:   '../controlador/proyectosC.php?buscar=true',
  //     type:  'post',
  //     dataType: 'json',
  //     /*beforeSend: function () {   
  //          var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
  //        $('#tabla_').html(spiner);
  //     },*/
  //       success:  function (response) {    
  //       // console.log(response);   
  //       $.each(response, function(i, item){
  //         console.log(item);
  //        proyectos+='<tr><td>'+item.id+'</td><td>'+item.pro+'</td><td>'+item.enti+'</td><td>'+item.deno+'</td><td>'+item.desc+'</td><td>'+item.valde.date.substr(0,10)+'</td><td>'+item.vala.date.substr(0,10)+'</td><td>'+item.exp.date.substr(0,10)+'</td><td>';
  //      if($('#elimina').val()==1 || $('#dba').val()==1)
  //       {
  //         proyectos+='<button class="btn btn-danger" tittle="Eliminar" onclick="delete_datos(\''+item.id+'\')"><i class="fa fa-trash"></i></button>';
  //       }if($('#editar').val()==1 || $('#dba').val()==1)
  //       {
  //         proyectos+='<button class="btn btn-primary" tittle="Editar" onclick="datos_col(\''+item.id+'\')" data-toggle="modal" data-target="#myModal"><i class="fa fa-paint-brush"></i></button>';
  //       }
  //       });      
  //       $('#tbl_datos').html(proyectos);                    
  //     }
  //   });
  // }
  
  function insertar(parametros)
  {
     $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/proyectosC.php?insertar=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {  
        if(response==1)
        {
          Swal.fire(
            '',
            'Operaciopn realizada con exito.',
            'success'
          );
          limpiar();
           
        }else
        {
        	 Swal.fire(
            '',
            'Numero de financiacion existente.',
            'warning'
          );
        }
               
      }
    });

  }
  function limpiar()
  {
    $('#codigo').val(''); 
    $('#txt_fin').val('');
    $('#txt_enti').val('');
    $('#txt_deno').val('');
    $('#txt_descri').val('');
    $('#txt_valde').val('');
    $('#txt_vala').val('');
    $('#txt_expi').val(''); 
   	// $('#titulo').text('Nuevo color');
    // $('#op').text('Guardar');
           

  }
  function eliminar(id)
  {
     $.ajax({
      data:  {id:id},
      url:   '../controlador/proyectosC.php?eliminar=true',
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
	    ).then(function(){location.href = 'proyectos.php'})
        }  
               
      }
    });

  }
  function editar_insertar()
  {
    var id = $('#codigo').val(); 
    var fin= $('#txt_fin').val();
    var ent= $('#txt_enti').val();
    var den= $('#txt_deno').val();
    var des= $('#txt_descri').val();
    var val= $('#txt_valde').val();
    var vla= $('#txt_vala').val();
    var exp= $('#txt_expi').val();
    var parametros= 
    {
      'id':id,
      'fin':fin,
      'ent':ent,
      'den':den,
      'des':des,
      'val':val,
      'vla':vla,
      'exp':exp,
    }  
      if(id=='')
        {
          if(fin == '' || ent == '' || den == '' || des == '' || val == '' ||  vla== '' || exp == '')
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
           if(fin == '' || ent == '' || den == '' || des == '' || val == '' ||  vla== '' || exp == '')
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
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark">Proyectos</h1> -->
          </div>
        </div>
      </div>
    </div>
    <section class="content">
    	<div class="container-fluid">
        	<div class="row">
            	<div class="col-sm-12" id="btn_nuevo">            	
             		<a href="proyectos.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
              		<a href="#" class="btn btn-success btn-sm" onclick="location.href = 'detalle_proyectos.php'"><i class=" fa fa-plus"></i> Nuevo</a>
            	</div>
          	</div>
          	<div class="row">
          		<input type="hidden" name="" id="codigo" class="form-control" placeholder="Nombre del proyecto">
          		<div class="col-sm-3">
		        	Financiacion <br>
		        	<input type="text" name="descripcion" id="txt_fin" class="form-control" placeholder="Financiacion">
		    	</div>
		    	<div class="col-sm-9">
		         	Entidad <br>
		        	<input type="text" name="descripcion" id="txt_enti" class="form-control" placeholder="Entidad">
		    	</div>
		        <div class="col-sm-6">       
		       		Denominacion <br>
		        	<input type="text" name="descripcion" id="txt_deno" class="form-control" placeholder="Denominacion">
		    	</div>
		    	<div class="col-sm-6">
		        	Descripcion <br>
		        	<input type="text" name="descripcion" id="txt_descri" class="form-control" placeholder="Descripcion">
		    	</div>

		        <div class="col-sm-4">
		        	validez de <br>
		        	<input type="date" name="descripcion" id="txt_valde" class="form-control" placeholder="Validez de" value="<?php echo date('Y-m-d');?>">
		    	</div>
		        <div class="col-sm-4">
			        Validez a <br>
			        <input type="date" name="descripcion" id="txt_vala" class="form-control" placeholder="Validez a" value="<?php echo date('Y-m-d');?>">
		 		</div>       
		 		<div class="col-sm-4">
			         Expiracion <br>
			        <input type="date" name="descripcion" id="txt_expi" class="form-control" placeholder="Expiracion" value="<?php echo date('Y-m-d');?>">
				</div>
				       		
          	</div>
          	<div class="modal-footer">
          		<button type="button" class="btn btn-primary" onclick="editar_insertar()" id="btn_editar">Guardar</button>
				<button type="button" class="btn btn-danger" onclick="delete_datos()" id="btn_eliminar">Eliminar</button>
			</div>   
        </div>
    </section>
  </div>
<?php include('./footer.php'); ?>
     