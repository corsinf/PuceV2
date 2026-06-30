<?php include('./header.php'); ?>
<script type="text/javascript">
  $('body').addClass('sidebar-collapse');
  $( document ).ready(function() {
     ddl_meses();
  	autocmpletar();
  	autocmpletar_l();
    var fil1 = '<?php if(isset($_GET["fil1"])){echo $_GET["fil1"];} ?>';
    var fil2 = '<?php if(isset($_GET["fil2"])){echo $_GET["fil2"];} ?>';
    // console.log(fil1);
    // console.log(fil2);
    if(fil1 !='null--null')
    {    
        var loc = fil1.split('--');
        $('#ddl_localizacion').append($('<option>',{value: loc[0], text: loc[1],selected: true }));
    }
    if(fil2 !='null--null')
    {
       var cus = fil2.split('--');
        $('#ddl_custodio').append($('<option>',{value: cus[0], text:cus[1],selected: true }));
    }

  	lista_articulos();


      // $('#imprimir_excel').click(function(){
      //  var url = '../lib/Reporte_excel.php?reporte_normal&query='+$('#txt_buscar').val()+'&loc='+$('#ddl_localizacion').val()+'&cus='+$('#ddl_custodio').val();                 
      //      window.open(url, '_blank');
      //  });
      $('#imprimir_excel_sap').click(function(){
        if($('#txt_desde').val()=='' || $('#txt_hasta').val()=='')
      {
        Swal.fire('Rango de fechas no validos','Asegurese de que los rangos de fecha esten bien seleccionados','info');
        return false;
      }
       var url = '../lib/Reporte_excel.php?reporte_sap&query='+$('#txt_buscar').val()+'&loc='+$('#ddl_localizacion').val()+'&cus='+$('#ddl_custodio').val()+'&desde='+$('#txt_desde').val()+'&hasta='+$('#txt_hasta').val();      

       // console.log(url);           
           window.open(url, '_blank');
       });

      $('#imprimir_excel_bajas_sap').click(function(){
        if($('#txt_desde').val()=='' || $('#txt_hasta').val()=='')
      {
        Swal.fire('Rango de fechas no validos','Asegurese de que los rangos de fecha esten bien seleccionados','info');
        return false;
      }
       var url = '../lib/Reporte_excel.php?reporte_sap_bajas_rangos&query='+$('#txt_buscar').val()+'&loc='+$('#ddl_localizacion').val()+'&cus='+$('#ddl_custodio').val()+'&desde='+$('#txt_desde').val()+'&hasta='+$('#txt_hasta').val();                 
           window.open(url, '_blank');
       });

       $('#imprimir_excel_tot').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_total';                 
           window.open(url, '_blank');
       });

       $('#imprimir_excel_actual').click(function(){
       
       /* var parametros = '&query='+$('#txt_buscar').val()+'&localizacion='+$('#ddl_localizacion').val()+'&custodio='+ $('#ddl_custodio').val()+'&pag='+$('#txt_pag').val()+'&exacto='+$('#rbl_exacto').prop('checked')+'&asset='+$('#rbl_aset').prop('checked')+
      '&asset_org='+$('#rbl_aset_ori').prop('checked')+'&rfid='+$('#rbl_rfid').prop('checked')+'&multiple='+$('#txt_masivo').val();
       var url = '../lib/Reporte_excel.php?reporte_actual=true'+parametros;  
       */

       parametros = {
          'query': $('#txt_buscar').val(),
          'localizacion':$('#ddl_localizacion').val(),
          'custodio':$('#ddl_custodio').val(),
          'pag':$('#txt_pag').val(),
          'exacto':$('#rbl_exacto').prop('checked'),
          'asset':$('#rbl_aset').prop('checked'),
          'asset_org':$('#rbl_aset_ori').prop('checked'),
          'rfid':$('#rbl_rfid').prop('checked'),
          'multiple':$('#txt_masivo').val()
       }     

       console.log(parametros);

       $.ajax({
          data: { parametros: parametros },
          url: "../lib/Reporte_excel.php?reporte_actual=true",
          type: 'POST',
          xhrFields: {
              responseType: 'blob' // Indica que esperas un archivo como respuesta
          },
          success: function (blob) {
              // Crear una URL para el archivo
              const url = window.URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = 'reporte_actual.xls'; // Nombre del archivo
              document.body.appendChild(a);
              a.click(); // Descargar el archivo
              a.remove(); // Limpiar
          },
          error: function (xhr, status, error) {
              console.error('Error:', error);
          }
        });


        // fetch("../lib/Reporte_excel.php?reporte_actual=true", {
        //     method: "POST",
        //     headers: {
        //         "Content-Type": "application/json",
        //     },
        //     body: JSON.stringify(parametros)
        // })
        // .then(response => {
        //     if (!response.ok) {
        //         throw new Error("Error al generar el archivo");
        //     }
        //     return response.blob(); // Convertir la respuesta a un Blob
        // })
        // .then(blob => {
        //     // Crear una URL para el Blob
        //     const url = window.URL.createObjectURL(blob);
        //     const a = document.createElement("a");
        //     a.href = url;
        //     a.download = "reporte_actual.xls"; // Nombre del archivo
        //     document.body.appendChild(a);
        //     a.click(); // Descargar el archivo
        //     a.remove(); // Limpiar
        // })
        // .catch(error => console.error("Error:", error));





           // window.open(url, '_blank');
       });


        $('#imprimir_excel_bajas').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_sap_bajas';                 
           window.open(url, '_blank');
       });
         $('#imprimir_excel_terceros').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_sap_terceros';                 
           window.open(url, '_blank');
       });
          $('#imprimir_excel_patrimoniales').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_sap_patrimoniales';                 
           window.open(url, '_blank');
       });

       $('#imprimir_excel_cambios').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_cambios';                 
           window.open(url, '_blank');
       });

        $('#imprimir_excel_cambios_rango').click(function(){
       var url = '../lib/Reporte_excel.php?reporte_cambios=true&desde='+$('#txt_desde').val()+'&hasta='+$('#txt_hasta').val();                 
           window.open(url, '_blank');
       });




     $('#imprimir_pdf').click(function(){
      if($('#txt_desde').val()=='' || $('#txt_hasta').val()=='')
      {
        Swal.fire('Coleque fechas validas','','info');
        return false;
      }
      var url='../lib/Reporte_pdf.php?reporte_pdf&query='+$('#txt_buscar').val()+'&loc='+$('#ddl_localizacion').val()+'&cus='+$('#ddl_custodio').val()+'&desde='+$('#txt_desde').val()+'&hasta='+$('#txt_hasta').val();
      window.open(url, '_blank');
       });
      // $('#imprimir_pdf_sap').click(function(){
      // var url='../lib/Reporte_pdf.php?reporte_pdf_sap&query='+$('#txt_buscar').val()+'&loc='+$('#ddl_localizacion').val()+'&cus='+$('#ddl_custodio').val();
      // window.open(url, '_blank');
      //  });

      $('#reporte_pdf_total').click(function(){
      var url='../lib/Reporte_pdf.php?reporte_pdf_total';
      window.open(url, '_blank');
       });
      $('#reporte_pdf_bajas').click(function(){
      var url='../lib/Reporte_pdf.php?reporte_pdf_bajas';
      window.open(url, '_blank');
       });
       $('#reporte_pdf_terceros').click(function(){
      var url='../lib/Reporte_pdf.php?reporte_pdf_terceros';
      window.open(url, '_blank');
       });
        $('#reporte_pdf_patrimoniales').click(function(){
      var url='../lib/Reporte_pdf.php?reporte_pdf_patrimoniales';
      window.open(url, '_blank');
       });


});

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

   function autocmpletar_masivo(){
      $('#ddl_custodio_masivo').select2({
        placeholder: 'Seleccione una custodio',
        dropdownParent: $('#busqueda_masiva_custodio'),
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



  function autocmpletar_lo_masivo(){
      var cus='';
    if($('#txt_masivo_cus').val()==1)
    {
      var val= $('#ddl_custodio_masivo').val();
      
      val.forEach(function(item,i){
        // console.log(item);
         cus+=item+'-';
      })
      cus = cus.substring(0,cus.length-1);
    }else
    {      
      cus= $('#ddl_custodio').val();
    }

      $('#ddl_localizacion_masivo').select2({
        placeholder: 'Seleccione una localizacion',
         dropdownParent: $('#busqueda_masiva_localizacion'),
        width:'100%',
        ajax: {
          url: '../controlador/localizacionC.php?lista=true&custodio='+cus+'&masivo='+$('#txt_masivo_cus').val(),
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
      'exacto':$('#rbl_exacto').prop('checked'),
      'asset':$('#rbl_aset').prop('checked'),
      'asset_org':$('#rbl_aset_ori').prop('checked'),
      'rfid':$('#rbl_rfid').prop('checked'),
      // 'multiple':$('#rbl_multiple').prop('checked'),
      'query2': $('#txt_query2').val(),
      'masivo': $('#txt_masivo').val(),
      'masivo_cu':$('#txt_masivo_cus').val(),
      'masivo_lo':$('#txt_masivo_loc').val(),
      'custodio_masivo':$('#ddl_custodio_masivo').val(),
      'empla_masivo':$('#ddl_localizacion_masivo').val(),
  	 }
  	 var lineas = '';
    $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/articulosC.php?lista=true',
      type:  'post',
      dataType: 'json',
      beforeSend: function () {   
           $('#tbl_datos').html('<tr><td><img src="../img/de_sistema/loader_puce.gif" width="100" height="100"></td></tr>');
         $('#pag').html('');
      },
        success:  function (response) { 
        // console.log(response);
        var pag = $('#txt_pag1').val().split('-');        
        var pag2 = $('#txt_pag').val().split('-');

        var pagi = '<li class="page-item" onclick="guias_pag(\'-\')"><a class="page-link" href="#"> << </a></li>';
        if($('#txt_numpag').val() =='')
        {
          $('#txt_numpag').val(response.cant / pag[1]);
        }
        if(response.cant > pag[1])
        {
           var num = response.cant / pag[1];
           if(num >10)
           {
            if(pag2[1]/pag[1] <= 10)
            {
            for (var i = 1; i < 11 ; i++) {
              var pos =pag[1]*i;
              var ini =pos-pag[1];  
              var pa = ini+'-'+pos;
              if($('#txt_pag').val()==pa){
               pagi+='<li class="page-item active" onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }else
              { 
                pagi+='<li class="page-item" onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }
            }
           }else
           {

               pagi+='<li class="page-item" onclick="paginacion(\'0-25\')"><a class="page-link" href="#">1</a></li>';
            for (var i = pag2[1]/25; i < (pag2[1]/25)+10 ; i++) {
              var pos =pag[1]*i;
              var ini =pos-pag[1];  
              var pa = ini+'-'+pos;
              if($('#txt_pag').val()==pa){
               pagi+='<li class="page-item active" onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }else
              { 
                pagi+='<li class="page-item" onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }
            }
           }
            pagi+='<li class="page-item" onclick="guias_pag(\'+\')"><a class="page-link" href="#"> >> </a></li>'
           }else
           { 
             
            for (var i = 1; i < num+1 ; i++) {
              var pos =pag[1]*i;
              var ini =pos-pag[1];  
              var pa = ini+'-'+pos;
              if($('#txt_pag').val() == pa)
              {
               pagi+='<li class="page-item active"  onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }else
              {  
                pagi+='<li class="page-item"  onclick="paginacion(\''+pa+'\')"><a class="page-link" href="#">'+i+'</a></li>';
              }
            }
           }

        $('#pag').html(pagi);  

        }   
        $.each(response.datos, function(i, item){
          baja = '';
          if(item.BAJAS==1){baja = 'background-color: coral;/*bg-danger*/'}
          if(item.PATRIMONIALES==1){baja = 'background-color: #ffc108a6; /*bg-warning*/';}
          if(item.TERCEROS==1){baja ='background-color: #007bffa8;; /*bg-blue*/'}
        	lineas+= '<tr style="'+baja+'"  onclick="redireccionar(\''+item.id+'\')"><td>'+item.id+'</td><td style="color: #1467e2;"><u>'+item.tag+'</u></td><td>'+item.nom+'</td><td>'+item.modelo+'</td><td>'+item.serie+'</td><td>'+item.RFID+'</td><td>'+item.localizacion+'</td><td>'+item.custodio+'</td><td>'+item.marca+'</td><td>'+item.estado+'</td><td>'+item.genero+'</td><td>'+item.color+'</td><td>'+item.fecha_in+'</td><td>'+item.OBSERVACION+'</td></tr>';
          console.log(item);
       
        });       
        $('#tbl_datos').html(lineas);
        if($('#txt_masivo').val()==1)
        {
          $('#txt_buscar').val(response.busqueda);  
        }      
      },
      error: function (error) {
    alert(JSON.stringify(error));
}
    });
  }
  function limpiar(ddl)
  {
  	$('#'+ddl).val('').trigger('change');
  }
  function redireccionar(id){
    var loc= 'null';var cus = 'null';
    if($('#ddl_localizacion').val() != null)
    {
      loc = $('#ddl_localizacion').select2('data')[0].text;
    }
    if($('#ddl_custodio').val() != null)
    {
      cus = $('#ddl_custodio').select2('data')[0].text;
    }
  	 window.location.href="detalle_articulo.php?id="+id+'&fil1='+$('#ddl_localizacion').val()+'--'+loc+'&fil2='+$('#ddl_custodio').val()+'--'+cus;
    }
function paginacion(num)
{
  $('#txt_pag').val(num);
  var pag = $('#txt_pag').val().split('-');
  var pos = pag[1]/25;
  lista_articulos();
  // alert(pos);
}
function guias_pag(tipo)
{

  var m1 =  $('#txt_pag').val().split('-');
  var m =  $('#txt_pag1').val().split('-');
  var pos = m1[1]/25;
  if (tipo=='+')
  {
    if(pos >= 10)
    {
       var fin =  m[1]*(pos+1);
       var ini = fin-m[1];
       $('#txt_pag').val(ini+'-'+fin);
       lista_articulos();

    }else{
    var fin =  m[1]*(pos+1);
    var ini = fin-m[1];
    $('#txt_pag').val(ini+'-'+fin);
    lista_articulos();
   }

  }else
  {
    if(pos == 1)
    {
      alert('esta en el inicio');
    }else
    {
       var fin =  m[1]*(pos-1);
       var ini = fin-m[1];
       $('#txt_pag').val(ini+'-'+fin); 
       lista_articulos();  
    }
  }
}

function activar()
{
  if(!$('#rbl_exacto').prop('checked'))
  {
    $('#rbl_aset').prop('checked',false);
    $('#rbl_aset_ori').prop('checked',false);
    $('#rbl_aset').prop('disabled',true);
    $('#rbl_aset_ori').prop('disabled',true);
    $('#rbl_rfid').prop('checked',false);
    $('#rbl_rfid').prop('disabled',true);
  }else
  {

    $('#rbl_aset').prop('disabled',false);
    $('#rbl_aset_ori').prop('disabled',false);
    $('#rbl_rfid').prop('disabled',false);
    $('#rbl_aset').prop('checked',true);
  }
  lista_articulos();
}

  function ddl_meses()
  { 
    var opcion = '<option value="">seleccione un mes</option>';
    $.ajax({
      // data:  {id:id},
      url:  '../controlador/articulosC.php?meses=true',
      type:  'post',
      dataType: 'json',
      /*beforeSend: function () {   
           var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
         $('#tabla_').html(spiner);
      },*/
        success:  function (response) {
          console.log(response);
          $.each(response,function(i,item){
            opcion+="<option value='"+item.num+"'>"+item.mes+"</option>";
          })
           $('#ddl_meses').html(opcion); 
      }
    });
  }


  function busqued_multiple()
  {
     check = $('#rbl_multiple').prop('checked');
     if(check)
     {
       $('#rbl_exacto').prop('checked',true);
       $('#rbl_exacto').attr('disabled',true);
       // alert('actyivo');
     }else
     {

       $('#rbl_exacto').prop('checked',true);
       $('#rbl_exacto').attr('disabled',false);
       // alert('no act');
     }
     lista_articulos();
  }

  function reiniciar_filtros()
  {
    $('#txt_buscar').val('');
    limpiar('ddl_custodio');
    limpiar('ddl_localizacion');
  }


</script>

  

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="titulo">Nueva marca</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" hidden="">
        Codigo <br>
        <input type="input" name="codigo" id="codigo" class="form-control">
        Descripcion <br>
        <input type="input" name="descripcion" id="descripcion" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="op" onclick="editar_insertar()">Guardar</button>
      </div>
    </div>
  </div>
</div>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bienes</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">    
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="btn-group">
              <button class="btn btn-primary btn-sm" onclick="$('#myModal1').modal('show')"><i class="fa fa-calendar"></i> Informe por fechas</button>              
            </div>
            <div class="btn-group">
                <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Busqueda Actual</button>
                <ul class="dropdown-menu" x-placement="bottom-start">
                  <li class="dropdown-item"><a href="#" id="imprimir_excel_actual">Informe en EXCEL</a></li>
                </ul>
            </div>  

          <div class="btn-group">
              <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Total de activos</button>
              <ul class="dropdown-menu" x-placement="bottom-start">
                <li class="dropdown-item"><a href="#" id="reporte_pdf_total"><i class="fa fa-file-pdf"></i>  Informe en PDF</a></li>
                <li class="dropdown-item"><a href="#" id="imprimir_excel_tot"><i class="fa fa-file-excel"></i>  Informe en EXCEL</a></li>
              </ul>
          </div>
          <div class="btn-group">
              <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Total de bajas</button>
              <ul class="dropdown-menu" x-placement="bottom-start">
                <li class="dropdown-item"><a href="#" id="reporte_pdf_bajas">Informe en PDF</a></li>
                <li class="dropdown-item"><a href="#" id="imprimir_excel_bajas">Informe en EXCEL</a></li>
              </ul>
          </div>          
          <div class="btn-group">
              <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Total de patrimoniales</button>
              <ul class="dropdown-menu" x-placement="bottom-start">
                <li class="dropdown-item"><a href="#" id="reporte_pdf_patrimoniales">Informe en PDF</a></li>
                <li class="dropdown-item"><a href="#" id="imprimir_excel_patrimoniales">Informe en EXCEL</a></li>
              </ul>
          </div>          
          <div class="btn-group">
              <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Total de Terceros</button>
              <ul class="dropdown-menu" x-placement="bottom-start">
                <li class="dropdown-item"><a href="#" id="reporte_pdf_terceros">Informe en PDF</a></li>
                <li class="dropdown-item"><a href="#" id="imprimir_excel_terceros">Informe en EXCEL</a></li>
              </ul>
          </div>
          <div class="btn-group">
              <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> Informe de cambio</button>
              <ul class="dropdown-menu" x-placement="bottom-start">
                <li class="dropdown-item"><a href="#" id="imprimir_excel_cambios">Informe en EXCEL</a></li>
              </ul>
          </div>          
        </div>
        <div class="row">
          <div class="col-sm-4">
              <div class="row" style="font-size: 12px;margin: 2px;">
                <div class="col-sm-4">
                   <label class="checkbox-inline" style="margin: 0px;"><input type="checkbox" name="" id="rbl_exacto" onclick="activar()" checked=""> Busqueda exacta</label>                  
                </div>
                <div class="col-sm-2">
                   <!-- <label class="checkbox-inline" style="margin: 0px;"><input type="checkbox" name="" id="rbl_multiple" onclick="busqued_multiple()"> Busqueda Multiple</label>                                         -->
                </div>             
                <div class="col-sm-6">
                  <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset"  onclick="lista_articulos()" checked=""> Asset</label>
                   <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset_ori"  onclick="lista_articulos()"> Orig Asset</label>
                   <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_rfid"  onclick="lista_articulos()"> RFID</label>
                          
                </div>
              </div>
              <div class="input-group input-group-sm">
                <input type="" name="" id="txt_buscar" onkeyup="lista_articulos()" class="form-control form-control-sm" placeholder="Buscar bien">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="$('#txt_masivo').val(0);$('#txt_buscar').val('');lista_articulos()" title="Limpiar"><i class="fa fa-times"></i></button> 
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="reiniciar_filtros();$('#busqueda_masiva').modal('show');$('#txt_masivo').val(1)" title="Pegar codigos de busqueda"><i class="fa fa-list"></i></button>               
              </div>                                           
             </div>
             <div class="col-sm-4">
             <b> Busqueda por custodio</b>
               <div class="input-group input-group-sm">
                <select class="form-control form-control-sm" id="ddl_custodio" onchange="$('#txt_pag').val('0-25');lista_articulos()" style="width:80%"></select>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="autocmpletar_masivo();$('#busqueda_masiva_custodio').modal('show');$('#txt_masivo_cus').val(1)" title="Busqueda masiva por custodi"><i class="fa fa-list" id="icono_cus"></i></button>       
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="$('#txt_masivo_cus').val(0);$('#ddl_custodio_masivo').empty();$('#ddl_custodio_masivo').val('').trigger('change');limpiar('ddl_custodio');cerrar_custodio();autocmpletar_l()" title="Limpiar custodio"><i class="fa fa-trash"></i></button>
                </div>
             </div>

             <div class="col-sm-4">
               <b> Busqueda por Localizacion</b>
               <div class="input-group input-group-sm">
                <select class="form-control form-control-sm" id="ddl_localizacion" onchange="$('#txt_pag').val('0-25');lista_articulos()" style="width:80%"></select>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="autocmpletar_lo_masivo();$('#busqueda_masiva_localizacion').modal('show');$('#txt_masivo_loc').val(1)" title="Busqueda masiva por localizacion"><i class="fa fa-list" id="icono_loc"></i></button>      
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="$('#txt_masivo_loc').val(0);autocmpletar_l();$('#ddl_localizacion_masivo').empty();limpiar('ddl_localizacion');cerrar_loc()" title="Limpiar localizacion"><i class="fa fa-trash"></i></button>
                </div>
             </div>

        </div>
        
        </div>

          
      </div>    
   
            <div class="row">
              <input type="hidden" id="txt_pag" name="" value="0-25">
              <input type="hidden" id="txt_pag1" name="" value="0-25">
              <input type="hidden" id="txt_numpag" name="">
                  <!-- <div class="col-sm-4">
                     <div class="row">
                    <div class="col-sm-6">
                       <label class="checkbox-inline" style="margin: 0px;"><input type="checkbox" name="" id="rbl_exacto" onclick="activar()" checked=""> Busqueda exacta</label>                  
                    </div>
                    <div class="col-sm-6">
                       <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset_ori" checked="" onclick="lista_articulos()"> Orig Asset</label>
                       <label class="checkbox-inline" style="margin: 0px;"><input type="radio" name="rbl_aset" id="rbl_aset"  onclick="lista_articulos()"> Asset</label>
                    </div>
                  </div>
                    <input type="" name="" id="txt_buscar" onkeyup="lista_articulos()" class="form-control form-control-sm" placeholder="Buscar Descripcion o tag">               
             </div> -->
             
             

              <!-- <div class="col-sm-4">
                <div class="input-group" style="width: 100%">
                   <select class="form-control input" id="ddl_custodio" onchange="$('#txt_pag').val('0-25');lista_articulos()" style="width:80%"></select>
                   <button onclick="limpiar('ddl_custodio')" class="btn"><i class="fa fa-trash"></i></button> 
                </div>
                                                
              </div> 
               <div class="col-sm-4">
                <div class="input-group" style="width: 100%">
                  <select class="form-control input" id="ddl_localizacion" onchange="$('#txt_pag').val('0-25');lista_articulos()" style="width:80%"></select>
                  <button onclick="limpiar('ddl_localizacion')" class="btn"><i class="fa fa-trash"></i></button>
                </div>                          
              </div>  -->             
            </div>
            <div class="row">
              <div class="col-sm-6"><br>
                <label class="bg-danger"> Bajas </label>
                <label class="bg-warning"> Patrimonial</label>
                <label class="bg-primary"> Terceros </label>       
              </div>
              <div class="col-sm-6">
                <br>
                <div class="row justify-content-end">
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-sm" id="pag" style="margin:0px;"></ul>
                  </nav>           
                </div>
              </div>
          <div class="table-responsive">
            <table class="table table-striped" style="white-space: nowrap;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>TAG_SERIE</th>
                  <th>DESCRIPCION</th>
                  <th>MODELO</th>
                  <th>SERIE</th>
                  <th>RFID</th>
                  <th>LOCALIZACION</th>
                  <th>CUSTODIO</th>
                  <th>MARCA</th>
                  <th>ESTADO</th>
                  <th>GENERO</th>
                  <th>COLOR</th>
                  <th>FECHA INV.</th>
                  <th>OBSERVACION</th>
                </tr>
              </thead>
              <tbody id="tbl_datos">               
              </tbody>
            </table>
          </div>

        <!-- Button trigger modal -->


       

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="titulo">Articulos modificados por fecha</h3>
      </div>
      <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">  
                      <b style="font-size: 9px;">Desde:</b> <br>
                      <input type="date" name="" id="txt_desde" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">
                   </div>
                  <div class="col-sm-4">                
                    <b style="font-size: 9px;">Hasta:</b> <br>
                    <input type="date" name="" id="txt_hasta" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="col-sm-4">  
                  <br>             
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-file"></i> Informes
                    </button>
                    <ul class="dropdown-menu" x-placement="bottom-start">
                      <li class="dropdown-item"><a href="#" id="imprimir_excel_sap">Informe excel sap cambios</a></li>
                      <li class="dropdown-item"><a href="#" id="imprimir_excel_bajas_sap">Informe excel bajas sap</a></li>
                      <li class="dropdown-item"><a href="#" id="imprimir_excel_cambios_rango">Log de actualizaciones</a></li>
                    </ul>
                  </div>                 
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="op" onclick="editar_insertar()">Guardar</button> -->
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="busqueda_masiva" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
        <div class="row">     
          <div class="col-sm-12">
            <b>codigos</b><br>
              <textarea class="form-control" rows="5" style="resize: none;" id="txt_query2"></textarea>   
              <input type="hidden" name="txt_masivo" id="txt_masivo" value="0">     
          </div>
          
        </div> 
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary btn-sm"  onclick="lista_articulos()">Consultar</button>           
         <button type="button" class="btn btn-info btn-sm" onclick="$('#txt_masivo').val(0);$('#txt_query2').val('')">Limpiar</button>
         <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="$('#txt_query2').val('');">Cerrar</button> 
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="busqueda_masiva_custodio" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
        <div class="row">     
          <div class="col-sm-12">
            <b>Custodio</b><br>
              <select class="form-control form-control-sm" multiple="multiple" id="ddl_custodio_masivo" onchange="$('#txt_pag').val('0-25');">
              <option value="">Selecione</option>   
              </select>               
              <input type="hidden" name="txt_masivo_cus" id="txt_masivo_cus" value="0">  
          </div>
          
        </div> 
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary btn-sm"  onclick="lista_articulos()">Consultar</button>           
           <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="cerrar_custodio()">Cerrar</button> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function cerrar_custodio()
  {
    var cus = $('#ddl_custodio_masivo').val();
    console.log(cus);
    if(cus.length!=0 && cus!=null &&cus[0]!='')
    {
      $('#ddl_custodio').prop('disabled', true);
      $('#icono_cus').addClass('text-danger');
       autocmpletar_l();
    }else
    {
      $('#icono_cus').removeClass('text-danger');   
      $('#ddl_custodio').prop('disabled', false);   
    }
  }
 // ddl_localizacion
 // ddl_localizacion_masivo

  function cerrar_loc()
  {
    var cus = $('#ddl_localizacion_masivo').val();
    console.log(cus);
    if(cus.length!=0 && cus!=null &&cus[0]!='')
    {
      $('#ddl_localizacion').prop('disabled', true);
      $('#icono_loc').addClass('text-danger');
    }else
    {
      $('#icono_loc').removeClass('text-danger');   
      $('#ddl_localizacion').prop('disabled', false);
      $('#txt_masivo_loc').val(0);   
    }
  }
</script>



<div class="modal fade" id="busqueda_masiva_localizacion" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
        <div class="row">     
          <div class="col-sm-12">
            <b>Emplazamiento / localizacion</b><br>
              <select class="form-control form-control-sm" id="ddl_localizacion_masivo" multiple="multiple" onchange="$('#txt_pag').val('0-25');">
              <option value="">Selecione</option>   </select>
              <input type="hidden" name="txt_masivo_loc" id="txt_masivo_loc" value="0">     
          </div>
          
        </div> 
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary btn-sm"  onclick="lista_articulos()">Consultar</button>           
         <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="cerrar_loc();">Cerrar</button> 
      </div>
    </div>
  </div>
</div>


        <?php include('./footer.php'); ?>
     