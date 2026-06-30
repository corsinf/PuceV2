<?php include('./header3.php');  $id = ''; if(isset($_GET['id'])){$id = $_GET['id'];} ?>
<script type="text/javascript">
	 $( document ).ready(function() {
    var art = '<?php echo $id;?>';
    if(art!='')
    {
    	cargar_tarjeta(art);
    }
  });

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
        	 $('.textarea').html(response[0].detalle);
        	 $('#txt_id_tarjeta').val(response[0].id_tarjeta);
        	console.log(response);

        }   

        }
    })
	
}
</script>

<div class="row">
	            <div class="card-body pad">
	            	<input type="hidden" name="txt_id_tarjeta" id="txt_id_tarjeta">
	              <div class="mb-3 textarea">
	              	<p>Edite tarjeta informativa<p>
	              </div>
	            </div>


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