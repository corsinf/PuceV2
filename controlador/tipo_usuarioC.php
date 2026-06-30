<?php 
include('../db/codigos_globales.php');
include('../modelo/tipo_usuarioM.php');
include('../modelo/usuariosM.php');

if(isset($_SESSION['INICIO']))
{   
  @session_start();
}else
{
     session_start();
}

// include('../modelo/headerM.php');

$controlador = new tipo_usuarioC();
if(isset($_GET['lista_usuarios']))
{
	echo json_encode($controlador->lista_tipo_usuarios());
}
if(isset($_GET['lista_usuarios_drop']))
{
	echo json_encode($controlador->lista_tipo_usuarios_drop());
}
if(isset($_GET['lista_usuarios_asignados']))
{
	echo json_encode($controlador->lista_usuarios_asignados());
}

if(isset($_GET['modulos']))
{
	echo json_encode($controlador->lista_modulos());
}

if(isset($_GET['modulos_tabla']))
{
	echo json_encode($controlador->lista_modulos_tabla());
}

if(isset($_GET['accesos']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_modulos($parametros));
}
if(isset($_GET['guardar_tipo']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->add_tipo($parametros));
}
if(isset($_GET['accesos_guardar_edi']))
{
	$parametros = $_POST;
	echo json_encode($controlador->guardar_accesos_edi($parametros));
}

if(isset($_GET['cargar_usuarios']))
{
	$id = $_POST['id'];
	echo json_encode($controlador->usuarios_en_tipo($id));
}
if(isset($_GET['eliminar_tipo']))
{
	$id = $_POST['id'];
	echo json_encode($controlador->eliminar_tipo($id));
}
if(isset($_GET['eliminar_usuario_tipo']))
{
	$id = $_POST['id'];
	echo json_encode($controlador->eliminar_usuario_tipo($id));
}

if(isset($_GET['accesos_asignados']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->accesos_asignados($parametros));
}
if(isset($_GET['guardar_modulos']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->guardar_modulos($parametros));
}
if(isset($_GET['guardar_en_perfil']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->guardar_en_perfil($parametros));
}
if(isset($_GET['lista_paginas']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_paginas($parametros));
}
if(isset($_GET['lista_usuarios_perfil_accesos']))
{
	$tipo = $_POST['tipo'];
	echo json_encode($controlador->usuarios_en_tipo_accesos($tipo));
}


class tipo_usuarioC
{
	private $modelo;
	private $pagina;
	private $global;
	private $pdf;
	private $header;
	private $usuarios;

	
	function __construct()
	{
		$this->modelo = new tipo_usuarioM();
		$this->pagina = new codigos_globales();
		$this->usuario = new usuariosM();
		// $this->header = new headerM();
		// $this->pagina->registrar_pagina_creada('../vista/tipo_usuario.php','Tipo usuario y accesos','3','estado');
	}


	function lista_tipo_usuarios()
	{
		$datos = $this->modelo->lista_tipo_usuario();

		// print_r($datos);die();
		$html='';
		foreach ($datos as $key => $value) {
			if($value['nombre']=='DBA' )
			{
				if($_SESSION['INICIO']['TIPO']=='DBA')
				{
					$html.='<tr>
					<td><input type="text" class="form-control form-control-sm" id="txt_tipo_usuario_'.$value['id'].'" name="txt_tipo_usuario_'.$value['id'].'"  value="'.$value['nombre'].'" /></td>
					<td>
					<button class="btn btn-sm btn-primary" onclick="add_tipo('.$value['id'].')"><i class="fa fa-save"></i></button>
					<button class="btn btn-sm btn-danger" onclick="eliminar_tipo('.$value['id'].')"><i class="fa fa-trash"></i></button>
					</td>
					</tr>';
				}
			}else
			{
				$html.='<tr>
				<td><input type="text" class="form-control form-control-sm" id="txt_tipo_usuario_'.$value['id'].'" name="txt_tipo_usuario_'.$value['id'].'"  value="'.$value['nombre'].'" /></td>
				<td>
				<button class="btn btn-sm btn-primary" onclick="add_tipo('.$value['id'].')"><i class="fa fa-save"></i></button>
				<button class="btn btn-sm btn-danger" onclick="eliminar_tipo('.$value['id'].')"><i class="fa fa-trash"></i></button>
				</td>
				</tr>';
			}
		}
		return $html;
	}


	function lista_tipo_usuarios_drop()
	{
		$datos = $this->modelo->lista_tipo_usuario();

		// print_r($datos);die();
		$html='';
		foreach ($datos as $key => $value) {
			if($value['nombre']=='DBA')
			{
				if($_SESSION['INICIO']['TIPO']=='DBA')
				{
					$html.='
					<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
				}
			}else
			{
				$html.='
				<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
			}
		}
		return $html;
	}

	function lista_usuarios_asignados()
	{
		$datos = $this->modelo->lista_tipo_usuario();

		// print_r($datos);die();
		$html='';
		foreach ($datos as $key => $value) {
		$usuarios = $this->usuario->perfiles_asignados($id=false,$query=false,$value['id']);
		if($value['nombre']=='DBA')
		{
			if($_SESSION['INICIO']['TIPO']=='DBA')
			{
					$html.='<div class="col-md-6">
			            <div class="card card-secondary collapsed-card">
			             <div class="card-header">
			                <h3 class="card-title">'.$value['nombre'].'</h3>
			                <div class="card-tools">
			                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
			                  <span data-toggle="tooltip" title="3 New Messages" class="badge bg-default">Numero de usuarios '.count($usuarios).'</span>
			                  <i class="fas fa-plus"></i>
			                  </button>                  
			                </div>
			              </div>
			              <!-- /.card-header -->
			              <div class="card-body" style="display: none;">
			                <table class="table table-hover">
			                  <thead>
			                    <th>Usuario</th>
			                    <th></th>
			                  </thead>
			                  <tbody>';
			                  foreach ($usuarios as $key => $value) {
			                  	$html.='<tr>
			                      <td>'.$value['nom'].'</td>                      
			                      <td><button class="btn btn-xs btn-danger" "eliminar_usuario_tipo('.$value['ID'].')"><i class="fa fa-trash"></i> </button></td>
			                    </tr>';
			                  }                    
			          $html.='</tbody>
			                </table>
			              </div>
			              <!-- /.card-body -->
			            </div>
			            <!-- /.card -->
			          </div>';
        }
      }else
      {
      	$html.='<div class="col-md-6">
          <div class="card card-secondary collapsed-card">
           <div class="card-header">
              <h3 class="card-title">'.$value['nombre'].'</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <span data-toggle="tooltip" title="3 New Messages" class="badge bg-default">Numero de usuarios '.count($usuarios).'</span>
                <i class="fas fa-plus"></i>
                </button>                  
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: none;">
              <table class="table table-hover">
                <thead>
                  <th>Usuario</th>
                  <th></th>
                </thead>
                <tbody>';
                foreach ($usuarios as $key => $value) {
                	$html.='<tr>
                    <td>'.$value['nom'].'</td>                      
                    <td><button class="btn btn-xs btn-danger" onclick="eliminar_usuario_tipo('.$value['ID'].')"><i class="fa fa-trash"></i> </button></td>
                  </tr>';
                }                    
        $html.='</tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>';
      }
		}
		return $html;
	}





	function lista_modulos($tipo= false)
	{
		if($tipo==false){$tipo['tipo']=false;}
		$datos= $this->modelo->lista_modulos();
		$tr ='<option value="">Todos</option>';
		foreach ($datos as $key => $value) {
			$tr.='<option value="'.$value['id'].'">'.$value['modulo'].'</option>';
		}
		return $tr;
	
	}

		function lista_modulos_tabla($tipo= false)
	{
		if($tipo==false){$tipo['tipo']=false;}
		$datos= $this->modelo->lista_modulos();
		$tr ='';
		foreach ($datos as $key => $value) {
			$s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';$s13='';
			$icon = explode('"', $value['icono']);
			if(isset($icon[1]))
			{
				// print_r($value['modulo'].'-');
			switch ($icon[1]) {
				case 'nav-icon fas fa-home':
					  $s1 = 'selected';
					break;
					case 'far fa-circle nav-icon':
					  $s2 = 'selected';
					break;
					case 'nav-icon fas fa-th':
					  $s3 = 'selected';
					break;
					case 'nav-icon fas fa-copy':
					  $s4 = 'selected';
					break;
					case 'nav-icon fa fa-arrow-circle-down':
					  $s5 = 'selected';
					break;
					case 'nav-icon fas fa-database':
					  $s6 = 'selected';
					break;
					case 'nav-icon fas fa-tag':
					  $s7 = 'selected';
					break;
					case 'nav-icon fas fa-money-bill':
					  $s8 = 'selected';
					break;
					case 'nav-icon fas fa-file-invoice':
					  $s9 = 'selected';
					break;
					case 'nav-icon fas fa-user':
					  $s10 = 'selected';
					break;
					case 'nav-icon fa fa-arrow-circle-up':
					  $s11 = 'selected';
					break;
					case 'nav-icon fas fa-cogs':
					  $s12 = 'selected';
					break;
					case 'nav-icon fas fa-wrench':
					  $s13 = 'selected';
					break;
			}
		}

			$tr.='
			<tr>
			<td><input name="txt_modulo'.$value['id'].'" id="txt_modulo'.$value['id'].'" value="'.$value['modulo'].'" class="form-control form-control-sm"></td>
			<td><input name="txt_detalle'.$value['id'].'" id="txt_detalle'.$value['id'].'" value="'.$value['detalle'].'" class="form-control form-control-sm"></td>
			<td>
			 <select class="fa" id="ddl_icono'.$value['id'].'" name="ddl_icono'.$value['id'].'"> 
          <option value="<i class=\'far fa-circle nav-icon\'></i>"> Icono</option>
          <option '.$s1.' class="fa" value="<i class=\'nav-icon fas fa-home\'></i>"> &#xf015;</option>
          <option '.$s2.' class="fa" value="<i class=\'far fa-circle nav-icon\'></i>"> &#xf111;</option>
          <option '.$s3.' class="fa" value="<i class=\'nav-icon fas fa-th\'></i>"> &#xf00a;</option>
          <option '.$s4.' class="fa" value="<i class=\'nav-icon fas fa-copy\'></i>"> &#xf0c5;</option>
          <option '.$s5.' class="fa" value="<i class=\'nav-icon fa fa-arrow-circle-down\'></i>"> &#xf0ab;</option>
          <option '.$s6.' class="fa" value="<i class=\'nav-icon fas fa-database\'></i>"> &#xf1c0;</option>
          <option '.$s7.' class="fa" value="<i class=\'nav-icon fas fa-tag\'></i>"> &#xf02b;</option>
          <option '.$s8.' class="fa" value="<i class=\'nav-icon fas fa-money-bill\'></i>"> &#xf0d6;</option>
          <option '.$s9.' class="fa" value="<i class=\'nav-icon fas fa-file-invoice\'></i>"> &#xf570;</option>
          <option '.$s10.'class="fa" value="<i class=\'nav-icon fas fa-user\'></i>"> &#xf007;</option>
          <option '.$s11.'class="fa" value="<i class=\'nav-icon fas fa-cogs\'></i>"> &#xf085;</option>
          <option '.$s12.'class="fa" value="<i class=\'nav-icon fa fa-arrow-circle-up\'></i>"> &#xf0aa;</option>
          <option '.$s13.'class="fa" value="<i class=\'nav-icon fas fa-wrench\'></i>"> &#xf0ad;</option>

      </select> 
			</td>
			<td><button class="btn bt-sm btn-primary" onclick="guardar_modulos(\''.$value['id'].'\')"><i class="fa fa-save"></i></button>
					<button class="btn bt-sm btn-danger" onclick="eliminar_modulos(\''.$value['id'].'\')"><i class="fa fa-trash"></i></button>
			</td>
			</tr>';
		}
		return $tr;
	
	}

	function paginas($modulo=false,$id_modulo=false,$tipo=false)
	{
		$paginas = $this->modelo->lista_paginas(false,$id_modulo);
		$div='<div class="tab-pane fade" id="'.$modulo.'" role="tabpanel" aria-labelledby="home-tab">
                  <table class="table table-bordered table table-sm">
                    <thead>
                      <th><input type="checkbox" id="rbl_all_'.$id_modulo.'" name="rbl_all_'.$id_modulo.'"/></th>
                      <th>Pagina</th>
                      <th>Detalle</th>
                      <tbody>';
		foreach ($paginas as $key => $value) {
			$rep =0; 
			// $this->header->accesos($value['id'],$tipo);
			if($rep==1)
			{
			$div.='<tr>
			        <td><input type="checkbox" name="rbl_'.$value['id'].'_'.$modulo.'" checked="" /></td>
			        <td>'.$value['pagina'].'</td>
                    <td>'.$value['detalle'].'</td>
                   </tr>';
            }else
            {
            	$div.='<tr>
			        <td><input type="checkbox" name="rbl_'.$value['id'].'_'.$modulo.'" /></td>
			        <td>'.$value['pagina'].'</td>
                    <td>'.$value['detalle'].'</td>
                   </tr>';

            }
		}
		$div.='</tbody></thead></table></div>';
		return $div;

	}

	function guardar_accesos_edi($parametros)
	{
		// print_r($parametros);die();
		$ver = 0;	$edi =0;$eli =0;
		if($parametros['ver']=='true'){ $ver = 1;}
		if($parametros['edi']=='true'){ $edi = 1;} 
		if($parametros['eli']=='true'){ $eli = 1;}

		if($parametros['usuario']=='')
		{
			 $usuario = $this->modelo->lista_usuarios_en_tipo($parametros['perfil'],false);
		}else
		{
			$usuario[0]['ID'] = $parametros['usuario'];
		}

		foreach ($usuario as $key => $value) {

			// print_r($value);die();
				
			$dato = $this->modelo->existe_acceso($parametros['pag'],$value['ID']);
			if(count($dato)>0)
			{
				$where[0]['campo'] = 'id_accesos';
				$where[0]['dato'] = $dato[0]['id_accesos'];

				$datos[0]['campo'] = 'Ver';
				$datos[0]['dato'] = $ver;
				$datos[1]['campo'] = 'editar';
				$datos[1]['dato'] = $edi;
				$datos[2]['campo'] = 'eliminar';
				$datos[2]['dato'] = $eli;
				$this->modelo->update('ACCESOS',$datos,$where);
			}else
			{
				$datos[0]['campo'] = 'Ver';
				$datos[0]['dato'] = $ver;
				$datos[1]['campo'] = 'editar';
				$datos[1]['dato'] = $edi;
				$datos[2]['campo'] = 'eliminar';
				$datos[2]['dato'] = $eli;
				$datos[3]['campo'] = 'id_paginas';
				$datos[3]['dato'] = $parametros['pag'];
				$datos[4]['campo'] = 'id_tipo_usu';
				$datos[4]['dato'] = $value['ID'];

				 $this->modelo->guardar($datos,'ACCESOS')	;		
			}
		}

		return 1;

		// print_r($parametros);die();
	}

	function add_tipo($parametros)
	{
		if($parametros['id']=='')
		{
		   $acceso[0]['campo'] = 'DESCRIPCION';
		   $acceso[0]['dato'] =strtoupper($parametros['tipo']);
		   return $this->modelo->guardar($acceso,'TIPO_USUARIO');		
	    }else
	    {
	    	 $acceso[0]['campo'] = 'DESCRIPCION';
		     $acceso[0]['dato'] =strtoupper($parametros['tipo']);
		     $where [0]['campo']='ID_TIPO';
		     $where [0]['dato']= $parametros['id'];
		    return $this->modelo->update('tipo_usuario',$acceso,$where);	

	    }
		
	}
	function usuarios_en_tipo($id)
	{
		$datos = $this->modelo->lista_usuarios_en_tipo($id);
		$cabecera = array('Nombre','Email','Usuario','password');
		$tabla = $this->pagina->tabla_generica($datos,$cabecera);

		return $tabla;

	}
	function usuarios_en_tipo_accesos($id)
	{
		// print_r($id);die();
		$datos = $this->modelo->lista_usuarios_en_tipo($id);		
		// print_r($datos);die();
		return $datos;

	}

	function eliminar_tipo($id)
	{
		$resp = $this->modelo->eliminar_tipo($id);
		return $resp;

	}

	function eliminar_usuario_tipo($id)
	{
		$resp = $this->modelo->eliminar_usuario_tipo($id);
		return $resp;

	}
	function accesos_asignados($parametros)
	{
		// $perfil = $this->modelo->lista_usuarios_en_tipo(false,$parametros['usuario']);
		// 	print_r($perfil);die();
		if($parametros['usuario']!='T')
		{
			return $this->modelo->lista_accesos_asignados($parametros['usuario']);
		}else
		{
			return array();
		}
	}
	function guardar_modulos($parametros)
	{
	     $resp = $this->modelo->eliminar_all_modulos($parametros['tipo']);
		if($resp==1)
		{
			foreach ($parametros['modulos'] as $key => $value) {
				$datos[0]['campo']='id_modulos';
				$datos[0]['dato'] =$value;
				$datos[1]['campo']='id_tipo_usuario';
				$datos[1]['dato'] =$parametros['tipo'];
				$this->modelo->guardar($datos,'accesos');
			}
			return 1;
		}

	}

	function guardar_en_perfil($parametros)
	{
		
		    $resp = $this->usuario->existe_usuario_perfil($parametros['tipo'],$parametros['usuario']);
		    if($resp==-1)
		    {
				$datos[0]['campo']='ID_USUARIO';
				$datos[0]['dato'] =$parametros['usuario'];
				$datos[1]['campo']='ID_TIPO_USUARIO';
				$datos[1]['dato'] =$parametros['tipo'];
			  return 	$this->modelo->guardar($datos,'USUARIO_TIPO_USUARIO');
			 }else
			 {
			 	return 2;
			 }	
	}

	function lista_paginas($parametros)
	{
		 $query = $parametros['query'];
		 $modulo = $parametros['modulo'];
		 $datos = $this->modelo->paginas($query,$modulo);
		 $tr = '';
		 foreach ($datos as $key => $value) {
		 	$tr.='<tr>
		 	<td>'.$value['nombre_pagina'].'</td>
		 	<td>'.$value['detalle_pagina'].'</td>
		 	<td>'.$value['estado_pagina'].'</td>
		 	<td>'.$value['nombre_modulo'].'</td>
		 	<td>'.$value['default_pag'].'</td>
		 	<td width="15px" class="text-center"><input type="checkbox" name="ver_'.$value['id_paginas'].'" id="ver_'.$value['id_paginas'].'" checked onclick="guardar_accesos_edi(\''.$value['id_paginas'].'\')"></td>
      <td width="15px" class="text-center"><input type="checkbox" onclick="guardar_accesos_edi(\''.$value['id_paginas'].'\')" name="edi_'.$value['id_paginas'].'" id="edi_'.$value['id_paginas'].'"></td>
      <td width="15px" class="text-center"><input type="checkbox" onclick="guardar_accesos_edi(\''.$value['id_paginas'].'\')" name="eli_'.$value['id_paginas'].'" id="eli_'.$value['id_paginas'].'"></td>
		 	</tr>';
		 }
		 return $tr;
	}
	
}
?>