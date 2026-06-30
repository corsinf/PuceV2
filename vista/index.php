<?php include('header.php'); //print_r($_SESSION['INICIO']); ?>
  <!-- Content Wrapper. Contains page content -->

  <script type="text/javascript">
  $( document ).ready(function() {
    usuarios();
    patrimoniales();
    bajas();
    terceros();
    articulos();
    custodio();
    localizacion();
    datos_seguros();


    custodio_des();
    localizacion_des();

  });


    function pie(sin,con) {
       var donutData        = {
      labels: [
          'Asegurados', 
          'Sin seguro',
          
      ],
      datasets: [
        {
          data: [con,sin],
          backgroundColor : ['#f56954', '#00a65a'],
        }
      ]
    }
   
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

  }


    function usuarios()
    {

       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/usuariosC.php?usuarios=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            var res = response.length;
            $('#lbl_usuarios').text(res);
          
          }
       });
    }

    function custodio()
    {

       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/custodioC.php?numero_custodios=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            $('#lbl_custodios').text(response[0]['cant']);
          
          }
       });
    }

    function localizacion()
    {

       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/localizacionC.php?numero_localizaciones=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            $('#lbl_localizaciones').text(response[0]['cant']);
          
          }
       });
    }



    function custodio_des()
    {

       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?numero_custodios=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            if(response.length>0)
            {
              $('#lbl_custodios').text(response[0]['cant']);
            }
          }
       });
    }

    function localizacion_des()
    {

       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/vinculacionC.php?numero_localizaciones=true',
         type:  'post',
         dataType: 'json',
           success:  function (response) {  
            console.log(response);
            if(response.length>0)
            {
              $('#lbl_localizaciones').text(response[0]['cant']);
            }
          
          }
       });
    }

    function patrimoniales()
    { 
      var parametros = 
      {
        'bajas':0,
        'terceros':0,
        'patrimoniales':1,
        'articulos':0,
      }
        $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/articulosC.php?articulos_especiales=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            var res = response.length;
            $('#lbl_patrimoniales').text(res);
            // console.log(res)
          
          } 
          
       });

    }

    function bajas()
    { var parametros = 
      {
        'bajas':1,
        'terceros':0,
        'patrimoniales':0,
        'articulos':0,
      }
        $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/articulosC.php?articulos_especiales=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            var res = response.length;
            $('#lbl_bajas').text(res);
            // console.log(res)
          
          } 
          
       });

    }

    function terceros()
    { var parametros = 
      {
        'bajas':0,
        'terceros':1,
        'patrimoniales':0,
        'articulos':0,
      }
        $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/articulosC.php?articulos_especiales=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            var res = response.length;
            $('#lbl_terceros').text(res);
            // console.log(res)
          
          } 
          
       });      
    }

    function articulos()
    {
      var parametros = 
      {
        'bajas':0,
        'terceros':0,
        'patrimoniales':0,
        'articulos':1,
      }
        $.ajax({
         data:  {parametros:parametros},
         url:   '../controlador/articulosC.php?articulos_especiales=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
            var res = response[0]['numreg'];
            var res1 = response[1]['eti'];
            console.log(response);
            $('#lbl_articulos').text(res);
            $('#lbl_articulos1').text(res);
            $('#lbl_etiqueta').text(res1);

            var b = parseInt(res1*100/res);
            $('#lbl_porcen').html('<b>'+b+'</b>/100');
            $('#progres').css('width',b+'%');
            $('#lbl_porce').html('<i class="fas fa-caret-up"></i> '+b+'%');


            console.log(b)
          
          } 
          
       });  
  }    


    function datos_seguros()
    {
     
        $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/contratoC.php?datos_seguros=true',
         type:  'post',
         dataType: 'json',        
           success:  function (response) {  
            console.log(response);
            pie(response.sinseguro,response.asegurados);   

            var sin = ((response.sinseguro*100)/response.total);
            var con = ((response.asegurados*100)/response.total);
            console.log(sin);console.log(con);
            $('#lbl_porce_sin_seguro').html('<i class="fas fa-caret-up">'+sin.toFixed(3)+'%');
            $('#lbl_porce_asegurados').html('<i class="fas fa-caret-up">'+con.toFixed(3)+'%');

            $('#lbl_sin_seguro').text(response.sinseguro);
            $('#lbl_asgurados').text(response.asegurados);
            $('#lbl_articulos2').text(response.total);   
            $('#lbl_num_seguros').text(response.seguros);
          
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
            <h1 class="m-0 text-dark">HOME</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" title="Ultima actualizacion con SAP">Ultima actu. con SAP</span>
                <span class="info-box-number">
                   <?php echo date('Y-m-d H:i:s'); ?>
                </span>
              </div>
            </div>
          </div> -->
          <div class="col-12 col-sm-6 col-md-3" onclick="location.href='articulos.php'">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-boxes"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total de Articulos</span>
                <span class="info-box-number" id="lbl_articulos">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" title="Modificaciones realizadas">Articulos en Bajas.</span>
                <span class="info-box-number" id="lbl_bajas">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-university"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" title="Modificaciones realizadas">Articulos Patrimoniales.</span>
                <span class="info-box-number" id="lbl_patrimoniales">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-people-carry"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" title="Modificaciones realizadas">Articulos de Terceros.</span>
                <span class="info-box-number" id="lbl_terceros">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <!-- /.col -->
        </div>



        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <!-- <h5 class="card-title">Monthly Recap Report</h5> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-6" onclick="location.href='usuarios.php'">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Usuarios de sistema</span>
                              <span class="info-box-number" id="lbl_usuarios">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>

                         <div class="col-12 col-sm-6 col-md-6" onclick="location.href='custodio.php'">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-tie"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Custodios</span>
                              <span class="info-box-number" id="lbl_custodios">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>

                         <div class="col-12 col-sm-6 col-md-6" onclick="location.href='localizacion.php'">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-map-marked-alt"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Localizaciones / Emplazamiento</span>
                              <span class="info-box-number" id="lbl_localizaciones">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>

                    </div>

                  </div>
                  <!-- /.col -->
                  <div class="col-md-5">
                    <p class="text-center">
                      <strong>Porcentaje de articulos etiquetados</strong>
                    </p>

                    <div class="progress-group">
                      % de articulos etiquetados
                      <span class="float-right" id="lbl_porcen"><b>0</b>/0</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 0%" id="progres"></div>
                      </div>
                    </div>

                     <div class="row">
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 100%</span>
                          <h5 class="description-header" id="lbl_articulos1">0</h5>
                          <span class="description-text">Total Articulos</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-success" id="lbl_porce"><i class="fas fa-caret-up"></i> 0%</span>
                          <h5 class="description-header" id="lbl_etiqueta">0</h5>
                          <span class="description-text">Total etiquetados</span>
                        </div>
                      </div>
                    
                    </div>


                   
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Articulos desvinculados</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                        <!-- /.col -->
                        
                         <!-- <div class="col-12 col-sm-6 col-md-6" onclick="location.href='custodio.php'"> -->
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-tie"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Custodios</span>
                              <span class="info-box-number" id="lbl_custodios">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        <!-- </div> -->

                        
                    </div>

                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">                   
                     <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-map-marked-alt"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Localizaciones / Emplazamiento</span>
                              <span class="info-box-number" id="lbl_localizaciones">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                   
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

          <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Seguros</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col-md-5">
                     <p class="text-center">
                      <strong>Porcentaje de articulos asegurados</strong>
                    </p>
                     <div class="card card-danger">              
                      <div class="card-body">
                        <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>                  

                  <!-- 

                     <div class="row">
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 100%</span>
                          <h5 class="description-header" id="lbl_articulos1">0</h5>
                          <span class="description-text">Total Articulos</span>
                        </div>
                      </div>
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-success" id="lbl_porce"><i class="fas fa-caret-up"></i> 0%</span>
                          <h5 class="description-header" id="lbl_etiqueta">0</h5>
                          <span class="description-text">Total etiquetados</span>
                        </div>
                      </div>
                    
                    </div>
 -->

                   
                  </div>

                  <div class="col-md-7">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 col-sm-12 col-md-12">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-shield"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Numero de seguros</span>
                              <span class="info-box-number" id="lbl_num_seguros">0</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>

                  <!--        <div class="col-12 col-sm-6 col-md-6" onclick="location.href='custodio.php'">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shield-alt"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Articulos Asegurados</span>
                              <span class="info-box-number" id="lbl_custodios">0</span>
                            </div>
                          </div>
                        </div>  -->                    

                    </div>
                     <div class="row">
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-warning" id="lbl_porce_sin_seguro"><i class="fas fa-caret-left"></i>0%</span>
                          <h5 class="description-header" id="lbl_sin_seguro">0</h5>
                          <span class="description-text">Articulos sin seguro</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6 col-6">
                        <div class="description-block border-right">
                          <span class="description-percentage text-success" id="lbl_porce_asegurados"><i class="fas fa-caret-up"></i> 0%</span>
                          <h5 class="description-header" id="lbl_asgurados">0</h5>
                          <span class="description-text">Articulos Asegurados</span>
                        </div>
                      </div>
                       <div class="col-sm-12 col-12">
                        <div class="description-block border-right">
                          <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 100%</span>
                          <h5 class="description-header" id="lbl_articulos2">0</h5>
                          <span class="description-text">Total de articulos</span>
                        </div>
                      </div>
                    
                    </div>


                  </div>


                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

        <div class="row">
          <!-- <img src="../img/de_sistema/modulo_inventario1.gif" style="width: 100%"> -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

 
<?php include('./footer.php'); ?>


