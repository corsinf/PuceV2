<?php include('./header.php'); ?>
<script type="text/javascript">
  $(document).ready(function() {
    lista_articulos();    
    estado();
  });


  function historial(id)
  { 
    var parametros=
    {
      'id':id,
    };
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/contratoC.php?historial=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {    
        // console.log(response);   
        $('#tbl_historial').html(response.tbl);
        if(response.pendiente ==1)
        {
          $('#btn_add_siniestro').css('display','none');
        }else
        {
          $('#btn_add_siniestro').css('display','initial');
        }        
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

  function cerrar_siniestro(id)
  { 
    var parametros = 
    {
      'id':id,
    }
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/contratoC.php?detalle_siniestro=true',
      type:  'post',
      dataType: 'json',
        success:  function (response) {    
            $('#txt_encargado').val(response[0].encargado);
            $('#txt_fecha_reg').val(formatoDate(response[0].fecha.date));
            $('#txt_fecha_sini').val(formatoDate(response[0].fecha_siniestro.date));
            $('#ddl_estado').append($('<option>',{value: response[0].estado, text: response[0].DESCRIPCION,selected: true }));;
            $('#txt_detalle_siniestro').val(response[0].detalle);
            $('#txt_alertado').val(formatoDate(response[0].fecha_alertado.date));
            $('#txt_respuesta').val(response[0].respuesta);
            $('#txt_evaluacion').val(response[0].evaluacion);
            $('#rbl_estado_proceso_'+response[0].estado_proceso).prop('checked',true);
            $('#txt_id_siniestro').val(response[0].id_deterioro);
            mostrar();
         
      }
    });
  }

  
   function lista_articulos()
   {
      $('#ddl_articulos').select2({
        placeholder: 'Seleccione un articulo',
        width:'90%',
        ajax: {
          url:   '../controlador/contratoC.php?lista_articulos=true',
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

  function cargar_datos_seguro(id)
  {
    // console.log(id);false;
    var parametros = 
    {
      'id':id,
    }
        $.ajax({
          data:  {parametros:parametros},
          url:   '../controlador/contratoC.php?cargar_datos_seguro_art=true',
          type:  'post',
          dataType: 'json',
          /*beforeSend: function () {   
               var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
             $('#tabla_').html(spiner);
          },*/
            success:  function (response) {
              console.log(response)
              if (response.length>0)
               {                
                $('#div_sin_datos').css('display','none');
                $('#div_datos').css('display','flex');
                data = response[0];
                $("#lbl_proveedor").text(data.nombre);           
                $("#lbl_seguro").text(data.desde.date);        
                $("#lbl_fin_seguro").text(data.desde.date);            
                $("#lbl_cobertura").text(data.nombre_riesgo);           
                $("#lbl_email").text(data.email_asesor);                 
                $("#lbl_telefono").text(data.telefono_asesor);          
                $("#lbl_asesor").text(data.asesor);           
                $("#lbl_valor_pagar").text(data.suma_asegurada);
                // $("#lbl_asegurado").val(data.);
                 // console.log(response);
               }else
               {
                 $('#div_sin_datos').css('display','flex');
                $('#div_datos').css('display','none');
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
            <h1 class="m-0 text-dark">Siniestros</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <b>Articulo</b>
            <div class="input-group input-group-sm">
                  <select class="form-control form-control-sm" name="ddl_articulos" id="ddl_articulos" onchange="cargar_datos_seguro(this.value);historial(this.value)">
                    <option value="">Seleccione articulo</option>                   
                  </select>
                  <!-- <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" title="Nuevo Siniestro" onclick="nuevo_siniestro()"><i class="fa fa-circule-arrow-down"></i> Agregar</button>
                  </span> -->
              </div>              
          </div>
        </div>
       <!--  <div class="row">
           <div class="col-sm-12">
          </div>
        </div> -->
        <div class="row" id="div_sin_datos">
            <br>
          <div class="col-sm-12 text-center">
           <b>SIN DATOS DE SEGURO</b>            
          </div>
        </div>
        <div class="row" id="div_datos" style="display:none">
          <div class="col-sm-12 text-center">
            <br>
            <h3>Datos de Seguro</h3>
            <hr>
          </div>
          <div class="col-sm-6">
            <div class="row">
              
            
                <div class="col-sm-12">
                  <b>Proveedor de Seguro</b><br>
                  <p id="lbl_proveedor" name="lbl_proveedor"></p>
                </div>          

                <div class="col-sm-6">
                  <b>Fecha de seguro</b><br>
                  <p id="lbl_seguro" name="lbl_seguro"></p>
                </div>          

                <div class="col-sm-6">
                 <b>Fecha fin de seguro</b><br>
                 <p id="lbl_fin_seguro" name="lbl_fin_seguro"></p>
                </div>  
                <div class="col-sm-12">
                 <b>Asesor</b><br>
                 <p id="lbl_asesor" name="lbl_asesor"></p>
                </div>  
                <div class="col-sm-6">
                 <b>Telefono</b><br>
                 <p id="lbl_telefono" name="lbl_telefono"></p>
                </div>  
                <div class="col-sm-6">
                 <b>Email</b><br>
                 <p id="lbl_email" name="lbl_email"></p>
                </div>          

                <div class="col-sm-6">
                 <b> Cobertura</b><br>
                 <p id="lbl_cobertura" name="lbl_cobertura"></p>
                </div>          

                <div class="col-sm-6">
                  <b>Siniestro</b><br>
                  <p id="lbl_siniestro" name="lbl_siniestro"></p>
                </div>          

                <div class="col-sm-6">
                  <b>valor a pagar</b><br>
                  <p id="lbl_valor_pagar" name="lbl_valor_pagar"></p>
                </div>          

                <div class="col-sm-6">
                  <b>valor asegurado</b><br>
                  <p id="lbl_asegurado" name="lbl_asegurado"></p>
                </div>     
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-6">
                <b>Historial de siniestro</b>
              </div>
               <div class="col-sm-6 text-right">
                  <button class="btn btn-primary btn-sm" id="btn_add_siniestro" name="btn_add_siniestro" onclick="mostrar()">Agregar Siniestro</button>
              </div>
              <div class="col-sm-12">
                <table class="table table-hover">
                  <thead>
                    <th></th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Solucion</th>
                  </thead>
                  <tbody id="tbl_historial">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <div class="row">         
          <div class="col-sm-12" style="display:none" id="div_siniestro"><br>
            <div class="row">
               <div class="col-sm-6">
                <h3>Datos de siniestro</h3>
              </div>
              <div class="col-sm-6 text-right">
                <button class="btn btn-default" onclick="cancelar()">Cancelar</button>
                <button class="btn btn-primary" onclick="guardar()">Guardar</button>
              </div>            
            </div>
            <hr>
            <div class="row">
               <input type="hidden" name="txt_id_siniestro" id="txt_id_siniestro" class="form-control form-control-sm">
              <div class="col-sm-6">
                <b>Encargado</b>
                <input type="text" name="txt_encargado" id="txt_encargado" class="form-control form-control-sm">
              </div>
              <div class="col-sm-3">
                <b>Fecha de siniestro</b>
                <input type="date" name="txt_fecha_sini" id="txt_fecha_sini" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
              </div>
              <div class="col-sm-3">
                <b>Fecha de registro</b>
                <input type="date" name="txt_fecha_reg" id="txt_fecha_reg" class="form-control form-control-sm" readonly value="<?php echo date('Y-m-d');?>">
              </div>
              <div class="col-sm-3">
                <b>Estado Articulo</b>
                <select class="form-control form-control-sm" id="ddl_estado" name="ddl_estado">
                  <option value="">Seleccione</option>
                </select>
              </div>
              <div class="col-sm-9">
                <b>Detalle de siniestro</b>
                <textarea class="form-control-sm form-control" style="resize:none;" rows="3" id="txt_detalle_siniestro" name="txt_detalle_siniestro"></textarea>
              </div>
              <div class="col-sm-2">
                <b>Asegurador Alertado</b>
                <input type="date" name="txt_alertado" id="txt_alertado" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
              </div>
               <div class="col-sm-4">
                <b>Respuesta</b>
                <textarea class="form-control-sm form-control" style="resize:none;" rows="3" id="txt_respuesta" name="txt_respuesta"></textarea>
              </div>
               <div class="col-sm-4">
                <b>Respuesta de evaluacion</b>
                <textarea class="form-control-sm form-control" style="resize:none;" rows="3" id="txt_evaluacion" name="txt_evaluacion"></textarea>
              </div>
              <div class="col-sm-2"><br>
                <label><input type="radio" name="rbl_estado_proceso" id="rbl_estado_proceso_0" checked value="0">Proceso pendiente</label>
                <label><input type="radio" name="rbl_estado_proceso" id="rbl_estado_proceso_1" value="1">Cerrar proceso</label>
              </div>
            </div>            
          </div>          
        </div>
        <!-- <div class="row">
          <div class="col-sm-12 text-center">
            <p>No se a registrado Ningun siniestro con este articulo</p><br>
          </div>              
        </div> -->
        <script type="text/javascript">
          function mostrar()
          {
            $('#div_siniestro').css('display','initial');
            $('#div_datos').css('display','none');
          }
          function cancelar()
          {
            $('#div_siniestro').css('display','none');
            $('#div_datos').css('display','flex');
          }

          function guardar()
          {
            var  enca = $('#txt_encargado').val();
            var  fecha_sini = $('#txt_fecha_sini').val();
            var  fecha_reg = $('#txt_fecha_reg').val();
            var  estado = $('#ddl_estado').val();
            var detalle_sini = $('#txt_detalle_siniestro').val();
            var  fecha_ale = $('#txt_alertado').val();
            var  respueta = $('#txt_respuesta').val();
            var  evaluacion = $('#txt_evaluacion').val();
            var  proceso = $('input[name="rbl_estado_proceso"]:checked').val();
            var articulo = $('#ddl_articulos').val();
            var id = $('#txt_id_siniestro').val();
            if(articulo=='')
            {
              Swal.fire('','No se a seleccionado una articulo','info');
              return false;
            }

            var parametros = 
            {
              'articulo':articulo,
              'encargado':enca,
              'fecha_si':fecha_sini,
              'fecha_re':fecha_reg,
              'estado':estado,
              'detalle':detalle_sini, 
              'fecha_al':fecha_ale,
              'respuesta':respueta, 
              'evaluacion':evaluacion,
              'proceso':proceso,
              'id':id,
            }
            $.ajax({
              data:  {parametros:parametros},
              url:   '../controlador/contratoC.php?guardar_datos_siniestro=true',
              type:  'post',
              dataType: 'json',
              /*beforeSend: function () {   
                   var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
                 $('#tabla_').html(spiner);
              },*/
                success:  function (response) {
                  console.log(response)
                  if (response==1)
                   {                
                     historial(articulo);
                     Swal.fire('','Guardado','success');
                      $('#txt_encargado').val('');
                      $('#txt_fecha_sini').val('');
                      $('#txt_fecha_reg').val('');
                      $('#ddl_estado').val('');
                      $('#txt_detalle_siniestro').val('');
                      $('#txt_alertado').val('');
                      $('#txt_respuesta').val('');
                      $('#txt_evaluacion').val('');
                      $('#rbl_estado_proceso_0').prop('checked',true);
                      $('#txt_id_siniestro').val('');
                      cancelar();

                   }
              }
            });
          }
        </script>

                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
