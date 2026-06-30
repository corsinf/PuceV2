<?php include('./header.php'); ?>

    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <script src="../js/filesaver.js" type="text/javascript"></script>
    <script src="../js/html2canvas.js" type="text/javascript"></script> 
    <script type="text/javascript">
      $(function() { 
          $("#crearimagen").click(function() { 
              html2canvas($("#codes"), { 
                allowTaint: false,
                  onrendered: function(canvas) {
                      theCanvas = canvas;
                      document.body.appendChild(canvas);

                      
                      canvas.toBlob(function(blob) {   
                        saveAs(blob, "Dashboard.png"); 
                      });
                      
                  }
              });
          });
      });
    </script>
<script type="text/javascript">
  $( document ).ready(function() {
    autocmpletar();
    autocmpletar_l();
    lista_articulos();
    llenar_formatos();

});


function g(blob)
{
  var parametros = {
                          'blod':blob,
                          'nom':$('#txt_id_art').val(),
                          }
                         $.ajax({
                          data:  {parametros:parametros},
                          url:   '../controlador/formato_tagsC.php?guardar_camvas=true',
                          type:  'post',
                          dataType: 'json',
                          success:  function (response) {   
                           // console.log(response);   
                           $('#ddl_formato').html(lineas);  
                           }
                          });

}

  function llenar_formatos(id='')
  {
     lineas = '<option value="">Seleccione formato</option>';
    $.ajax({
      data:  {id:id},
      url:   '../controlador/formato_tagsC.php?formato=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {    
        // console.log(response);   
        $.each(response, function(i, item){
          lineas+= '<option value="'+item.id_formato_eti+'">'+item.nombre_etiqueta+'</option>';
          // console.log(item);
       
        });       
        $('#ddl_formato').html(lineas);        
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
  function lista_articulos()
  {
     var query = $('#txt_buscar').val();
     var parametros = 
     {
      'query':$('#txt_buscar').val(),
      'localizacion':  $('#ddl_localizacion').val(),
      'custodio': $('#ddl_custodio').val(),
      'pag':$('#txt_pag').val(),
     }
     var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?lista=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {    
        console.log(response);   
        $.each(response.datos, function(i, item){
          lineas+= '<tr><td>'+item.id+'</td><td><a href="detalle_articulo.php?id='+item.id+'">'+item.tag+'</a></td><td>'+item.nom+'</td><td>'+item.modelo+'</td><td>'+item.serie+'</td><td>'+item.localizacion+'</td><td>'+item.custodio+'</td><td>'+item.fecha_in+'</td><td><button class="btn btn-default" onclick="tag_im(\''+item.tag+'\')"><li class="fa fa-tag"></li></button></td></tr>';
          // console.log(item);
       
        });       
        $('#tbl_datos').html(lineas);        
      }
    });
  }

   function tag_im($id)
   {
    $('#txt_buscar').val($id);
    imprimir_tags_masivo();
   }

    function imprimir_tags_masivo()
  {
     var query = $('#txt_buscar').val();
     var parametros = 
     {
      'query':$('#txt_buscar').val(),
      'localizacion':  $('#ddl_localizacion').val(),
      'custodio': $('#ddl_custodio').val(),
      'pag':$('#txt_pag').val(),
     }
     var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?lista_imprimir=true',
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
          Swal.fire( '',
                  'Etiquetas generadas Dirijase a Zebra designer.',
                  'info');
        } else if(response==2)
        {
         Swal.fire({
            title: 'Existen etiquetas generadas para impresion!',
            text: "desea generar etiquetas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar y continuar!'
          }).then((result) => {
            if (result.value) {
              vaciar_tags();
            }
          })

        }
      }
       
    });
  }

   function imprimir_tags_masivo_()
  {
     var query = $('#txt_buscar').val();
     var parametros = 
     {
      'numero':$('#txt_num_eti').val(),
     }
     var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?lista_imprimir_=true',
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
          Swal.fire( '',
                  'Etiquetas generadas Dirijase a Zebra designer.',
                  'info');
          $('#myModal_tag').modal('hide');
        } else if(response==2)
        {
         Swal.fire({
            title: 'Existen etiquetas generadas para impresion!',
            text: "desea generar etiquetas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar y continuar!'
          }).then((result) => {
            if (result.value) {
              vaciar_tags_();
            }
          })

        }
      }
       
    });
  }

   function imprimir_tags_bloque()
  {
     var parametros = 
     {
      'tags':$('#txt_tag_assets').val(),
     }
     var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?imprimir_tags_bloque=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {    
        // console.log(response);  
        if(response.resp==1)
        {
          title = '';
          msj = 'Etiquetas generadas Dirijase a Zebra designer.'
          icono = 'success';
          if(response.msj!='')
          {
            title = 'Una o varias Etiquetas no pudieron generarse';
            msj = response.msj;
            icono = 'info';
          }

          Swal.fire({
            title: title,
            text:msj,
            icon: icono,
            allowOutsideClick: false,
          })

          $('#myModal_tag').modal('hide');

        } else if(response.resp==2)
        {
         Swal.fire({
            title: 'Existen etiquetas generadas para impresion!',
            text: "desea generar etiquetas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar y continuar!'
          }).then((result) => {
            if (result.value) {
             vaciar_tags2()
            }
          })

        }
      }
       
    });
  }

  function reimprimir_tags_bloque()
  {

     var parametros = 
     {
      'tags':$('#txt_retag_assets').val(),
     }
     var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?reimprimir_tags_bloque=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {    
        // console.log(response);  
        if(response.resp==1)
        {
          no_reg = '';
          if(response.msj!='')
          {
            no_reg = 'Asset no encontrados:'+response.msj;
          }
          Swal.fire( 'Etiquetas generadas Dirijase a Zebra designer.',
                   no_reg,
                  'info');
          $('#myModal_tag').modal('hide');
        } else if(response.resp==2)
        {
         Swal.fire({
            title: 'Existen etiquetas generadas para impresion!',
            text: "desea generar etiquetas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar y continuar!'
          }).then((result) => {
            if (result.value) {
             vaciar_tags_all()
            }
          })

        }
      }
       
    });
  }

  function vaciar_tags()
  {
     $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?vaciar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
         imprimir_tags_masivo();
      }
   
      });

  }
    function vaciar_tags_()
  {
     $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?vaciar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
         imprimir_tags_masivo_();
      }
   
      });

  }

  function vaciar_tags2()
  {
     $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?vaciar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
         imprimir_tags_bloque();
      }
   
      });

  }

  function vaciar_tags_all()
  {
     $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?vaciar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
        if(response==1)
        {
          // Swal.fire( 'Etiquetas anteriores eliminadas','','info').then(function(){
            reimprimir_tags_bloque()
          // });
        }
      }
   
      });

  }

  function limpiar(ddl)
  {
    $('#'+ddl).val(null).trigger('change');
  }
  function redireccionar(id){
     window.location.href="detalle_articulo.php?id="+id;
} 

function generar_vista()
{
  id = $('#ddl_formato').val();
  if(id!="")
  {
   var parametros = {
    'id_formato':$('#ddl_formato').val(),
    'id_art':$('#txt_id_art').val(),
  }
  codigos ='';    
  $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/impresion_tagC.php?generarT=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {
          console.log(response);
          $.each(response[1].IMAGEN, function(i,item){
            console.log(item);
            codigos+=item.imagen;
          })
          $('#codes').html(codigos);
          
          modificar_canvas(response[2].DATOS,response[0]);
      }
    });
  }else
  {
    Swal.fire( '',
                  'Seleccione Un formato.',
                  'error');

  }

}

  function modificar_canvas(dimenciones,texto)
  {
    console.log(dimenciones);
    console.log(texto.texto);

    if ( $("#img_qr").length) {
         $('#img_qr').width(dimenciones.qr_w);
         $('#img_qr').height(dimenciones.qr_h);
         $('#img_qr').css('top',dimenciones.qr_y+'px');
         $('#img_qr').css('left',dimenciones.qr_x+'px');
     }
    if ( $("#img_br").length ) {
        $('#img_br').width(dimenciones.br_w);
        $('#img_br').height(dimenciones.br_h);
        $('#img_br').css('top',dimenciones.br_y+'px');
        $('#img_br').css('left',dimenciones.br_x+'px');
      }

    if($('#txt_alternativo')!='')
    {
      $("#lbl_alternativo").remove();
      var label = "<label id='lbl_alternativo' style='font-size:"+dimenciones.tamano_texto+"px; position:relative; left:"+dimenciones.texto_x+"px; top:"+dimenciones.texto_y+"px'>"+texto.texto+"</laber>";
      $('#codes').append(label);
    }
    
  }

  function abrir_impre()
{
   
  $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/impresion_tagC.php?abrir_impresora=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
         
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
            <h1 class="m-0 text-dark">Imprimir etiquetas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">

          <div class="row">
            <div class="col-sm-9">
              <!-- <a href="#" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" onclick="limpiar()"><li class="fa fa-plus"></li> Nuevo</a> -->
             <!-- <button class="btn btn-default btn-md" onclick="imprimir_tags_masivo()"><li class="fa fa-tags"></li> Imprimir para todos</button>-->
              <button class="btn btn-default btn-md" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal_tag"><li class="fa fa-tags"></li> Imprimir (N) Etiquetas</button>
               <button class="btn btn-default btn-md" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal_block"><li class="fa fa-tags"></li> Imprimir etiquetas en bloque</button>
                <button class="btn btn-default btn-md" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal_Reblock"><li class="fa fa-tags"></li> ReImprimir etiquetas en bloque</button>
            </div>
          </div>
          <br>
          <b>Filtros de busqueda</b>
            <div class="row">
              <input type="hidden" id="txt_pag" name="" value="0-25">
              <div class="col-sm-3">
                <input type="" name="" id="txt_buscar" onkeyup="lista_articulos()" class="form-control" placeholder="Buscar">
             </div>
              <div class="col-sm-4">
                <div class="input-group" style="width: 100%">
                   <select class="form-control input" id="ddl_custodio" onchange="lista_articulos()" style="width:80%"></select>
                   <button onclick="limpiar('ddl_custodio')" class="btn"><i class="fa fa-trash"></i></button> 
                </div>
                                                
              </div> 
               <div class="col-sm-4">
                <div class="input-group" style="width: 100%">
                  <select class="form-control input" id="ddl_localizacion" onchange="lista_articulos()" style="width:80%"></select>
                  <button onclick="limpiar('ddl_localizacion')" class="btn"><i class="fa fa-trash"></i></button>
                </div>                          
              </div>              
            </div>
          <div class="row text-right">
            <nav aria-label="Page navigation example">
              <ul class="pagination" id="pag">
                
              </ul>
            </nav>            
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>TAG SERIE</th>
                  <th>DESCRIPCION</th>
                  <th>MODELO</th>
                  <th>SERIE</th>
                  <th>LOCALIZACION</th>
                  <th>CUSTODIO</th>
                  <th>FECHA INV.</th>
                  <th>IMPRIMIR TAG</th>
                </tr>
              </thead>
              <tbody id="tbl_datos">               
              </tbody>
            </table>
          </div>
             </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


        <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="titulo">Generando etiqueta</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="txt_id_art">
        Formato de etiqueta
        <select class="form-control" id="ddl_formato" onchange="generar_vista()">
          <option>Seleccione un formato</option>
        </select>
        <b>vista previa<b>
          <div id="codes" style="border:1px solid #d3d3d3; height: 198px ; width: 397px"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="crearimagen">Guardar</button>
        <button type="button" class="btn btn-primary" id="abrir_imagen" onclick="RunFile()">abrir impresora</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal_tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="titulo">Numero de  etiqueta</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="txt_id_art">
        Ingrese nunero de etiquetas <br>
        <input type="number" name="txt_num_eti" id="txt_num_eti" class="form-control" value="1">      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="crearimagen"  onclick="imprimir_tags_masivo_()">Guardar</button>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="myModal_block" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="titulo">Etiquetas</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <b>Assets</b>
              <textarea class="form-control" rows="7" id="txt_tag_assets" name="txt_tag_assets" placeholder="Pegue Assets
0000001
0000002
0000003"></textarea>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary" id="crearimagen"  onclick="imprimir_tags_bloque()">Generar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                
            </div>
          </div>     
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModal_Reblock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="titulo">Reimprimir Etiquetas</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <b>Assets</b>
              <textarea class="form-control" rows="7" id="txt_retag_assets" name="txt_retag_assets" placeholder="Pegue Assets
0000001
0000002
0000003"></textarea>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary" id="crearimagen"  onclick="reimprimir_tags_bloque()">Generar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                
            </div>
          </div>     
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" language="javascript">
    function RunFile() {
    WshShell = new ActiveXObject("WScript.Shell");
    WshShell.Run("c:/windows/system32/notepad.exe", 1, false);
    }
</script>


        <?php include('./footer.php'); ?>
     