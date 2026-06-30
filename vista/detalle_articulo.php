<?php include('./header.php'); ?>
<script type="text/javascript">
    $( document ).ready(function() {      
  // navegacion();
     $("#subir_imagen").on('click', function() {
        var formData = new FormData(document.getElementById("form_img"));
        var files = $('#file_img')[0].files[0];
        formData.append('file',files);
       // formData.append('curso',curso);
        $.ajax({
            url: '../controlador/detalle_articuloC.php?cargar_imagen=true',
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
               }  else
               {
                cargar_datos($('#txt_id').val()); 
               } 
            }
        });
    });

  //--------------------------------
   $('#ddl_marca').on('select2:select', function (e) {
      var data = e.params.data.data;

      $('#lbl_sap_mar').text('SAP:'+data.CODIGO)     
      // console.log(data);
    });
  //---------------------------------
   $('#ddl_genero').on('select2:select', function (e) {
      var data = e.params.data.data;
      $('#lbl_sap_gen').text('SAP:'+data.CODIGO)        
      // console.log(data);
    });
  //---------------------------------
  $('#ddl_color').on('select2:select', function (e) {
      var data = e.params.data.data;      
      $('#lbl_sap_col').text('SAP:'+data.CODIGO)  
      console.log(data);
    });
  //---------------------------------
  $('#ddl_estado').on('select2:select', function (e) {
      var data = e.params.data.data;      
      $('#lbl_sap_est').text('SAP:'+data.CODIGO)  
      console.log(data);
    });
  //---------------------------------
  $('#ddl_proyecto').on('select2:select', function (e) {
      var data = e.params.data.data;      
      $('#lbl_sap_pro').text('SAP:'+data.pro)  
      console.log(data);
    });
  //---------------------------------
  $('#ddl_localizacion').on('select2:select', function (e) {
      var data = e.params.data.data;      
      $('#lbl_sap_loc').text('SAP:'+data.EMPLAZAMIENTO)  
      console.log(data);
    });
  //---------------------------------
  });
  
</script>
<script type="text/javascript">	
  $( document ).ready(function() {
    var id = '<?php if(isset($_GET['id'])){ echo $_GET['id'];} ?>';
    $('#txt_id').val(id);
  	autocmpletar_l();
  	autocmpletar();
  	autocmpletar_color();
  	autocmpletar_marca();
  	autocmpletar_genero();
  	// estado();
    autocmpletar_proyecto();
    validar_datos();
    autocmpletar_fam();
    autocmpletar_subfam();
    autocmpletar_clase_mov();
    autocmpletar_estado()
  });

  var pagi = 50;
     
  function consultar_datos(id='')
  { 
    var marcas='';
    var id = id;

    $.ajax({
      data:  {id:id},
      url:   '../controlador/marcasC.php?lista=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {    
         // console.log(response);   
        $.each(response, function(i, item){
         // console.log('sss');
         marcas+='<tr><td>'+item.CODIGO+'</td><td>'+item.DESCRIPCION+'</td><td><button class="btn btn-danger" tittle="Eliminar" onclick="delete_datos(\''+item.ID_MARCA+'\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button class="btn btn-primary" tittle="Editar" onclick="datos_col(\''+item.ID_MARCA+'\')" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td></tr>';
        });       
         $('#tbl_datos').html(marcas);        
      }
    });
  }

 function autocmpletar(){
      $('#ddl_custodio').select2({
        placeholder: 'Seleccione una custodio',
        ajax: {
          url: '../controlador/custodioC.php?lista=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }

   function autocmpletar_fam(){
      $('#ddl_familia').select2({
        placeholder: 'Seleccione una familia',
        ajax: {
          url: '../controlador/familiaC.php?lista=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }

     function autocmpletar_clase_mov(){
      $('#ddl_clase_mov').select2({
        placeholder: 'Seleccione una familia',
        ajax: {
          url: '../controlador/clase_movimientoC.php?buscar_auto=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }


  function autocmpletar_subfam(){
       var fa = $('#ddl_familia').val();
       if(fa==''){return false;}
      $('#ddl_subfamilia').select2({
        placeholder: 'Seleccione una Subfamilia',
        ajax: {
          url: '../controlador/familiaC.php?lista_subfamilia=true&fam='+fa,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }

   function autocmpletar_l(){
      $('#ddl_localizacion').select2({
        placeholder: 'Seleccione una localizacion',
        ajax: {
          url: '../controlador/localizacionC.php?lista=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }
  function autocmpletar_color(){
      $('#ddl_color').select2({
        placeholder: 'Seleccione un color',
        ajax: {
          url:  '../controlador/detalle_articuloC.php?colores=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }
  function autocmpletar_marca(){
      $('#ddl_marca').select2({
        placeholder: 'Seleccione una marca',
        ajax: {
          url: '../controlador/detalle_articuloC.php?marca=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }
  function autocmpletar_genero(){
      $('#ddl_genero').select2({
        placeholder: 'Seleccione una custodio',
        ajax: {
          url: '../controlador/detalle_articuloC.php?genero=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }
 // function estado()
 //  { 
 //    var id='';
 //    var estado = '<option value="">Seleccione Estado</option>';

 //    $.ajax({
 //      data:  {id:id},
 //      url:   '../controlador/estadoC.php?lista=true',
 //      type:  'post',
 //      dataType: 'json',
 //        success:  function (response) {    
 //        // console.log(response);   
 //        $.each(response, function(i, item){
 //        	estado+="<option value='"+item.ID_ESTADO+"''>"+item.DESCRIPCION+"</option>";

 //          // console.log(item);
 //        });       
 //        $('#ddl_estado').html(estado);        
 //      }
 //    });
 //  }
  function autocmpletar_estado(){
      $('#ddl_estado').select2({
        placeholder: 'Seleccione Estado',
        ajax: {
          url: '../controlador/estadoC.php?lista_drop=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }
  function autocmpletar_proyecto(){
      $('#ddl_proyecto').select2({
        placeholder: 'Seleccione una Proyecto',
        ajax: {
          url: '../controlador/detalle_articuloC.php?proyecto=true',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
  }


  function validar_datos()
  {
  	var id = '<?php if(isset($_GET["id"])){echo $_GET["id"];}else{echo "-1";} ?>';
  	// console.log(id);
  	if(id==-1)
  	{
  		alert('no a seleccionado ningun articulo');
  	}else
  	{

  		movimientos(id);
  		cargar_datos(id);

  	}
  }

  function cargar_datos(id)
  {
    $.ajax({
      data:  {id:id},
      url:   '../controlador/detalle_articuloC.php?cargar_datos=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {   
          console.log(response);

        $('#txt_id_A').val(response[0].id_AS);
        $('#txt_company').val(response[0].COMPANYCODE);
        $('#txt_description').val(response[0].nom);
        $('#txt_description2').val(response[0].des);
        $('#ddl_localizacion').append($('<option>',{value: response[0].id_loc, text: response[0].DENOMINACION,selected: true }));
        $('#ddl_custodio').append($('<option>',{value: response[0].id_cus, text: response[0].PERSON_NOM,selected: true }));
        $('#ddl_marca').append($('<option>',{value: response[0].mar, text: response[0].marca,selected: true }));
        $('#ddl_color').append($('<option>',{value: response[0].col, text: response[0].color,selected: true }));
        $('#ddl_genero').append($('<option>',{value: response[0].gen, text: response[0].genero,selected: true }));
        $('#ddl_proyecto').append($('<option>',{value: response[0].idpro, text: response[0].proyecto,selected: true }));
        $('#ddl_estado').append($('<option>',{value: response[0].est, text: response[0].estado,selected: true }));


        $('#ddl_familia').append($('<option>',{value: response[0].IDF, text: response[0].FAMILIA,selected: true }));
        $('#ddl_subfamilia').append($('<option>',{value: response[0].IDSUBF, text: response[0].SUBFAMILIA,selected: true }));
        $('#ddl_clase_mov').append($('<option>',{value: response[0].CLASE_MOVIMIENTO, text: response[0].MOVIMIENTO,selected: true }));
        $('#ddl_estado').val(response[0].est);
        $('#txt_asset').val(response[0].tag_s);
        $('#txt_subno').val(response[0].SUBNUMBER);
        $('#txt_assetsupno').val(response[0].ASSETSUPNO);
        $('#txt_rfid').val(response[0].rfid);
        $('#txt_tag_anti').val(response[0].ant);
        $('#txt_serie').val(response[0].SERIE);
        if(response[0].fecha!='' && response[0].fecha !=null)
        {
          $('#txt_fecha').val(formatoDate(response[0].fecha.date));
        }
        $('#txt_modelo').val(response[0].MODELO);
        $('#txt_id').val(response[0].id_A);        
        $('#txt_idA_img').val(response[0].id_A);
        $('#txt_observacion').val(response[0].OBSERVACION);
      	$("#img_articulo").attr("src","https://corsinf.com:447/repositorio_puce/?nombre="+response[0].IMAGEN);
        $('#txt_nom_img').val(response[0].tag_s);
        $('#txt_cant').val(response[0].QUANTY);
        $('#txt_unidad').val(response[0].BASE_UOM);
        if(response[0].ORIG_ACQ_YR!='' && response[0].ORIG_ACQ_YR!=null)
        {
          $('#txt_compra').val(formatoDate(response[0].ORIG_ACQ_YR.date));
        }
        $('#txt_carac').val(response[0].CARACTERISTICA);
        $('#txt_nota_inv').val(response[0].NOTA_INVE);
        $('#txt_valor').val(response[0].ORIG_VALUE);
        $('#txt_acti').val(response[0].ORIG_ASSET);
        $('#txt_cant').val(response[0].QUANTITY);
        $('#txt_compa').val(response[0].COMPANYCODE);
        if(response[0].FECHA_CONTA!='' && response[0].FECHA_CONTA!= null)
        {
          $('#txt_fecha_descapi').val(formatoDate(response[0].FECHA_CONTA.date));
        }


        $('#lbl_sap_col').text('SAP:'+response[0].Ccol);        
        $('#lbl_sap_est').text('SAP:'+response[0].Cest);
        $('#lbl_sap_mar').text('SAP:'+response[0].Cmar);
        $('#lbl_sap_pro').text('SAP:'+response[0].Cpro);
        $('#lbl_sap_gen').text('SAP:'+response[0].Cgen);
        $('#lbl_sap_loc').text('SAP:'+response[0].Cloc);
        $('#lbl_sap_mov').text('SAP:'+response[0].CLASE_MOVIMIENTO);


        bajas = false;terceros = false; patri = false;
        if(response[0].PATRIMONIALES=='1'){patri = true;}
        if(response[0].TERCEROS=='1'){terceros = true;}
        if(response[0].BAJAS=='1'){bajas = true;}

        if(patri==false && terceros==false && bajas==false)
        {
          $('#txt_ninguno').prop('checked',true );
        }

        $('#txt_bajas').prop('checked', bajas);
        $('#txt_tercero').prop('checked', terceros);
        $('#txt_patrimonial').prop('checked',patri );

        // $('#ddl_localizacion').val('55'); // Select the option with a value of '1'
        // console.log(response);   
      //    if($('#editar').val()==0 || $('#dba').val()==0)
      // {
      //   $('#btn_editar').hide();
      // }

        datos_col(response[0].id_cus);
        autocmpletar_subfam();
              
      }
    });
  }
  function movimientos()
  {
  	var table = '';
    var id =$('#txt_id').val();
    var desde = $('#txt_desde').val();    
    var hasta = $('#txt_hasta').val();
    if(desde!='' && hasta=='' || desde=='' && hasta!='')
    {
      Swal.fire('Rango de fecha no valido','Seleccione fechas correctas','info');
    }
    var parametros = 
    {
      'id':id,
      'desde':desde,
      'hasta':hasta,
    }
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/detalle_articuloC.php?movimientos=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {   
        $.each(response,function(i,item){
        	console.log(item);
        	table+="<tr><td>"+item.ob+"</td><td style='white-space: nowrap;'>"+formatoDate(item.fe.date)+"</td><td>"+item.codigo_ant+"</td><td>"+item.dante+"</td><td>"+item.codigo_nue+"</td><td>"+item.dnuevo+"</td><td>"+item.responsable+"</td></tr>"
        });
        $('#table_contenido').html(table); 

              
      }
    });
  }

  function guardar_articulo()
  {
    var parametros = 
    {

        'company': $('#txt_company').val(),
        'desc':$('#txt_description').val(),
        'des2':$('#txt_description2').val(),
        'loca':$('#ddl_localizacion').val(),
        'cust':$('#ddl_custodio').val(),
        'marc':$('#ddl_marca').val(),
        'colo':$('#ddl_color').val(),
        'gene':$('#ddl_genero').val(),
        'asse':$('#txt_asset').val(),
        'assetno':$('#txt_assetsupno').val(),
        'esta':$('#ddl_estado').val(),
        'rfid':$('#txt_rfid').val(),
        'tagA':$('#txt_tag_anti').val(),
        'seri':$('#txt_serie').val(),
        'fech':$('#txt_fecha').val(),
        'mode':$('#txt_modelo').val(),
        'idAr':$('#txt_id').val(),
        'idAs':$('#txt_id_A').val(),
        'obse':$('#txt_observacion').val(),
        'cant':$('#txt_cant').val(),
        'uni':$('#txt_unidad').val(),
        'compra':$('#txt_compra').val(),
        'cara':$('#txt_carac').val(),
        'valor':$('#txt_valor').val(),
        'act':$('#txt_acti').val(),
        'crit':$('#ddl_proyecto').val(),
        'bajas':$('#txt_bajas').prop('checked'),
        'terceros':$('#txt_tercero').prop('checked'),
        'patrimoniales':$('#txt_patrimonial').prop('checked'),
        'familia':$('#ddl_familia').val(),
        'subfamilia':$('#ddl_subfamilia').val(),
        'clase_mov':$('#ddl_clase_mov').val(),
        'movimiento':$('#ddl_clase_mov option:selected').text(),
        'nota_inv':$('#txt_nota_inv').val(),
    };
    // console.log(parametros);
    var id =$('#txt_id').val();
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/detalle_articuloC.php?guardarArticulo=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) { 
        if(response ==1)
        {
          Swal.fire(
            '',
            'Operacion realizada con exito.',
            'success'
          )
         cargar_datos(id);   
          movimientos();
        }else
        {
          Swal.fire(
            '',
            'Algo extraño a pasado.',
            'error'
          )

        }           
      }
    });

  }

  function navegacion()
   { 
     var fil1 = '<?php if(isset($_GET["fil1"])){echo $_GET["fil1"];} ?>';
    var fil2 = '<?php if(isset($_GET["fil2"])){echo $_GET["fil2"];} ?>';
    var id = '<?php if(isset($_GET["id"])){echo $_GET["id"];}else{echo "-1";} ?>';
    var botones = '';
    var parametros = 
    {
      'loc':fil1,
      'cus':fil2,
      'id':id,
    }

    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/detalle_articuloC.php?navegacion=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {
          if(response.atras != 0)
          {

          botones='<a class="btn btn-default" href="../vista/detalle_articulo.php?id='+response.atras+'&fil1=<?php echo $_GET['fil1']?>&fil2=<?php echo $_GET['fil2']?>"><i class="fa fa-caret-left"></i> Atras</a><a class="btn btn-default" href="../vista/detalle_articulo.php?id='+response.siguiente+'&fil1=<?php echo $_GET['fil1']?>&fil2=<?php echo $_GET['fil2']?>">Siguiente <i class="fa fa-caret-right"></i></a>';
          }else
          {
            botones='<a class="btn btn-default" href="../vista/detalle_articulo.php?id='+response.siguiente+'&fil1=<?php echo $_GET['fil1']?>&fil2=<?php echo $_GET['fil2']?>">Siguiente <i class="fa fa-caret-right"></i></a>';
          }

          $('#na').html(botones);

      }
    });

  }

  function datos_col(id)
  { 
    $('#titulo').text('Editar custodio');
    $('#op').text('Editar');
    var custodio='';

    $.ajax({
      data:  {id:id},
      url:   '../controlador/custodioC.php?listar_todo=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
          // console.log(response);
           $('#txt_nombre').val(response[0].PERSON_NOM); 
           $('#txt_ci').val(response[0].PERSON_CI); 
           $('#txt_email').val(response[0].PERSON_CORREO);
           $('#txt_puesto').val(response[0].PUESTO); 
           $('#txt_unidad_p').val(response[0].UNIDAD_ORG); 
           $('#id').val(response[0].ID_PERSON); 
      }
    });
  }

  function add_familia()
  {
    $('#modal_familia').modal('show');
  }
  function add_subfamilia()
  {
    var fam = $('#ddl_familia').val();
    if(fam=='')
    {
      Swal.fire('Seleccione una familia','','info');
      return false;
    }

    $('#modal_subfamilia').modal('show');
  }

  function guardar_familia()
  {    
    if($('#txt_new_familia').val()=='')
    {
      Swal.fire('Llene el campo','','info');
      return false;
    }
    var parametros = 
    {
      'id':'',
      'familia':$('#txt_new_familia').val(),
    }

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
          // console.log(response);
          if(response==1)
          {
            Swal.fire('Familia ingresada','','success');
            $('#modal_familia').modal('hide');
          }
      }
    });
  }

  function guardar_subfamilia()
  { 
   if($('#txt_new_subfamilia').val()=='')
    {
      Swal.fire('Llene el campo','','info');
      return false;
    }
    var parametros = 
    {
      'id':'',
      'familia':$('#ddl_familia').val(),
      'subfamilia':$('#txt_new_subfamilia').val(),
    }

    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/familiaC.php?insertar_sub=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
          // console.log(response);
          if(response==1)
          {
            Swal.fire('SubFamilia ingresada','','success');
            $('#modal_subfamilia').modal('hide');
          }
      }
    });
  }

  function editar_custodio()
  {
     idc = $('#id').val();
     location.href = '../vista/custodio_detalle.php?id='+idc;
  }

  function validar_campo()
  {
     var asset = $('#txt_asset').val();
     var cant = $('input[type=radio][name="rbl_asset"]:checked').val();
     if(cant!=0)
     {
        num_caracteres('txt_asset',cant);
     }

     console.log(asset);
     console.log(cant);
  }



</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
             <?php if($_GET['fil1']=='null--null' && $_GET['fil1']=='null--null'){   ?>
              <a class="btn btn-default btn-sm" href="../vista/articulos.php"><i class="fa fa-arrow-left"></i>  Salir</a>
            <?php }else{ ?>
              <a class="btn btn-default btn-sm" href="../vista/articulos.php?fil1=<?php echo $_GET['fil1']?>&fil2=<?php echo $_GET['fil2']?>"><i class="fa fa-arrow-left"></i> Salir</a><div id="na"></div>
            <?php } ?>
          </div>
          <div class="col-sm-6 text-right">
            <h1 class="m-0 text-dark">Detalle de articulos</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
         <nav>
           <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Articulo</a>
             <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Movimientos</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-custodio" role="tab" aria-selected="false">Custodio</a>
           </div>
         </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <br>
              <div class="row">
                  <div class="col-sm-3 text-center">
                    <img src="../img/computadora.jpg" class="img-fluid rounded" id="img_articulo"style="width: 75%"> 
                    <form enctype="multipart/form-data" id="form_img" method="post">
                      <div class="custom-file">
                        <input type="file" class="form-control form-control-sm" id="file_img" name="file_img">
                        <input type="hidden" name="txt_nom_img" id="txt_nom_img">
                        <input type="hidden" name="txt_idA_img" id="txt_idA_img">
                      </div>
                      <button type="button" class="btn btn-primary btn-sm" style="width: 100%" id="subir_imagen"> Subir Imagen</button>
                    </form>             
                  </div>
                  <div class="col-sm-9">              
                     <input type="hidden" name="" id="txt_id">
                     <input type="hidden" name="" id="txt_id_A">
                     <div class="row">
                       <div class="col-sm-3">
                        <label><input type="radio" id="txt_bajas" name="rbl_op"> Bajas</label>
                       </div>
                        <div class="col-sm-3">
                        <label><input type="radio" id="txt_patrimonial" name="rbl_op"> Patrimonial</label>
                       </div>
                        <div class="col-sm-3">
                        <label><input type="radio" id="txt_tercero" name="rbl_op"> Tercero</label>
                       </div>
                       <div class="col-sm-3">
                        <label><input type="radio" id="txt_ninguno" name="rbl_op" checked> Ninguno</label>
                       </div>
                     </div>
                    <div class="row">
                      <div class="col-sm-12" style="display:none;">
                        <b>Companycode</b><br>
                        <input type="text" class="form-control form-control-sm" name="" id="txt_company">
                      </div>  
                      <div class="col-sm-12">
                        <b>Descripcion</b><br>
                        <input type="text" class="form-control form-control-sm" name="" id="txt_description">
                      </div>                       
                    </div>
                    <div class="row" style="display:none;">
                          <div class="col-sm-6">
                            <!-- <b>Custodio</b><br> -->
                            <select class="form-control form-control-sm" id="ddl_custodio">
                              <option>Seleccione Custodio</option>
                            </select>
                          </div>
                                           
                     </div>
                    <div class="row">
                          <div class="col-sm-6">
                            <!-- <b>Custodio</b><br> -->
                            <select class="form-control form-control-sm" id="ddl_custodio" style="display:none;">
                              <option>Seleccione Custodio</option>
                            </select>
                            
                             <b>Descripcion 2</b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_description2">
                          </div>
                          <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-8"><b>Localizacion / Emplazamiento</b></div>
                                <div class="col-sm-4 text-right"><u><i class="text-xs text-right" id="lbl_sap_loc">SAP:</i></u></div>
                             </div>                            
                            <select class="form-control form-control-sm" id="ddl_localizacion">
                              <option>Seleccione Custodio</option>
                            </select>
                          </div>                       
                     </div>
                     <div class="row">
                         <div class="col-sm-4" style="display: none;">
                           <b>Assetsupno </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_assetsupno">
                         </div>
                         <div class="col-sm-4">
                           <b>Asset </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_asset" onkeyup="validar_campo()" readonly>
                           <div class="text-right">
                             <label class="text-xs"><input type="radio" name="rbl_asset" onclick="validar_campo()" value="8" checked>Activo(8)</label>
                             <label class="text-xs"><input type="radio" name="rbl_asset" onclick="validar_campo()" value="9">Patrimonial(9)</label>
                             <label class="text-xs"><input type="radio" name="rbl_asset" onclick="validar_campo()" value="0">Ninguno</label>
                           </div>
                         </div>
                          <div class="col-sm-1">
                           <b>SubNum </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_subno" readonly>
                         </div>
                         <div class="col-sm-4">
                             <b>Tag RFID </b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_rfid" onkeyup="num_caracteres('txt_rfid',24)" onblur="num_caracteres('txt_rfid',24)">
                           </div>
                            <div class="col-sm-3">
                         <b>Act. fijo original </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_acti" readonly>
                         </div>

                           <div class="col-sm-3" style="display:none;">
                             <b>Tag antiguo </b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_tag_anti" readonly>
                           </div>                       
                     </div>
                     <div class="row">

                       <div class="col-sm-4">
                            <div class="row">
                              <div class="col-sm-8"><b>Clase de movimiento</b></div>
                              <div class="col-sm-4 text-right"><u><i class="text-xs text-right" id="lbl_sap_mov">SAP:</i></u></div>
                            </div>
                             <div class="input-group">
                              <select class="form-control form-control-sm" id="ddl_clase_mov" onchange="autocmpletar_subfam()">
                                 <option value="">Selecciones</option>
                               </select>
                               <!-- <span class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="add_familia()" title="Nueva familia"><i class="fa fa-plus"></i></button>
                              </span> -->                               
                             </div>                             
                         </div>

                       <div class="col-sm-4">
                             <b>Familia</b><br>
                             <div class="input-group">
                              <select class="form-control form-control-sm" id="ddl_familia" onchange="autocmpletar_subfam()">
                                 <option value="">Selecciones</option>
                               </select>
                               <span class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="add_familia()" title="Nueva familia"><i class="fa fa-plus"></i></button>
                              </span>                               
                             </div>                             
                         </div>
                          <div class="col-sm-4">
                             <b>Sub Familia</b><br>
                             <div class="input-group">
                                 <select class="form-control form-control-sm" id="ddl_subfamilia">
                                   <option value="">Selecciones</option>
                                 </select>
                                 <span class="input-group-append">
                                  <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="add_subfamilia()" title="Nueva sub familia"><i class="fa fa-plus"></i></button>
                                </span>                                     
                             </div>                             
                         </div>                       
                     </div>
                     <div class="row">
                        <div class="col-sm-3">
                           <b>CompanyCode </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_compa">
                         </div>  
                         <div class="col-sm-3">
                         <b>Modelo </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_modelo">
                         </div>
                          <div class="col-sm-3">
                         <b>Serie </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_serie">
                         </div>
                         <div class="col-sm-3">
                           <b>Fecha de Compra </b><br>
                           <input type="date" class="form-control form-control-sm" name="" id="txt_compra" readonly>
                         </div>                       
                     </div>                     
                     <div class="row">
                         <div class="col-sm-3">
                             <div class="row">
                                <div class="col-sm-6"><b>Marca</b></div>
                                <div class="col-sm-6 text-right"><u><i class="text-xs text-right" id="lbl_sap_mar">SAP:</i></u></div>
                             </div>
                             <select class="form-control form-control-sm" id="ddl_marca">
                               <option>Selecciones</option>
                             </select>
                         </div>
                         <div class="col-sm-3">
                            <div class="row">
                                <div class="col-sm-6"><b>Estado</b></div>
                                <div class="col-sm-6 text-right"><u><i class="text-xs text-right" id="lbl_sap_est">SAP:</i></u></div>
                             </div>
                            <select class="form-control form-control-sm input-sm" id="ddl_estado">
                              <option>Selecciones</option>
                            </select>
                         </div>
                         <div class="col-sm-3">
                            <div class="row">
                                <div class="col-sm-6"><b>Genero</b></div>
                                <div class="col-sm-6 text-right"><u><i class="text-xs text-right" id="lbl_sap_gen">SAP:</i></u></div>
                             </div>
                           <select class="form-control form-control-sm" id="ddl_genero">
                             <option>Selecciones</option>
                           </select>
                         </div>  
                         <div class="col-sm-3">
                            <div class="row">
                                <div class="col-sm-6"><b>Color</b></div>
                                <div class="col-sm-6 text-right"><u><i class="text-xs text-right" id="lbl_sap_col">SAP:</i></u></div>
                             </div>
                            <select class="form-control form-control-sm" id="ddl_color">
                              <option>seleccione</option>
                            </select>
                         </div>  
                     </div>
                     <div class="row">
                      <div class="col-sm-12">
                         <b>Caracteristica </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_carac">
                         </div> 
                      <div class="col-sm-12">
                         <b>Nota inventario </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_nota_inv">
                         </div>                                                     
                     </div>
                     <div class="row">
                      <div class="col-sm-3">
                           <b>Cantidad </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_cant">
                         </div>  
                         <div class="col-sm-3">
                           <b>Valor actual </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_valor" readonly>
                         </div>
                         <div class="col-sm-3">
                         <b>Unidad medida  </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_unidad">
                         </div>                         
                         <div class="col-sm-3">
                           <b>Fecha de inventario </b><br>
                           <input type="date" class="form-control form-control-sm" name="" id="txt_fecha" readonly>
                         </div>                       
                     </div>
                     <div class="row">                      
                         <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6"><b>Proyecto</b></div>
                                <div class="col-sm-6 text-right"><u><i class="text-xs text-right" id="lbl_sap_pro">SAP:</i></u></div>
                             </div>
                            <select class="form-control form-control-sm" id="ddl_proyecto">
                              <option>seleccione</option>
                            </select>
                         </div>
                         <div class="col-sm-3">
                           <b>Descapitalizacion </b><br>
                           <input type="date" class="form-control form-control-sm" name="" id="txt_fecha_descapi" readonly>
                         </div>     
                                                                
                     </div>

            </div>            
          </div>
          <div class="row">
             <div class="col-sm-12">
                <b>Observacion</b>
              <textarea placeholder="observacion" style="width: 100%;height: 100px" id="txt_observacion"></textarea>
              </div>              
          </div>
          <div class="text-right">
            <button class="btn btn-primary" onclick="guardar_articulo()" id="btn_editar"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar</button>
          </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
               <h3>Movimiento por articulo</h3>
              <div class="row">
                <br>
                 <div class="col-sm-2">
                  <b>Desde</b>
                   <input type="date" name="txt_desde" id="txt_desde" class="form-control form-control-sm">
                </div>
                 <div class="col-sm-2">
                  <b>Hasta</b>
                   <input type="date" name="txt_hasta" id="txt_hasta" class="form-control form-control-sm">
                 </div>
                 <div class="col-sm-1"><br>
                   <button class="btn btn-primary btn-sm" onclick="movimientos()"><i class="fa fa-search"></i> Buscar</button>
                 </div>
                 <div class="col-sm-2"><br>
                   <button class="btn btn-default btn-sm" id="excel_movimientos_art"><i class="fa fa-file"></i> Informe</button>
                 </div>
                 <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <th>Proceso realizado</th>
                      <th style="white-space: nowrap;">Fecha Mov</th>
                      <th style="white-space: nowrap;">Cod ante.</th>
                      <th style="white-space: nowrap;">Dato anter.</th>
                      <th style="white-space: nowrap;">Cod nuevo</th>
                      <th style="white-space: nowrap;">Dato nuevo</th>
                      <th>Responsable</th>  
                    </thead>
                    <tbody id="table_contenido">
                      <tr><td colspan="3">NO se a encontado movimientos de este articulo</td></tr>  
                    </tbody>
                 </table>
                   
                 </div>                 
              </div>
            </div>            
            <div class="tab-pane fade" id="nav-custodio" role="tabpanel">
              <div class="row">
                <div class="col-sm-6">
                  <input type="hidden" name="id" id="id" class="form-control form-control-sm">
                  Nombre <br>
                  <input type="input" name="txt_nombre" id="txt_nombre" class="form-control form-control-sm">                  
                </div>
                <div class="col-sm-6">
                  CI <br>
                  <input type="input" name="txt_ci" id="txt_ci" class="form-control form-control-sm">                  
                </div>
                <div class="col-sm-6">
                   Correo <br>
                  <input type="input" name="txt_email" id="txt_email" class="form-control form-control-sm">                   
                </div>
                <div class="col-sm-6">
                    Puesto <br>
                  <input type="input" name="txt_puesto" id="txt_puesto" class="form-control form-control-sm">
                </div> 
                <div class="col-sm-12">
                   Unidad ORG <br>
                  <input type="input" name="txt_unidad_p" id="txt_unidad_p" class="form-control form-control-sm">              
                </div>                                   
               <div class="col-sm-12">
                <br>
                 <button class="btn btn-sm btn-primary" onclick="editar_custodio()">Editar custodio</button>
               </div>
              </div>
            </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<div class="modal fade" id="modal_familia" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Nueva familia</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="" name="txt_new_familia" id="txt_new_familia" class="form-control form-control-sm">          
        </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_vin_cus" onclick="guardar_familia()">Guardar</button>
       
      </div>
    </div>
  </div>
</div><!-- /.container-fluid -->


<div class="modal fade" id="modal_subfamilia" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Nueva Sub familia</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="" name="txt_new_subfamilia" id="txt_new_subfamilia" class="form-control form-control-sm">                   
        </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_vin_cus" onclick="guardar_subfamilia()">Guardar</button>       
      </div>
    </div>
  </div>
</div><!-- /.container-fluid -->

 


<?php include('./footer.php'); ?>
     