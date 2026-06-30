<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Activos Fijos| PUCE</title>
  <link rel="icon" type="image/png" href="img/de_sistema/puce_logo.png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="js/sweetalert2.all.min.js"></script>
  <script type="text/javascript">    
  function consultar_datos()
  {
    var email=$('#email').val();
    if(email != '' )
    {
       var parametros = 
       {
         'email':email,
       } 
       $.ajax({
         data:  {parametros:parametros},
         url:   'controlador/loginC.php?reseteo=true',
         type:  'post',
         dataType: 'json',
         beforeSend: function () {   
              // var spiner = '<div class="text-center"><img src="img/de_sistema/loader_puce.gif" width="20px" height="20px"></div>'     
            $('#img_logo').attr('src','img/de_sistema/loader_puce.gif');
         },
           success:  function (response) {    
           if(response.respuesta==1)
	        {
	          Swal.fire('Reseteado','se envio un correo a '+response.mensaje+' con su nueva contraseña','success').then(function(){
	            location.href = 'login.php';
	          })
	        }else
	        {
	          $('#mensaje').text(response.mensaje)
	        } 

            $('#img_logo').attr('src','img/de_sistema/puce_logo.png');
         }
       });

    }else
    {
       Swal.fire( '','LLene todo los campos.','error');
    }
  }
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width:40%">
  <div class="login-logo">
    <!-- <a href="login.php"><img src="img/de_sistema/puce_logo.png" class="brand-image img-circle elevation-3"></a> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="row">
        <div class="col-sm-4">
          <br><img src="img/de_sistema/puce_logo.png" style="width:100%" id="img_logo">
        </div>
        <div class="col-sm-8">

           <p class="login-box-msg"><b>Reseteo de contraseña</b></p>
          <form action="../../index3.html" method="post">
            <div class="input-group mb-3">
              <input type="email" class="form-control" id="email" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="text-center" id="mensaje" style="color:red;"></div>            
            <div class="row">         
              <div class="col-12">
                <button type="button" class="btn btn-primary btn-block" onclick="consultar_datos()">Resetear</button>
              </div>
            </div>            
          </form>   
        </div>
      </div>
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>

</body>
</html>
