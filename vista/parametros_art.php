<?php include('./header.php'); ?>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Parametros de Articulo</h5>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="container-fluid">
      	<nav>
           <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-marca" role="tab"><i class="fa fa-clone"></i> Marca</a>
             <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-estado" role="tab"> <i class="fa fa-edit"></i>Estado</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-genero" role="tab"> <i class="fa fa-clipboard-list"></i> Genero</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-color" role="tab" > <i class="fa fa-palette"></i> Colores</a>
               <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-familia" role="tab" > <i class="fa fa-palette"></i> Familia / Sub Familia</a>
           </div>
         </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-marca" role="tabpanel" aria-labelledby="nav-home-tab">
            	<div class="container-iframe"> 
				  <iframe class="responsive-iframe" src="marcas.php"></iframe>
				</div>
            </div>
            <div class="tab-pane fade" id="nav-estado" role="tabpanel" aria-labelledby="nav-home-tab">
            	<div class="container-iframe"> 
				  <iframe class="responsive-iframe" src="estado.php"></iframe>
				</div>
            </div>
            <div class="tab-pane fade" id="nav-genero" role="tabpanel" aria-labelledby="nav-home-tab">
            	<div class="container-iframe"> 
				  <iframe class="responsive-iframe" src="genero.php"></iframe>
				</div>
            </div>
            <div class="tab-pane fade" id="nav-color" role="tabpanel" aria-labelledby="nav-home-tab">
            	<div class="container-iframe"> 
      				  <iframe class="responsive-iframe" src="colores.php"></iframe>
      				</div>
            </div>
             <div class="tab-pane fade" id="nav-familia" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="container-iframe"> 
                <iframe class="responsive-iframe" src="familias.php"></iframe>
              </div>
            </div>

                   

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php include('./footer.php'); ?>
