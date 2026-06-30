<?php @session_start(); ?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activos Fijos| PUCE</title>
  <link rel="icon" type="image/png" href="../img/de_sistema/puce_logo.png" />

  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="../css/select2.min.css">
  <script src="../js/select2.min.js"></script>
  <script src="../js/sweetalert2.all.min.js"></script>
  <script src="../js/informes.js"></script>
  <script src="../js/codigos_globales.js"></script>
   <script type="text/javascript">
    $( document ).ready(function() {
        // restriccion();

    });
     function cerrar_session()
  {
    
       $.ajax({
         // data:  {parametros:parametros},
         url:   '../controlador/loginC.php?cerrar=true',
         type:  'post',
         dataType: 'json',
         /*beforeSend: function () {   
              var spiner = '<div class="text-center"><img src="../../img/gif/proce.gif" width="100" height="100"></div>'     
            $('#tabla_').html(spiner);
         },*/
           success:  function (response) {  
           if (response==1) 
           {
            console.log(response);
             window.location.href = "../login.php";
           } 
          } 
          
       });
  }

  </script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
 
<div class="wrapper">
   <input type="hidden" name="" id="dba">
  <input type="hidden" name="" id="ver">
  <input type="hidden" name="" id="editar">
  <input type="hidden" name="" id="eliminar">