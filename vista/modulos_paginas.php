<?php include('./header.php'); ?>
<script type="text/javascript">
  $( document ).ready(function() {
    cargar_modulos();
    lista_paginas();
    cargar_modulos_ddl();
    cargar_modulos_pag();
  });

   function lista_paginas()
  {
    var parametros = 
    {
      'perfil':$('#ddl_perfil').val(),
      'modulo':$('#ddl_modulos').val(),
      'query':$('#txt_pagina').val(),
    }

    $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?lista_paginas=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
           
            $('#tbl_paginas').html(response);
            // accesos_asignados();
           
          } 
          
       });
  }

function cargar_modulos_ddl()
{   
  $.ajax({
       // data:  {parametros:parametros},
       url:   '../controlador/tipo_usuarioC.php?modulos=true',
       type:  'post',
       dataType: 'json',
         success:  function (response) {  
          // console.log(response);
         if (response) 
         {
          $('#ddl_modulos').html(response);
         } 
        } 
        
     });
}


function cargar_modulos()
  {   
    $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/tipo_usuarioC.php?modulos_tabla=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            // console.log(response);
           if (response) 
           {
            $('#tbl_modulos').html(response);
           } 
          } 
          
       });
  }

  function cargar_modulos_pag()
  {   
    $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/tipo_usuarioC.php?modulos=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            // console.log(response);
           if (response) 
           {
            html = response.replace('Todos','Modulos');
            $('#ddl_modulos_pag').html(html);
           } 
          } 
          
       });
  }

  function guardar_modulos(id='')
  {
    var query = $('#txt_modulo'+id).val();
    if(query=='')
    {
      Swal.fire('El campo no puede estar vacio','Asegurese de llenar el campo','info');
      return false;
    }
    var parametros = 
    {
      'modulo':query,
      'id':id,
      'icono':$('#ddl_icono'+id).val(),
      'detalle':$('#txt_detalle'+id).val(),
    }
     $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?guardar_modulos=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            console.log(response);
            if(response==1)
            {
              Swal.fire('Modulo guardado','','success');
            }cargar_modulos();
           
          } 
          
       });
  }
  function eliminar_modulos(id)
  {
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
          eliminar(id);
        }
      });
  }

  function eliminar(id)
  {    
     $.ajax({
         data:  {id:id},
         url:   '../controlador/modulos_paginasC.php?eliminar_modulos=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            if(response==1)
            {
              Swal.fire('Registro Eliminado','','success');
            }cargar_modulos();
           
          } 
          
       });
  }

   function eliminar_pagina(id)
  {
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
          eliminar_pag(id);
        }
      });
  }

  function eliminar_pag(id)
  {    
     $.ajax({
         data:  {id:id},
         url:   '../controlador/modulos_paginasC.php?eliminar_pagina=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            if(response==1)
            {
              Swal.fire('Registro Eliminado','','success');
            } lista_paginas();
           
          } 
          
       });
  }

function guardar_pagina(id='')
  {
    var pagina = $('#txt_pagina_new'+id).val();
    var detalle = $('#txt_detalle_pag'+id).val();
    var url = $('#txt_url'+id).val();
    var modulo = $('#ddl_modulos_pag'+id).val();
    var icono = $('#ddl_icono_pag'+id).val();

    if(pagina=='' || detalle=='' || url=='' || modulo=='')
    {
      Swal.fire('Asegurese de llenar todos los datos','Uno de los campos esta vacio','info');
      return false;
    }
    var parametros = 
    {
      'modulo':modulo,
      'id':id,
      'pagina':pagina,
      'detalle':detalle,
      'url':url,
      'icono':icono,
      'defaul':$('#rbl_defaul').prop('checked'),
      'activo':$('#rbl_estado').prop('checked'),
      'subpag':$('#rbl_subpag').prop('checked'),
    }
     $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?guardar_paginas=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            console.log(response);
            if(response==1)
            {
              Swal.fire('Pagina guardada','','success');
            }
    lista_paginas();
    limpiar_pag();
           
          } 
          
       });
  }

  function default_pag(id)
  {
    var op = $('#rbl_defaul'+id).prop('checked');
    var parametros = 
    {
      'op':op,
      'id':id,
    }
     $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?defaul_paginas=true',
         type:  'post',
         dataType: 'json',        
           success:  function (response) {  
            console.log(response);                       
          }           
       });
  }

   function subpag(id)
  {
    var op = $('#rbl_subpag'+id).prop('checked');

    // console.log(id);console.log(op);
    var parametros = 
    {
      'op':op,
      'id':id,
    }
     $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?sub_pagina=true',
         type:  'post',
         dataType: 'json',        
           success:  function (response) {  
            console.log(response);                       
          }           
       });
  }

  function activo_pag(id)
  {
    var op = $('#rbl_activo'+id).prop('checked');
    var parametros = 
    {
      'op':op,
      'id':id,
    }
     $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/modulos_paginasC.php?activo_paginas=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            console.log(response);
                       
          } 
          
       });
  }

  function limpiar_pag()
  {
     $('#txt_pagina_new').val('');
     $('#txt_detalle_pag').val('');
     $('#txt_url').val('');
     $('#ddl_modulos_pag').val('');
     $('#ddl_icono_pag').val("<i class='far fa-circle nav-icon'></i>");

  }
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Modulos y paginas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">


        <div class="row">
          <div class="col-sm-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Modulos</a>
              </li>              
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Paginas</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
              </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                  <table class="table">
                       <tr>
                      <td> <input type="text"  class="form-control form-control-sm" name="txt_modulo" id="txt_modulo" placeholder="Nombre">
                      </td>
                      <td>
                        <input type="text"  class="form-control form-control-sm" name="txt_detalle" id="txt_detalle" placeholder="Descripcion de Modulo">                       
                      </td>
                      <td>
                        <select class="fa" id="ddl_icono" name="ddl_icono"> 
                              <option value="<i class='far fa-circle nav-icon'></i>"> Icono</option>
                              <option class="fa" value="<i class='nav-icon fas fa-home'></i>"> &#xf015;</option>
                              <option class="fa" value="<i class='far fa-circle nav-icon'></i>"> &#xf111;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-th'></i>"> &#xf00a;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-copy'></i>"> &#xf0c5;</option>
                              <option class="fa" value="<i class='nav-icon fa fa-arrow-circle-down'></i>"> &#xf0ab;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-database'></i>"> &#xf1c0;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-tag'></i>"> &#xf02b;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-money-bill'></i>"> &#xf0d6;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-file-invoice'></i>"> &#xf570;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-user'></i>"> &#xf007;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-cogs'></i>"> &#xf085;</option>
                              <option class="fa" value="<i class='nav-icon fa fa-arrow-circle-up'></i>"> &#xf0aa;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-wrench'></i>"> &#xf0ad;</option>
                          </select> 
                      </td>

                      <td>
                        <button class="btn btn-sm btn-primary"  onclick="guardar_modulos()"><i class="fa fa-plus"></i></i> Agregar</button> 
                      </td>
                    </tr>
                  </table>
                  <table class="table table-hover">                    
                    <thead class="table btn-secondary text-white">
                      <th>Modulo</th>
                      <th>Detalle</th>
                      <th>Icono</th>
                      <th></th>
                    </thead>
                    <tbody id="tbl_modulos">
                      <tr>
                        <td colspan="2">No se encontraron tipos de usuario</td>
                      </tr>
                    </tbody>
                  </table>                  
                </div>
                
              </div>             

              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row"><br> 
                 <div class="col-sm-4">
                  <b>Buscar pagina</b>
                    <input type="text" name="txt_pagina" id="txt_pagina" placeholder="Buscar pagina" class="form-control form-control-sm" onkeyup="lista_paginas()">             
                  </div>                 
                  <div class="col-sm-2">
                    <b>Modulos</b>
                    <select class="form-control form-control-sm" id="ddl_modulos" name="ddl_modulos" onchange="lista_paginas()">
                      <option value="">Modulos</option>
                    </select>                    
                  </div>
                  
                </div>
                
                <table class="table">
                    <thead>
                      <th>Nombre en menu</th>
                      <th>Detalle</th>
                      <th>link</th>
                      <th>Modulo</th>
                      <th>Default</th>
                      <th>subpagina</th>
                      <th>Activo</th>
                      <th>Icono</th>
                       <th></th>
                    </thead>
                    <tr>
                        <td><input type="" name="txt_pagina_new" id="txt_pagina_new" class="form-control form-control-sm"></td>
                        <td><textarea class="form-control form-control-sm" rows="1" id="txt_detalle_pag" name="txt_detalle_pag" ></textarea> </td>
                        <td><input type="" name="txt_url" id="txt_url" class="form-control form-control-sm"></td>
                        <td><select class="form-control form-control-sm" id="ddl_modulos_pag" name="ddl_modulos_pag"> 
                      			<option>Modulos</option>
                        	</select>
                        </td>
                        <td width="15px" class="text-center"><input type="checkbox" name="rbl_defaul" id="rbl_defaul"></td>
                        <td width="15px" class="text-center"><input type="checkbox" name="rbl_subpag" id="rbl_subpag"></td>
                        <td width="15px" class="text-center"><input type="checkbox" name="rbl_estado" id="rbl_estado" checked></td>
                        
                        <td>
                        	<select class="fa" id="ddl_icono_pag" name="ddl_icono_pag"> 
                              <option value="<i class='far fa-circle nav-icon'></i>"> Icono</option>
                              <option class="fa" value="<i class='nav-icon fas fa-home'></i>"> &#xf015;</option>
                              <option class="fa" value="<i class='far fa-circle nav-icon'></i>"> &#xf111;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-th'></i>"> &#xf00a;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-copy'></i>"> &#xf0c5;</option>
                              <option class="fa" value="<i class='nav-icon fa fa-arrow-circle-down'></i>"> &#xf0ab;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-database'></i>"> &#xf1c0;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-tag'></i>"> &#xf02b;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-money-bill'></i>"> &#xf0d6;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-file-invoice'></i>"> &#xf570;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-user'></i>"> &#xf007;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-cogs'></i>"> &#xf085;</option>
                              <option class="fa" value="<i class='nav-icon fa fa-arrow-circle-up'></i>"> &#xf0aa;</option>
                              <option class="fa" value="<i class='nav-icon fas fa-wrench'></i>"> &#xf0ad;</option>
                          </select> 

                        </td>
                        <td><button class="btn btn-primary" onclick=" guardar_pagina();"><i class="fa fa-save"></i></button></td>
                      </tr>
                    <tbody id="tbl_paginas">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td width="15px" class="text-center"><input type="checkbox" name="" id="" checked></td>
                        <td width="15px" class="text-center"><input type="checkbox" name="" id="" checked></td>
                        <td><i class="fa fa-plus"></i></td>
                        <td><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                      </tr>
                    </tbody>
                </table>
              </div>
              
              <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
            </div>
          </div>
        </div>


      	<br>

      </div>

       
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
            <div class="col-sm-6">
             
            </div> 
            <div class="col-sm-6 text-right"><br>
            </div>             
            </div>
                    
          </div>          

        </div>
      	
      	

                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
