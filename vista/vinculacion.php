<?php include('header.php'); //print_r($_SESSION['INICIO']); ?>
  <!-- Content Wrapper. Contains page content -->

  <script type="text/javascript">
  $( document ).ready(function() {
   autocmpletar();
   autocmpletar_l();
   lista_desvinculado_cus()
   lista_desvinculado_loc()

   autocmpletar1();
   autocmpletar2();
   autocmpletar3();

   autocmpletar_1_loc()
   autocmpletar_2_loc()
   autocmpletar_3_loc()

  });


 function autocmpletar(){
      $('#ddl_custodio').select2({
        placeholder: 'Seleccione una custodio',
        width:'90%',
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

   function autocmpletar1(){
      $('#ddl_custodio_1').select2({
        placeholder: 'Seleccione una custodio',
        width:'94%',
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
   function autocmpletar2(){
      $('#ddl_custodio_2').select2({
        placeholder: 'Seleccione una custodio',
        width:'100%',
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
   function autocmpletar3(){
      $('#ddl_custodio_3').select2({
        placeholder: 'Seleccione una custodio',
        width:'100%',
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
        width:'90%',
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

  function autocmpletar_1_loc(){
      $('#ddl_localizacion_1').select2({
        placeholder: 'Seleccione una localizacion',
        width:'94%',
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
  function autocmpletar_2_loc(){
      $('#ddl_localizacion_2').select2({
        placeholder: 'Seleccione una localizacion',
        width:'100%',
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
  function autocmpletar_3_loc(){
      $('#ddl_localizacion_3').select2({
        placeholder: 'Seleccione una localizacion',
        width:'100%',
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
    if($('#ddl_custodio').val()=='' && $('#txt_query').val()!='' && $('#ddl_localizacion').val()=='')
    {
      $('#txt_pag').val('0-25');
    }
    var parametros = 
    {
      'custodio':$('#ddl_custodio').val(),
      'query':$('#txt_query').val(),
      'localizacion':$('#ddl_localizacion').val(),      
      'pag':$('#txt_pag').val(),
      'exacto':$('#rbl_exacto').prop('checked'),
      'asset':$('#rbl_aset').prop('checked'),
      'asset_org':$('#rbl_aset_ori').prop('checked'),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?lista_art=true',
         type:  'post',
         dataType: 'json',
         beforeSend: function () {   
              var spiner = '<tr class="text-center"><td colspan="5"><img src="../img/de_sistema/loader_puce.gif" width="100" height="100"></td></tr>';     
            $('#tbl_datos').html(spiner);
         },
           success:  function (response) {  
            // var res = response.length;
            if(response!='')
            {
              $('#tbl_datos').html(response);
            }else
            {              
              $('#tbl_datos').html('<tr><td colspan="4">No se encontraron articulos</td></tr>');
            }
          
          }
       });
     
  }

  function desvincular(id=false,tipo)
  {
    if($('#ddl_custodio').val()=='' && $('#txt_query').val()==''&& $('#ddl_localizacion').val()=='')
    {
      Swal.fire('Realize primero una busqueda','','info');
      return false;
    }

     Swal.fire({
        title: 'Esta apunto de desvincular estos articulos',
        text: "Una vez desvinculados estos articulos no tendras custodio o localizacion definidad",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {
        if (result.isConfirmed) {  
          ingresar_desvinculacion(id,tipo);                 
        }
      })

  }
  function ingresar_desvinculacion(id=false,tipo)
  {
    var parametros = 
    {
      'custodio':$('#ddl_custodio').val(),
      'query':$('#txt_query').val(),
      'localizacion':$('#ddl_localizacion').val(),
      'id':id,
      'tipo':tipo,
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?desvincular_art=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            // var res = response.length;
            if(response==1)
            {
              Swal.fire('Articulo desvinculado','','success');
              lista_desvinculado_cus();
              lista_desvinculado_loc();
            }else if(response.response==-2)
            {
              Swal.fire('No se puede desvincular',response.mensaje+'Por Tiene un seguro ligado','warning');
            }          
          }
       });
  }

  function lista_desvinculado_cus()
  {
    
    var parametros = 
    {
      'tipo':'C',
      'cus':$('#ddl_custodio_1').val(),
      'query':$('#txt_query1').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?lista_desvinculados=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            // var res = response.length;
            $('#tbl_datos_cus').html(response);        
          }
       });
  }
  function lista_desvinculado_loc()
  {
    
    var parametros = 
    {
      'tipo':'L',
      'loc':$('#ddl_localizacion_1').val(),
      'query':$('#txt_query1_loc').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?lista_desvinculados=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            // var res = response.length;            
            $('#tbl_datos_loc').html(response);       
          }
       });
  }


  function vincular(id,tipo)
  {
    $('#modal_vincular').modal('show');
    $('#txt_id_art_vin').val(id);
    if(tipo=='C')
    {
      $('#titulo').text('Nuevo custodio');
      $('#div_location').css('display','none');
      $('#div_custodio').css('display','block');
      $('#btn_vin_cus').css('display','block');
      $('#btn_vin_loc').css('display','none');
    }else
    {
      $('#titulo').text('Nueva localizacion');
      $('#div_location').css('display','block');
      $('#div_custodio').css('display','none');
      // $('#div_location').css('display','none');
      $('#btn_vin_cus').css('display','none');
      $('#btn_vin_loc').css('display','block');
    }
  }

  function guardar_vin_custodio()
  {
     var parametros = 
    {
      'id':$('#txt_id_art_vin').val(),
      'nuevo':$('#ddl_custodio_3').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?vincular_custodio=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            if(response==1)
            {
              lista_desvinculado_cus();
              $('#ddl_custodio_3').empty();
              Swal.fire('Vinculacion realizada','','success');

            }else
            {             
              Swal.fire('Algo extraño a pasado','','error');
            }
            $('#modal_vincular').modal('hide');         
          }
       });

  }

  function guardar_vin_custodio_todo()
  {
    if($('#ddl_custodio_2').val()=='')
    {
      Swal.fire('Seleccione nuevo custodio','','error');
      return false;
    }
     var parametros = 
    {
      'nuevo':$('#ddl_custodio_2').val(),
      'antiguo':$('#ddl_custodio_1').val(),
      'query':$('#txt_query1').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?vincular_custodio_todo=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            if(response==1)
            {
              lista_desvinculado_cus();
              $('#ddl_custodio_3').empty();
              Swal.fire('Vinculacion realizada','','success');

            }else
            {             
              Swal.fire('Algo extraño a pasado','','error');
            }
            $('#modal_vincular').modal('hide');         
          }
       });

  }

  function guardar_vin_loc()
  {
      var parametros = 
    {
      'id':$('#txt_id_art_vin').val(),
      'nuevo':$('#ddl_localizacion_3').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?vincular_localizacion=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) { 
           if(response==1)
           {
             lista_desvinculado_loc();
             $('#ddl_localizacion_3').empty();
             Swal.fire('Vinculacion realizada','','success');
           } else
           {            
              Swal.fire('Algo extraño a pasado','','error');
           }
           $('#modal_vincular').modal('hide'); 
          }
       });
  }

   function guardar_vin_loc_todo()
  {
    if($('#ddl_localizacion_2').val()=='')
    {
      Swal.fire('Seleccione nueva localizacion','','error');
      return false;
    }
     var parametros = 
    {
      'nuevo':$('#ddl_localizacion_2').val(),
      'antiguo':$('#ddl_localizacion_1').val(),
      'query':$('#txt_query1_loc').val(),
    }
      $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?vincular_localizacion_todo=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            if(response==1)
            {
              lista_desvinculado_loc();
              $('#ddl_localizacion_3').empty();
              Swal.fire('Vinculacion realizada','','success');

            }else
            {             
              Swal.fire('Algo extraño a pasado','','error');
            }
            $('#modal_vincular').modal('hide');         
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
            <h1 class="m-0 text-dark">VINCULAR O DESVINCULAR ARTICULO </h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Vincular</a>
              </li>              
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Desvincular</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
              </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <br>
                <div class="row">
                  <div class="col-sm-6">
                       <div class="card">
                      <div class="card-header">
                        <div class="row">                          
                          <div class="col-sm-12 input-group">
                            <b>Buscar por Custodio</b>
                            <select class="form-control form-control-sm" id="ddl_custodio_1" onchange="lista_desvinculado_cus()">
                              <option value="">Seleccione Una localizacion</option>
                            </select>
                            <span class="input-group-append">
                              <button type="button" class="btn btn-secondary btn-sm btn-flat" onclick="$('#ddl_custodio_1').empty()" title="Limpiar localizacion"><i class="fa fa-times"></i></button>
                            </span>
                          </div> 
                          <div class="col-sm-12">
                             <b>Buscar articulo</b>
                               <input type="" name="txt_query1" id="txt_query1" class="form-control form-control-sm" placeholder="Buscar Articulo" onkeyup="lista_desvinculado_cus()">      
                          </div>                            
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12"> 
                             <div class="row">
                                <div class="col-sm-9">
                                  <b>Nuevo Custodio</b>
                                    <div class="input-group input-group-sm">
                                      <select class="form-control form-control-sm" id="ddl_custodio_2">
                                        <option value="">Seleccione un Custodio</option>
                                      </select>
                                    </div>                           
                                </div>  
                                 <div class="col-sm-3"><br>
                                   <button class="btn btn-sm btn-primary" onclick="guardar_vin_custodio_todo()"><i class="fa fa-address-book"></i> Ligar todos</button>
                                 </div>               
                              </div> 
                              <table class="table table-hover table-sm">
                                <thead>
                                  <th>IMAGEN</th>
                                  <th>TAG</th>
                                  <th>NOMBRE</th>
                                  <th>CUSTODIO</th>
                                  <th></th>
                                </thead>
                                <tbody id="tbl_datos_cus">
                                  <tr>
                                    <td colspan="4">No se encontraron articulos</td>
                                  </tr>
                                </tbody>
                              </table>
                          </div>
                        </div>
                      </div>
                    </div>                    
                  </div>
                  <div class="col-sm-6">
                       <div class="card">
                        <div class="card-header">
                          <div class="row">                            
                            <div class="col-sm-12 input-group">
                              <b>Buscar por localizacion</b>
                              <select class="form-control form-control-sm" id="ddl_localizacion_1" onchange="lista_desvinculado_loc()">
                                <option value="">Seleccione Una localizacion</option>
                              </select>
                              <span class="input-group-append">
                                <button type="button" class="btn btn-secondary btn-sm btn-flat" onclick="$('#ddl_localizacion_1').empty()" title="Limpiar localizacion"><i class="fa fa-times"></i></button>
                              </span>
                            </div>
                            <div class="col-sm-12">
                               <b>Buscar articulo</b>
                                 <input type="" name="txt_query" id="txt_query1_loc" class="form-control form-control-sm" placeholder="Buscar Articulo" onkeyup="lista_desvinculado_loc()">      
                            </div>                             
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <div class="row">                  
                            <div class="col-sm-9">
                              <b>Nueva Localizacion</b>
                                <div class="input-group input-group-sm">
                                  <select class="form-control form-control-sm" id="ddl_localizacion_2">
                                    <option value="">Seleccione Localizacion</option>
                                  </select>
                                </div>                           
                            </div>
                            <div class="col-sm-3"><br>
                               <button class="btn btn-sm btn-primary" onclick=" guardar_vin_loc_todo()"><i class="fa fa-address-book"></i> Ligar todos</button>
                             </div>     
                          </div>                          
                          <div class="row">                  
                            <div class="col-sm-12">
                               <table class="table table-hover table-sm">
                                <thead>
                                  <th>IMAGEN</th>
                                  <th>TAG</th>
                                  <th>NOMBRE</th>
                                  <th>LOCALIZACION</th>
                                  <th></th>
                                </thead>
                                <tbody id="tbl_datos_loc">
                                  <tr>
                                    <td colspan="4">No se encontraron articulos</td>
                                  </tr>
                                  
                                </tbody>
                              </table>                    
                            </div>                  
                          </div>
                        </div>
                      </div>
                  </div>
                </div>




              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">


            <div class="card">
              <div class="card-header">
                <div class="row">                  
                  <div class="col-sm-5 input-group">
                    <b>Custodio</b>
                        <select class="form-control form-control-sm" id="ddl_custodio" onchange="lista_articulos()">
                          <option value="">Seleccione un Custodio</option>
                        </select>
                        <span class="input-group-append">
                          <button type="button" class="btn btn-secondary btn-sm btn-flat" onclick="$('#ddl_custodio').empty()" title="Limpiar localizacion"><i class="fa fa-times"></i></button>
                        </span>                         
                  </div>
                   <div class="col-sm-5 input-group">
                      <b>Localizacion</b><br>
                      <select class="form-control form-control-sm" id="ddl_localizacion" onchange="lista_articulos()">
                        <option value="">Seleccione Una localizacion</option>
                      </select>
                      <span class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm btn-flat" onclick="$('#ddl_localizacion').empty()" title="Limpiar localizacion"><i class="fa fa-times"></i></button>
                      </span>
                   </div>
                   <div class="col-sm-2"> <br>
                       <div class="btn-group">
                          <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-user-times"></i> Desvincular todo 
                            <span class="sr-only">Toggle Dropdown</span>
                            <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(-1px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                              <a class="dropdown-item" href="#" onclick="desvincular('','C')">Por Custodio</a>
                              <a class="dropdown-item" href="#" onclick="desvincular('','L')">Por Localizacion</a>
                            </div>
                          </button>
                        </div>                     
                    </div>
                </div>
                 <div class="row">
                        <div class="col-sm-3">
                           <label class="checkbox-inline" style="margin: 0px;"><input type="checkbox" name="" id="rbl_exacto" onclick="activar()" checked=""> Busqueda exacta</label>                  
                        </div>
                        <div class="col-sm-3">
                           <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset_ori" checked="" onclick="lista_articulos()"> Orig Asset</label>
                           <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset" onclick="lista_articulos()"> Asset</label>
                        </div>
                        <div class="col-sm-2">
                          <!-- <b>N° Resultados</b> -->
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-sm-6">
                          <input type="" name="txt_query" id="txt_query" class="form-control form-control-sm" placeholder="Buscar Articulo" onkeyup="lista_articulos()">      
                      </div>
                      <div class="col-sm-2">
                        <input type="hidden" name="txt_pag" id="txt_pag" class="form-control form-control-sm" value="0-25" placeholder="0-25">
                      </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">                 
                             
                    <table class="table table-hover table-sm">
                      <thead>
                        <th>IMAGEN</th>
                        <th>TAG</th>
                        <th>NOMBRE</th>
                        <th>LOCALIZACION</th>
                        <th></th>
                      </thead>
                      <tbody id="tbl_datos">
                        <tr>
                          <td colspan="4">No se encontraron articulos</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<div class="modal fade" id="modal_vincular" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="titulo">Nuevo localizacion</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="txt_id_art_vin" id="txt_id_art_vin">
          <div class="col-sm-12" id="div_custodio">
            <select class="form-control form-control-sm" id="ddl_custodio_3">
             <option>Seleccione custodio</option>
            </select>            
          </div>
          <div class="col-sm-12" id="div_location" style="display: none;">
            <select class="form-control form-control-sm" id="ddl_localizacion_3">
             <option>Seleccione localizacion</option>
            </select>            
          </div>
        </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_vin_cus" onclick="guardar_vin_custodio()">Guardar</button>
        <button type="button" class="btn btn-primary" style="display:none;" id="btn_vin_loc" onclick="guardar_vin_loc()">Guardar</button>
      </div>
    </div>
  </div>

      </div><!-- /.container-fluid -->

 
<?php include('./footer.php'); ?>


