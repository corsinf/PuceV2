
<div class="modal fade" id="modal_rango_fecha" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Rango fechas</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="" name="txt_new_subfamilia" id="txt_new_subfamilia" class="form-control form-control-sm">
        </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_vin_cus" onclick="">Generar informe</button>   
      </div>
    </div>
  </div>
</div><!-- /.container-fluid -->


<div class="modal fade" id="modal_notificacion" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Notificación</h3>
      </div>
      <div class="modal-body">
    <div class="row justify-content-center mt-3">
        <div class="col-auto">
            <div class=" text-center border-0" role="alert" id="contenedor_mensaje">
                <span id="lbl_mensaje"></span>
            </div>
        </div>
    </div>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_modal_ok">OK</button>   
      </div>
    </div>
  </div>
</div>






  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->

<script>
  // =====================================================
// VERSIÓN MEJORADA - Solo usando Bootstrap existente
// =====================================================

// =====================================================
// CÓDIGO CORREGIDO - Enviar contenido al contenedor correcto
// =====================================================

$(document).ready(function() {
    notificaciones();
});

function notificaciones() {
    $.ajax({
        url: '../controlador/notificacionesC.php?lista=true',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                let noti = response[0];
                let estado = noti.estado;
                let desde = new Date(noti.fecha_desde.date);
                let hasta = new Date(noti.fecha_hasta.date);
                let hoy = new Date();

                // Quitar hora para comparar solo fechas
                desde.setHours(0, 0, 0, 0);
                hasta.setHours(0, 0, 0, 0);
                hoy.setHours(0, 0, 0, 0);

                // Validar fechas y estado
                if (estado == 1 && hoy >= desde && hoy <= hasta) {
                    
                    // Extraer y formatear fecha
                    let fechaCorta = noti.fecha_hasta.date.split(' ')[0];
                    
                    // MENSAJE MEJORADO
                    let mensaje = `
                        <div class="text-center">
    <i class="fas fa-bell fa-3x text-dark mb-3"></i>
    <h5 class="text-dark fw-semibold mb-3">${noti.mensaje}</h5>
    <div class="border border-warning rounded p-3 bg-white shadow-sm d-inline-block">
      <i class="fas fa-calendar-day text-warning me-2"></i>
      <span class="fw-bold text-dark">Vence el:</span>
      <span class="text-dark">${fechaCorta}</span>
    </div>
  </div>
                    `;

                    // CAMBIO IMPORTANTE: Enviar al contenedor correcto
                    // En lugar de #lbl_mensaje, usar #contenedor_mensaje
                    $('#contenedor_mensaje').html(mensaje);

                    $('#modal_notificacion').modal('show');

                    // OK -> Ocultar y actualizar estado
                    $('#btn_modal_ok').off('click').on('click', function () {
                        $('#modal_notificacion').modal('hide');

                        // Llamada AJAX para actualizar el estado a 0
                        $.ajax({
                            url: '../controlador/notificacionesC.php?insertar=true',
                            type: 'POST',
                            data: { id: noti.id_notificacion },
                            success: function (resp) {
                                console.log('Estado actualizado a 0');
                            }
                        });
                    });
                }
            }
        }
    });
}



</script>


<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="../js/dashboard.js"></script> -->
</body>
</html>
