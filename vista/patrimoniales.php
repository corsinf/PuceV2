<?php include('./header.php'); include "../lib/phpqrcode/qrlib.php";    $id = ''; if(isset($_GET['id'])){$id = $_GET['id'];} ?>
<script type="text/javascript">
    $( document ).ready(function() {      
  // navegacion();
     $("#subir_imagen").on('click', function() {
      var id = '<?php echo $id; ?>';
      if(id==''){ Swal.fire('No se pudo Subir la imagen','Asegurese de llenar primero el detalle','error')}
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


   $('#imprimir_qr').click(function(){      
     var id = $('#txt_id').val();
      var url='../lib/Reporte_pdf.php?codigo_qr=true&id='+id;
      window.open(url, '_blank');
  }); 





  });


 
</script>
<script type="text/javascript">	
  $( document ).ready(function() {
  	autocmpletar_l();
  	autocmpletar();
  	autocmpletar_color();
  	autocmpletar_marca();
  	autocmpletar_genero();
  	estado();
    autocmpletar_proyecto();
    validar_datos();
    var art = '<?php echo $id;?>';
    if(art!='')
    {
    	cargar_tarjeta(art);
    }
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

 function estado()
  { 
    var id='';
    var estado = '<option value="">Seleccione Estado</option>';

    $.ajax({
      data:  {id:id},
      url:   '../controlador/estadoC.php?lista=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {    
        // console.log(response);   
        $.each(response, function(i, item){
        	estado+="<option value='"+item.ID_ESTADO+"''>"+item.DESCRIPCION+"</option>";

          // console.log(item);
        });       
        $('#ddl_estado').html(estado);        
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
  		// alert('no a seleccionado ningun articulo');
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
          // console.log(response);
        $('#txt_company').val(response[0].COMPANYCODE);
        $('#txt_description').val(response[0].nom);
        $('#txt_description2').val(response[0].des);
        $('#ddl_localizacion').append($('<option>',{value: response[0].id_loc, text: response[0].DENOMINACION,selected: true }));
        $('#ddl_custodio').append($('<option>',{value: response[0].id_cus, text: response[0].PERSON_NOM,selected: true }));
        $('#ddl_marca').append($('<option>',{value: response[0].mar, text: response[0].marca,selected: true }));
        $('#ddl_color').append($('<option>',{value: response[0].col, text: response[0].color,selected: true }));
        $('#ddl_genero').append($('<option>',{value: response[0].gen, text: response[0].genero,selected: true }));
        $('#ddl_proyecto').append($('<option>',{value: response[0].idpro, text: response[0].proyecto,selected: true }));
        $('#ddl_estado').val(response[0].est);
        $('#txt_asset').val(response[0].tag_s);
        $('#txt_assetsupno').val(response[0].ASSETSUPNO);
        $('#txt_rfid').val(response[0].rfid);
        $('#txt_tag_anti').val(response[0].ant);
        $('#txt_serie').val(response[0].SERIE);
        $('#txt_fecha').val(response[0].fecha);
        $('#txt_modelo').val(response[0].MODELO);
        $('#txt_id').val(response[0].id_A);        
        $('#txt_idA_img').val(response[0].id_A);
        $('#txt_id_A').val(response[0].id_AS);
        $('#txt_observacion').val(response[0].OBSERVACION);
      	$("#img_articulo").attr("src","../img/"+response[0].IMAGEN);
        $('#txt_nom_img').val(response[0].tag_s);
        $('#txt_cant').val(response[0].QUANTY);
        $('#txt_unidad').val(response[0].BASE_UOM);
        $('#txt_compra').val(response[0].ORIG_ACQ_YR);
        $('#txt_carac').val(response[0].CARACTERISTICA);
        $('#txt_valor').val(response[0].ORIG_VALUE);
        $('#txt_acti').val(response[0].ORIG_ASSET);
        $('#txt_cant').val(response[0].QUANTITY);
        $('#txt_compa').val(response[0].COMPANYCODE);

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
              
      }
    });
  }

function cargar_tarjeta(id)
{
	$.ajax({
      data:  {id:id},
      url:   '../controlador/detalle_articuloC.php?cargar_tarjeta=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {
        if(response!='')
        {

           $('#txt_id_info').val(response[0].ID_PATRIMONIAL);
        	 $('.textarea').html(response[0].HTML_INFO);
        	 $('#txt_id_tarjeta').val(response[0].ID_PATRIMONIAL);

           $('#txt_codigonacional').val(response[0].CODNACIONAL);

           var uni = response[0].UNIDADDOCUMENTAL;
           if(uni=='H')
           {
            $('#rbl_H').prop('checked',true);
           }else if(uni=='A')
           {
            $('#rbl_A').prop('checked',true);
           }else if(uni=='G')
           {
            $('#rbl_G').prop('checked',true);
           }
           $('#txt_autor').val(response[0].AUTOR); 
           $('#txt_pais').val(response[0].PAIS); 
           $('#txt_siglo').val(response[0].SIGLO); 
           $('#txt_fecha').val(response[0].FECHA.date); 
           $('#txt_propietario').val(response[0].PROPIETARIO); 
           $('#txt_dni').val(response[0].NDI); 
           $('#txt_telefono').val(response[0].TELEFONO); 
           $('#txt_correo').val(response[0].EMAIL);  // => casa@cultura.com
           $('#txt_municipio').val(response[0].MUNICIPIO);  // => pichincha
           $('#txt_distrito').val(response[0].DISTRITO);  // => quito
           $('#txt_departamento').val(response[0].DEPARTAMENTO);  // => QUITO
           $('#txt_direccion').val(response[0].DIRECCION);  
           $('#txt_descripcion').val(response[0].DESCRIPCION); 
           $('#ddl_unidad_conservacion').val(response[0].CONSERVACION); 
           $('#txt_unidades').val(response[0].UNIDADES);  // => 1
           $('#txt_largo').val(response[0].LARGO);  // => 3CM
           $('#txt_ancho').val(response[0].ANCHO);  // => 25
           $('#txt_grosor').val(response[0].GROSOR);  // => 1CM
           $('#txt_metro_lineal').val(response[0].METROSLINEALES);  // => 
           $('#txt_escala').val(response[0].ESCALA);  // => 
           var inte = response[0].INTEGRIDAD
           if(inte=='C')
           {
            $('#rbl_completo').prop('checked',true);
           }else if(inte=='I')
           {
            $('#rbl_incompleto').prop('checked',true);
           }else if(inte=='F')
           {
            $('#rbl_fragmentado').prop('checked',true);
           }else if(inte=='U')
           {
            $('#rbl_unido').prop('checked',true);
           }else if(inte=='A')
           {
            $('#rbl_agregado').prop('checked',true);
           }else if(inte=='D')
           {
            $('#rbl_descosido').prop('checked',true);
           }else 
           {
            // $('#rbl_regular').prop('checked',true);
           }

           let estado = response[0].ESTADO  // => R
           if(estado=='B')
           {
            $('#rbl_bueno').prop('checked',true);
           }else if(estado=='R')
           {
            $('#rbl_regular').prop('checked',true);
           }else
           {
            $('#rbl_malo').prop('checked',true);
           }
           $('#txt_observacion_info').val(response[0].OBSERVACION);  // 
           $('#txt_valoracion').val(response[0].VALORACION);  // => ASDASDAS
        	 console.log(response);

        }   

        }
    })
	
}

  function movimientos(id)
  {
  	var table = '';
    $.ajax({
      data:  {id:id},
      url:   '../controlador/detalle_articuloC.php?movimientos=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {   
        $.each(response,function(i,item){
        	// console.log(item);
        	table+="<tr><td>"+item.ob+"</td><td>"+item.fe+"</td><td>"+item.responsable+"</td></tr>"
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
        'bajas':'false',
        'terceros':'false',
        'patrimoniales':'true',
    };
    // console.log(parametros);
    var id =$('#txt_id').val();
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/detalle_articuloC.php?guardarArticulo_patrimonial=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) { 
        if(response>0)
        {
          Swal.fire(
            '',
            'Operacion realizada con exito.',
            'success'
          ).then(function(){
            location.href = 'patrimoniales.php?id='+response+'&fil1=&fil2=';
          })
        }else if(response==-2)
        {
          Swal.fire(
            '',
            'Asset ya registrado.',
            'error'
          )

        }
        else if(response==-3)
        {
          Swal.fire(
            '',
            'Tag antiguo ya registrado.',
            'error'
          )

        }
        else
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
           $('#txt_unidad').val(response[0].UNIDAD_ORG); 
           $('#id').val(response[0].ID_PERSON); 
      }
    });
  }

  function guardar_info()
  {
    var parametros = $('#form_informativo').serialize(); 
    $.ajax({
        data:  parametros,
        url:   '../controlador/detalle_articuloC.php?add_info=true',
        type:  'post',
        dataType: 'json',
          success:  function (response) {
          if(response==1)
          {
            Swal.fire('Informacion guardada','','success');
            var art = '<?php echo $id;?>';
            if(art!='')
            {
              cargar_tarjeta(art);
            }

          }   

          }
      })
  }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <?php if($_GET['fil1']=='null--null' && $_GET['fil1']=='null--null'){   ?>
          <a class="btn btn-default btn-sm" href="../vista/lista_patrimoniales.php"><i class="fa fa-caret-left"></i>  Regresar</a>
        <?php }else{ ?>
          <a class="btn btn-default" href="../vista/lista_patrimoniales.php?fil1=<?php echo $_GET['fil1']?>&fil2=<?php echo $_GET['fil2']?>"> Regresar</a><div id="na">
            
          </div>

        <?php } ?>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detalle de Patrimonial</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
         <nav>
           <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Articulo</a>             
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-custodio" role="tab" aria-selected="false">Custorio</a>
               <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-info" role="tab" aria-selected="false">Informacion</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Tarjeta informativa</a>
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
                        <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" id="file_img" name="file_img">
                        <input type="hidden" name="txt_nom_img" id="txt_nom_img">
                        <input type="hidden" name="txt_idA_img" id="txt_idA_img">
                      </div>
                      <button type="button" class="btn btn-primary btn-sm" style="width: 100%" id="subir_imagen"> Subir Imagen</button>
                    </form>    

                    <?php
                      if(isset($_GET['id']))
                      {
                      $PNG_TEMP_DIR = '../TEMP/';
                      if (!file_exists($PNG_TEMP_DIR))
                      {
                          mkdir($PNG_TEMP_DIR);
                      }
                      $matrixPointSize = 5;
                      $errorCorrectionLevel = 'M';

                      $url = str_replace('patrimoniales.php','detalle_patrimonial.php', $_SERVER['REQUEST_URI']);

                      $filename = $PNG_TEMP_DIR.'QRCODE_'.$_GET['id'].'.png';
                      QRcode::png($_SERVER['HTTP_HOST'].$url, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

                        echo '<img  id="qr_'.$_GET['id'].'" name="qr_'.$_GET['id'].'" src="'.$PNG_TEMP_DIR.basename($filename).'" /><hr/>
                        <button type="button" class="btn btn-primary btn-sm" style="width: 100%" id="imprimir_qr"> Imprimir QR</button>';
                      }  
                    ?>
                    
                  </div>
                  <div class="col-sm-9">              
                     <input type="hidden" name="" id="txt_id">
                     <input type="hidden" name="" id="txt_id_A">
                     <div class="row" style="display:none;">
                       <div class="col-sm-3">
                        <label><input type="radio" id="txt_bajas" name="rbl_op"> Bajas</label>
                       </div>
                        <div class="col-sm-3">
                        <label><input type="radio" id="txt_patrimonial" name="rbl_op" checked> Patrimonial</label>
                       </div>
                        <div class="col-sm-3">
                        <label><input type="radio" id="txt_tercero" name="rbl_op"> Tercero</label>
                       </div>
                       <div class="col-sm-3">
                        <label><input type="radio" id="txt_ninguno" name="rbl_op" > Ninguno</label>
                       </div>
                     </div>
                    <div class="row">
                      <div class="col-sm-12" style="display:none;">
                        <b>Companycode</b><br>
                        <input type="text" class="form-control form-control-sm" name="" id="txt_company">
                      </div>  
                      <div class="col-sm-6">
                        <b><i class="text-danger">*</i>Descripcion</b><br>
                        <input type="text" class="form-control form-control-sm" name="" id="txt_description">
                      </div>  
                      <div class="col-sm-6">
                            <b><i class="text-danger">*</i>Custodio</b><br>
                            <select class="form-control form-control-sm" id="ddl_custodio">
                              <option>Seleccione Custodio</option>
                            </select>
                          </div>                     
                    </div>
              
                    <div class="row">
                          <div class="col-sm-6">
                           <!--  <b>Custodio</b><br>
                            <select class="form-control form-control-sm" id="ddl_custodio">
                              <option>Seleccione Custodio</option>
                            </select> -->
                            
                             <b>Descripcion 2</b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_description2">
                          </div>
                          <div class="col-sm-6">
                              <b><i class="text-danger">*</i>Localizacion / Emplazamiento</b><br>
                            <select class="form-control form-control-sm" id="ddl_localizacion">
                              <option>Seleccione Custodio</option>
                            </select>
                          </div>                       
                     </div>
                     <div class="row">
                         <div class="col-sm-4" style="display: none;">
                           <b>assetsupno </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_assetsupno">
                         </div>
                         <div class="col-sm-4">
                           <b><i class="text-danger">*</i>asset </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_asset">
                         </div>
                         <div class="col-sm-4">
                             <b>tag RFID </b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_rfid">
                           </div>
                           <div class="col-sm-4">
                             <b><i class="text-danger">*</i>tag antiguo </b><br>
                             <input type="text" class="form-control form-control-sm" name="" id="txt_tag_anti">
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
                           <input type="date" class="form-control form-control-sm" name="" id="txt_compra">
                         </div>                       
                     </div>
                     <div class="row">
                         <div class="col-sm-3">
                             <b><i class="text-danger">*</i>Marca</b><br>
                             <select class="form-control form-control-sm" id="ddl_marca">
                               <option>Selecciones</option>
                             </select>
                         </div>
                         <div class="col-sm-3">
                            <b><i class="text-danger">*</i>Estado</b> <br>
                            <select class="form-control form-control-sm input-sm" id="ddl_estado">
                              <option>Selecciones</option>
                            </select>
                         </div>
                         <div class="col-sm-3">
                           <b><i class="text-danger">*</i>Genero</b> <br>
                           <select class="form-control form-control-sm" id="ddl_genero">
                             <option>Selecciones</option>
                           </select>
                         </div>  
                         <div class="col-sm-3">
                            <b><i class="text-danger">*</i>Color </b><br>
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
                     </div>
                     <div class="row">
                      <div class="col-sm-3">
                           <b>Cantidad </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_cant">
                         </div>  
                         <div class="col-sm-3">
                         <b>Unidad medida  </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_unidad">
                         </div>
                          <div class="col-sm-3">
                         <b>Act. fijo original </b><br>
                         <input type="text" class="form-control form-control-sm" name="" id="txt_acti">
                         </div>
                         <div class="col-sm-3">
                           <b>Fecha de inventario </b><br>
                           <input type="date" class="form-control form-control-sm" name="" id="txt_fecha">
                         </div>                       
                     </div>
                     <div class="row">
                      <div class="col-sm-3">
                           <b>Valor actual </b><br>
                           <input type="text" class="form-control form-control-sm" name="" id="txt_valor">
                         </div>
                         <div class="col-sm-9">
                            <b><i class="text-danger">*</i>Proyecto </b><br>
                            <select class="form-control form-control-sm" id="ddl_proyecto">
                              <option>seleccione</option>
                            </select>
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

                 <h3>Tarjeta Informativa</h3>
             <div class="row">
             	<div class="col-sm-12 text-right">             		
	             	<button id="edit" class="btn btn-primary btn-sm" onclick="Editar()" type="button">Editar</button>
					<button id="save" class="btn btn-primary btn-sm" onclick="Guardar()" type="button">Guardar</button>
             	</div>             	
             </div>
              <div class="row">
	            <div class="card-body pad">
	            	<input type="hidden" name="txt_id_tarjeta" id="txt_id_tarjeta">
	              <div class="mb-3 textarea">
	              	<p>Edite tarjeta informativa<p>
	              </div>
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
                   
              </div>
            </div>
             <div class="tab-pane fade" id="nav-info" role="tabpanel">

              <form id="form_informativo">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <button type="button" class="btn btn-primary btn-sm" onclick="guardar_info()"><i class="fa fa-save"></i>Guardar</button>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <i class="fa fa-info-circle" title="Es el código de inventario asignado por cualquier ente regulador como banco central, casa de la cultura o ministerio de cultura y patrimonio" data-toggle="tooltip"></i>
                  <b> Codigo Nacional</b>                  
                  <input type="hidden" name="txt_id_info" id="txt_id_info" class="form-control form-control-sm">
                  <input type="hidden" name="txt_id" id="txt_id" class="form-control form-control-sm" value="<?php echo $id;?>">
                  <input type="" name="txt_codigonacional" id="txt_codigonacional" class="form-control form-control-sm">
                </div>
                 <div class="col-sm-9">
                  <b>Grupo</b><br>
                  <label class="form-check-label"><input type="radio" name="rbl_grupo" id="rbl_H" value="H" checked>Documento histórico</label>
                  <label class="form-check-label"><input type="radio" name="rbl_grupo" id="rbl_A" value="A">Archivo administrativo</label>
                  <label class="form-check-label"><input type="radio" name="rbl_grupo" id="rbl_G" value="G">Gráfico o Cartográfico</label>
                </div>   
               <!--  <div class="col-sm-3">
                  <b>Sub Grupo</b>
                  <select class="form-control form-control-sm" id="txt_grupo" name="txt_grupo">
                    <option value="">Seleccione</option>
                    <option value="">como acta</option>
                    <option value="">oficio</option>
                    <option value="">acuerdo</option>
                    <option value="">carta</option>
                    <option value="">expediente</option>
                    <option value="">proceso</option>
                    <option value="">proyecto</option>
                  </select>
                </div>          -->                                
                   
              </div>
              <div class="row">     
                <div class="col-sm-4">
                  <b>Autor</b>
                  <input type="" name="txt_autor" id="txt_autor" class="form-control form-control-sm">                  
                </div>      
                 <div class="col-sm-3">
                  <b>Pais de origen</b> 
                  <input type="" name="txt_pais" id="txt_pais" class="form-control form-control-sm">                  
                </div> 
                <div class="col-sm-2">
                  <b>siglos </b>
                  <input type="" name="txt_siglo" id="txt_siglo" class="form-control form-control-sm" placeholder="XX">    
                </div>
                <div class="col-sm-2">
                  <b>Fecha</b> 
                  <input type="date" name="txt_fecha" id="txt_fecha" class="form-control form-control-sm">                  
                </div> 
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <b>Propietario</b> 
                  <input type="" name="txt_propietario" id="txt_propietario" class="form-control form-control-sm">                  
                </div>
                <div class="col-sm-3">
                  <b>N.documento de iden.</b>
                  <input type="" name="txt_dni" id="txt_dni" class="form-control form-control-sm">                  
                </div>  
                <div class="col-sm-2">
                  <b>Teléfono</b>
                  <input type="" name="txt_telefono" id="txt_telefono" class="form-control form-control-sm">                  
                </div>                                    
                <div class="col-sm-3">
                  <b>Correo electrónico</b>
                  <input type="" name="txt_correo" id="txt_correo" class="form-control form-control-sm">                  
                </div>  
                <div class="col-sm-3">
                  <b>Municipio</b>
                  <input type="" name="txt_municipio" id="txt_municipio" class="form-control form-control-sm">                  
                </div>  
                <div class="col-sm-3">
                  <b>Distrito</b>
                  <input type="" name="txt_distrito" id="txt_distrito" class="form-control form-control-sm">                  
                </div>  
                <div class="col-sm-3">
                  <b>Departamento</b>
                  <input type="" name="txt_departamento" id="txt_departamento" class="form-control form-control-sm">                  
                </div> 
              </div>
              <div class="row">
                 <div class="col-sm-6">
                  <b>Dirección </b>
                  <input type="" name="txt_direccion" id="txt_direccion" class="form-control form-control-sm">                  
                </div>  
                <div class="col-sm-6">
                 <b> Descripcion </b>                
                  <input type="" name="txt_descripcion" id="txt_descripcion" class="form-control form-control-sm">    
                </div>
                <div class="col-sm-4">
                  <b>Unidad de conservacion</b> <br><br>
                  <div class="input-group">
                   <select class="form-control form-control-sm" id="ddl_unidad_conservacion" name="ddl_unidad_conservacion">
                    <option value="">Seleccione</option>
                    <option value="caja">CAJA</option>
                    <option value="tomo">TOMO</option>
                    <option value="carp">CARPETA</option>
                    <option value="lega">LEGADO</option>
                  </select>
                    <button class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>                    
                  </div>         
                </div>
                <div class="col-sm-8">
                  <!-- trabaja con tipo de documento  -->
                   <b><i class="fa fa-info-circle" title="Si se trata de piezas individuales se discriminan las medidas (alto, ancho, grosor) y la unidad. Si son unidades de conservación se contabilizan los metros lineales que ocupan en el estante. Si se trata de documentos individuales manuscritos consignar las medidas (alto, ancho) y la unidad. Cuando se trate de material cartográfi co se debe registrar la escala"></i> Dimensiones</b>
                   <div class="row">
                    <div class="col-sm-2">
                      Unidades
                      <input type="" name="txt_unidades" id="txt_unidades" class="form-control form-control-sm">  
                     </div>
                     <div class="col-sm-2">
                      largo
                      <input type="" name="txt_largo" id="txt_largo" class="form-control form-control-sm">  
                     </div>
                     <div class="col-sm-2">
                      Ancho
                      <input type="" name="txt_ancho" id="txt_ancho" class="form-control form-control-sm">                       
                     </div>
                     <div class="col-sm-2">
                      groso
                      <input type="" name="txt_grosor" id="txt_grosor" class="form-control form-control-sm">                       
                     </div>
                     <div class="col-sm-2">
                      metros lineales 
                      <input type="" name="txt_metro_lineal" id="txt_metro_lineal" class="form-control form-control-sm">                       
                     </div>
                     <div class="col-sm-2">
                      Escala
                      <input type="" name="txt_escala" id="txt_escala" class="form-control form-control-sm">
                     </div>
                   </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">                  
                <b>Estado de integridad</b> <br>
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-check-label" title="El bien tiene todas sus partes originales."><input type="radio" name="rbl_integridad" id="rbl_completo" value="C" checked>Completo</label><br>
                      <label class="form-check-label" title="Alguna de las partes y/o elementos originales no existe."><input type="radio" name="rbl_integridad" id="rbl_incompleto" value="I">Incompleto</label><br>
                      <label class="form-check-label" title="El bien se encuentra roto en dos o más pedazos."><input type="radio" name="rbl_integridad" id="rbl_fragmentado" value="F">Fragmentado</label>                      
                    </div>
                    <div class="col-sm-6">
                      <label class="form-check-label" title="El bien ha sido reconstruido con sus partes originales."><input type="radio" name="rbl_integridad" id="rbl_unido" value="U">Unido</label> <br>
                      <label class="form-check-label" title="Al bien le han sido colocados elementos y/o materiales no originales."><input type="radio" name="rbl_integridad" id="rbl_agregado" value="A" class="">Agregado</label><br>
                      <label class="form-check-label" title="Los hilos que unen las hojas o folios se han reventado o han desaparecido"><input type="radio" name="rbl_integridad" id="rbl_descosido" value="D">Descosido</label>
                    </div>                    
                  </div>                 
                </div>
                <div class="col-sm-3">
                  <b>Estado deconservacion</b> <br>
                  <label class="form-check-label" title="Los materiales y los elementos que conforman o hacen parte del objeto, se encuentran en buen estado."><input type="radio" name="rbl_estado" id="rbl_bueno" value="B" checked>Bueno</label><br>
                  <label class="form-check-label" title="Se observan indicios de deterioro."><input type="radio" name="rbl_estado" id="rbl_regular" value="R">Regular</label><br>
                  <label class="form-check-label" title="Los materiales y/o elementos están bastante deteriorados"><input type="radio" name="rbl_estado" id="rbl_malo" value="M">Malo</label>
                  
                </div>
                 <div class="col-sm-5">
                  <b>Observaciones</b> 
                  <textarea class="form-control-sm form-control" style="resize:none;" rows="3" name="txt_observacion_info" id="txt_observacion_info" ></textarea>
                </div>
              </div>               
              <div class="row">    
                <div class="col-sm-12">
                  <b>Valoración y Significado Cultural del Bien</b> 
                      <textarea class="form-control-sm form-control" style="resize:none;" rows="3" name="txt_valoracion" id="txt_valoracion" ></textarea>

                </div>

              </div>
              <br>


             </form>
            </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
  // $(function () {
  //   // Summernote
  //   $('.textarea').summernote({
  //   	height: 500,
  //   })
  // })

function Editar () {
  $('.textarea').summernote({focus: true,height:500});
};

function Guardar() {
  var markup = $('.textarea').summernote('code');
  var id_t = $('#txt_id_tarjeta').val();
  var id = '<?php echo $id; ?>';
   var parametros = 
    {
      'articulo':id,
      'tarjeta':markup,
      'id_tarjeta':id_t,
    }
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/detalle_articuloC.php?tarjeta_guardar=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {
        	$('.textarea').summernote('destroy');
        	cargar_tarjeta(id);
      }
    });

};


</script>

        <?php include('./footer.php'); ?>
     