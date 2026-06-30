<?php 
include('../modelo/articulosM.php');
include('../db/codigos_globales.php');
/**
 * 
 */
$controlador = new articulosC();
if(isset($_GET['lista']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_articulos($parametros));
}

if(isset($_GET['lista_kit']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_kit($parametros));
}

if(isset($_GET['guardar_kit']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->guardar_kit($parametros));
}

if(isset($_GET['guardar_it']))
{
	$parametros = $_POST;
	echo json_encode($controlador->guardar_it($parametros));
}

if(isset($_GET['delete_kit']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->delete_kit($parametros));
}

if(isset($_GET['lista_patrimoniales']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_articulos_patrimoniales($parametros));
}
if(isset($_GET['meses']))
{
	echo json_encode($controlador->lista_meses());
}
if(isset($_GET['lista_imprimir']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_articulos_impri($parametros));
}
if(isset($_GET['lista_imprimir_']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->lista_articulos_impri_num($parametros));
}
if(isset($_GET['imprimir_tags_bloque']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->imprimir_tags_bloque($parametros));
}
if(isset($_GET['reimprimir_tags_bloque']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->reimprimir_tags_bloque($parametros));
}
if(isset($_GET['buscar']))
{
	echo json_encode($controlador->buscar_articulos($_POST['buscar']));
}
if(isset($_GET['insertar']))
{
	echo json_encode($controlador->insertar_editar($_POST['parametros']));
}
if(isset($_GET['eliminar']))
{
	echo json_encode($controlador->eliminar($_POST['id']));
}
if(isset($_GET['paginacion']))
{
	echo json_encode($controlador->lista_articulos_pag());
}
if(isset($_GET['vaciar']))
{
	echo json_encode($controlador->vaciar_tag());
}
if(isset($_GET['articulos_ddl']))
{
	$query = '';
	if(isset($_GET['q']))
	{
		$query = $_GET['q'];
	}
	echo json_encode($controlador->articulos_ddl($query));
}

if(isset($_GET['articulos_especiales']))
{
	$parametros = $_POST['parametros'];
	echo json_encode($controlador->articulos_especiales($parametros));
}



class articulosC
{
	private $modelo;
	private $cod_global;
	
	function __construct()
	{
		$this->modelo = new articulosM();
		$this->cod_global = new codigos_globales();
		
	}
	function lista_articulos($parametros)
	{
		// print_r($parametros);die();
		$query = $parametros['query'];		
		$masivo_loc = $parametros['masivo_lo'];
		$masivo_cus = $parametros['masivo_cu'];		

		$loc = $parametros['localizacion'];
		if($parametros['masivo_lo']==1)
		{
			$lista_loc = $parametros['empla_masivo'];
			$lista = ''; 
			foreach ($lista_loc as $key => $value) {
				$lista.= "'".$value."',";
			}
			$lista = substr($lista,0,-1);
			// print_r($lista);die();
			$loc = $lista;
		}
		$cus = $parametros['custodio'];
		if($parametros['masivo_cu']==1)
		{
			$lista_cus = $parametros['custodio_masivo'];
			$lista = ''; 
			foreach ($lista_cus as $key => $value) {
				$lista.= "'".$value."',";
			}
			$lista = substr($lista,0,-1);
			// print_r($lista);die();
			$cus = $lista;
		}
		$pag = $parametros['pag'];
		$masivo = $parametros['masivo'];
		if (strpos($query, ',') !== false) {
   
			$masivo = 1;
		}
		if(isset($parametros['query2']) && $parametros['query2']!='')
		{
			if($parametros['masivo']==1)
			{
				$query = preg_replace("[\n|\r|\n\r| ]", "-",$parametros['query2']);
				$query = explode('-',$query);
				$query = array_filter($query);
				$query2 = '';
				foreach ($query as $key => $value) {
					$query2.= "'".$value."',";
				}
				$query2 = substr($query2,0,-1);
				$query = $query2;
			}
		}
		if(isset($parametros['lista']))
		{
			$_SESSION['INICIO']['LISTA_ART'] = $parametros['lista'];
		}
		$exacto=0;
		if(isset($parametros['exacto']) && $parametros['exacto']=='true')
		{
		 $exacto = 1;
		}
		$asset=0;
		if(isset($parametros['asset']) && $parametros['asset']=='true')
		{
			$asset = 1;
		}
		if(isset($parametros['asset_org']) && $parametros['asset_org']=='true')
		{
			$asset = 2;
		}
		if(isset($parametros['rfid']) && $parametros['rfid']=='true')
		{
			$asset = 0;
		}
		// $multiple = 0;
		// if(isset($parametros['multiple']) && $parametros['multiple']=='true' && $query!='')
		// {
		// 	$multiple = 1;
		// }

		// print_r($query);die();
		$datos = $this->modelo->cantidad_registros($query,$loc,$cus,false,false,$exacto,$asset,false,false,false,false,false,$masivo,$masivo_cus,$masivo_loc);
		// print_r($datos);die();
		$total_reg = $datos[0]['numreg'];
		if($total_reg >25)
		{
		   $datos = $this->modelo->lista_articulos($query,$loc,$cus,$pag,false,$exacto,$asset,false,false,false,false,false,$masivo,$masivo_cus,$masivo_loc);
		}else
		{

		   $datos = $this->modelo->lista_articulos($query,$loc,$cus,false,false,$exacto,$asset,false,false,false,false,false,$masivo,$masivo_cus,$masivo_loc);
		}
		
		//$datos = array_map(array($this->cod_global, 'transformar_array_encode'), $datos);
		$datos2 = array('datos'=>$datos,'cant'=>$total_reg,'busqueda'=>$query);

		// print_r($datos2);die();
		return $datos2;
	}

	function lista_kit($parametros)
	{
		$datos2 = $this->modelo->lista_kit($parametros['activo']);
		return $datos2;
	}

	function delete_kit($parametros)
	{
		// print_r($parametros);die();
		$datos[0]['campo'] = 'id_plantilla';
		$datos[0]['dato'] = $parametros['id'];
		
		return $this->modelo->eliminar($datos,'PLANTILLA_MASIVA');

	}

	function guardar_kit($parametros)
	{
		// print_r($parametros);die();
		$datos[0]['campo'] = 'KIT';
		$datos[0]['dato'] = $parametros['activo'];
		$datos[1]['campo'] = 'DESCRIPT';
		$datos[1]['dato'] = $parametros['nombre'];
		$datos[2]['campo'] = 'CARACTERISTICA';
		$datos[2]['dato'] = $parametros['identificador'];
		$datos[3]['campo'] = 'OBSERVACION';
		$datos[3]['dato'] = $parametros['observacion'];
		$datos[4]['campo'] = 'ACTIVO';  // NO ES UN ACTIVO 
		$datos[4]['dato'] = '0';
		/*$datos[5]['campo'] = 'KIT';
		$datos[5]['dato'] = '1';*/

		return $this->modelo->insertar($datos,$tabla='PLANTILLA_MASIVA');

	}

	function guardar_it($parametros)
	{
		$datos[0]['campo'] = 'SISTEMA_OP';
		$datos[0]['dato'] = $parametros['txt_sistema_op'];
		$datos[1]['campo'] = 'ARQUITECTURA';
		$datos[1]['dato'] = $parametros['txt_arquitectura'];
		$datos[2]['campo'] = 'KERNEL';
		$datos[2]['dato'] = $parametros['txt_kernel'];
		$datos[3]['campo'] = 'PRODUCTO_ID';
		$datos[3]['dato'] = $parametros['txt_producto_id'];
		$datos[4]['campo'] = 'VERSION'; 
		$datos[4]['dato'] = $parametros['txt_version'];
		$datos[5]['campo'] = 'SERVICE_PACK';
		$datos[5]['dato'] = $parametros['txt_service_pack'];
		$datos[6]['campo'] = 'EDICION';
		$datos[6]['dato'] = $parametros['txt_edicion'];
		$datos[7]['campo'] = 'IT';
		$datos[7]['dato'] = '1';

		$where[0]['campo'] = 'id_plantilla';
		$where[0]['dato'] = $parametros['id'];

		return $this->modelo->update($tabla='PLANTILLA_MASIVA',$datos,$where);

	}

	function lista_articulos_patrimoniales($parametros)
	{
		// print_r($parametros);die();
		$query = $parametros['query'];
		$loc = $parametros['localizacion'];
		$cus = $parametros['custodio'];
		$pag = $parametros['pag'];
		$exacto=false;
		if(isset($parametros['exacto']))
		{
		 $exacto = $parametros['exacto'];
		}
		$asset='';
		if(isset($parametros['asset']))
		{
			$asset = $parametros['asset'];
		}
		$asset_org = '';
		if(isset($parametros['asset_org']))
		{
			$asset_org = $parametros['asset_org'];
		}

		if($exacto == 'true')
		{
			$exacto  = true;
		}else
		{
			$exacto = false;
		}
		if($asset == 'true')
		{
			$asset  = true;
		}else
		{
			$asset = false;
		}
		
		$datos = $this->modelo->cantidad_registros_patrimoniales($query,$loc,$cus);
		$total_reg = $datos[0]['numreg'];
		if($total_reg >25)
		{			
		   $datos = $this->modelo->lista_articulos($query,$loc,$cus,$pag,false,$exacto,$asset,false,false,1);
		}else
		{
			$datos = $this->modelo->lista_articulos($query,$loc,$cus,false,false,$exacto,$asset,false,false,1);
		}
		
		//$datos = array_map(array($this->cod_global, 'transformar_array_encode'), $datos);
		$datos2 = array('datos'=>$datos,'cant'=>$total_reg);

		// print_r($datos2);die();
		return $datos2;
	}

	function lista_articulos_impri($parametros)
	{
		$v = $this->modelo->existe_datos();	
		if($v == -1)
		{
		// print_r('expression');die();

		$query = $parametros['query'];
		$loc = $parametros['localizacion'];
		$cus = $parametros['custodio'];
		$pag = $parametros['pag'];
		$datos = $this->modelo->lista_articulos($query,$loc,$cus,$pag);
		// print_r($datos);die();

	  	$link = str_replace('impresiones_tag.php','', $_SERVER['HTTP_REFERER']);
		// foreach ($datos as $key => $value) {
		// 	$rand = $this->generarCodigo(8);
		// 	$rand = "5002000100070028".$rand;
		// 	if($this->modelo->existe($rand)==-1)
		// 	{
		// 		$datoss[0]['campo']='TAG_Unique';
		// 		$datoss[0]['dato'] =$rand;
		// 		$where[0]['campo']='ID_ASSET';
		// 		$where[0]['dato']= $value['ID_ASSET'];
		// 		$this->modelo->editar_asser($datoss,$where);
		// 		$datoss2[0]['campo']='RFID';
		// 		$datoss2[0]['dato']=$rand;
		// 		$datoss2[1]['campo']='SERIE';
		// 		$datoss2[1]['dato'] = $value['tag'];
		//   		$datoss2[2]['campo']='DATO_QR';
		// 		$datoss2[2]['dato']=$link."detalle_activo.php?id=".$value['RFID'];
		// 		$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');
		// 	}else
		// 	{
		// 		https://corsinf.com:447/pucev2/vista/detalle_activo.php?id=500200010007002800848680


				// $rand = $this->generarCodigo(8);
				// $rand = "5002000100070028".$rand;
				// $datoss[0]['campo']='TAG_Unique';
				// $datoss[0]['dato'] =$rand;
				// $where[0]['campo']='ID_ASSET';
				// $where[0]['dato']= $value['ID_ASSET'];
				// $this->modelo->editar_asser($datoss,$where);
	  	if(count($datos)>0)
	  	{
				$datoss2[0]['campo']='RFID';
				$datoss2[0]['dato']=$datos[0]['RFID'];
				$datoss2[1]['campo']='SERIE';
				$datoss2[1]['dato'] = $datos[0]['tag'];
		  		$datoss2[2]['campo']='DATO_QR';
				$datoss2[2]['dato']=$link."detalle_activo.php?id=".$datos[0]['RFID'];
		  		$datoss2[3]['campo']='ID_USUARIO';
				$datoss2[3]['dato']=$_SESSION['INICIO']['ID_USUARIO'];
				$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');
		}

			// }
		// }

		$d = 1;
		return $d;
	}else
	{
		$d=2;
		return $d;
	}
	}



	function lista_articulos_impri_num($parametros)
	{

		$log[0]['campo']='usuario';
  		$log[0]['dato']=$_SESSION['INICIO']['USUARIO'];
  		$log[1]['campo']='accion';
		$log[1]['dato']='Impresion masiva (N) etiquetas';
  		$log[2]['campo']='fecha';
		$log[2]['dato']=date('Y-m-d');


	   // print_r($parametros);die();
		$v = $this->modelo->existe_datos();
		$RFID_nuevos = array();	
		$datoss2 = array();
		if($v == -1)
		{
		$numero = $parametros['numero'];
		for ($i=1; $i < $numero+1; $i++){ ;
			$generar = 1;
			// $rand = "500200010007002800".$rand;
				while ($generar==1) {
					$rand = $this->generarCodigo(6);
					$rand = "500200010007002800".$rand;
					$exis = $this->modelo->existe_RFID($rand); 
					if($exis==-1){
						$exis = $this->modelo->existe_RFID_impreso($rand); 
					}
					if($exis==-1)
					{
						$generar = 0;
						foreach ($RFID_nuevos as $key => $value) {
							if($value==$rand)
							{
								$generar = 1;
								break;
							}
						}
						if($generar==0)
						{
							array_push($RFID_nuevos,$rand);
						}
					}
				}
	  }


	  	$link = str_replace('impresiones_tag.php','', $_SERVER['HTTP_REFERER']);

	  // print_r($RFID_nuevos);die();
	  foreach ($RFID_nuevos as $key => $value) {
	  		$datoss2[0]['campo']='RFID';
			$datoss2[0]['dato']=$value;
	  		$datoss2[1]['campo']='DATO_QR';
			$datoss2[1]['dato']=$link."detalle_activo.php?id=".$value;
	  		$datoss2[2]['campo']='NOMBRE_BIEN';
			$datoss2[2]['dato']="CONTROL DE ACTIVOS";			
	  		$datoss2[3]['campo']='ID_USUARIO';
			$datoss2[3]['dato']=$_SESSION['INICIO']['ID_USUARIO'];
			$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');

	  		$datoss3[0]['campo']='Codigo';
			$datoss3[0]['dato']=$value;
			$this->modelo->insertar($datoss3,'RFID_IMPRESOS');

			$log[3]['campo']='detalle';
			$log[3]['dato']='Impresion masiva RFID:'.$value.'';
			$this->modelo->insertar($log,'log_activos');
				
	  }

		$d = 1;
		return $d;
	
	}else
	{



		$d=2;
		return $d;
	}
}



// 	function lista_articulos_impri_num($parametros)
// 	{
// 	   // print_r($parametros);die();
// 		$v = $this->modelo->existe_datos();	
// 		$datoss2 = array();
// 		if($v == -1)
// 		{

// 		$numero = $parametros['numero'];
// 		for ($i=1; $i < $numero+1; $i++) { 
// 			$rand = $this->generarCodigo(6);
// 			$rand = "500200010007002800".$rand;
// 			if($this->modelo->existe($rand)==-1)
// 			{
// 				$datoss2[0]['campo']='RFID';
// 				$datoss2[0]['dato']=$rand;

// 			}else
// 			{
// 				$rand = $this->generarCodigo(6);
// 			    $rand = "500200010007002800".$rand;
// 			    $datoss2[0]['campo']='RFID';
// 				$datoss2[0]['dato']=$rand;		

// 			}

// 		$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');

// 	  }
//   //print_r($datoss2);die();

// 		$d = 1;
// 		return $d;
	
// 	}else
// 	{
// 		$d=2;
// 		return $d;
// 	}
// }


function imprimir_tags_bloque($parametros)
	{
		// print_r($_SESSION['INICIO']);die();

		$log[0]['campo']='usuario';
  		$log[0]['dato']=$_SESSION['INICIO']['USUARIO'];
  		$log[1]['campo']='accion';
		$log[1]['dato']='Impresion en bloque';
  		$log[2]['campo']='fecha';
		$log[2]['dato']=date('Y-m-d');


	   $tags = preg_replace("/^\h*\v+/m", "",$parametros['tags']);
	   $tags_assets = explode("\n", $tags);
	   $tags_assets = array_filter($tags_assets, 'strlen');

	   $msj = '';

		$v = $this->modelo->existe_datos();
		$RFID_nuevos = array();	
		$datoss2 = array();
		if($v == -1)
		{

		foreach ($tags_assets as $key => $value) {
			$generar = 1;
			// $rand = "500200010007002800".$rand;
			$asset_exist = $this->modelo->asset($value);
			$asset_exist_ = $this->modelo->assetExiste($value);
			$arti_exist = $this->modelo->plantilla_masivaxTagSerie($value);

			// print_r($asset_exist);print_r($arti_exist);die();
			if($asset_exist_==1 && $arti_exist==-1)
			{
				// print_r('INGRESA');die();
				$this->modelo->deleteAssetyRFIDIMPRESO($value);
				$asset_exist = -1;
			}
			// print_r('expression');die();
			if($asset_exist==-1)
			{
				while ($generar==1) {
					$rand = $this->generarCodigo(6);
					$rand = "500200010007002800".$rand;
					$exis = $this->modelo->existe_RFID($rand); 
					if($exis==-1){
						$exis = $this->modelo->existe_RFID_impreso($rand); 
					}
					if($exis==-1)
					{
						$generar = 0;
						foreach ($RFID_nuevos as $key => $value2) {
							if($value2==$rand)
							{
								$generar = 1;
								break;
							}
						}
						// if($generar==0)
						// {
						// 	$RFID_nuevos[] = array('RFID'=>$rand,'SERIE'=>$value);
						// 	// array_push($RFID_nuevos,$rand);
						// }
					}
				}
				$RFID_nuevos[] = array('RFID'=>$rand,'SERIE'=>$value);
			}else
			{		  		
				$log[3]['campo']='detalle';
				$log[3]['dato']='Etiqueta con asset:'.$value.' no impresa (ya existe)';
				$this->modelo->insertar($log,'log_activos');
				$msj.= "El ASSET:".$value.' ya existe ('.count($asset_exist).'),';
			}
	  	}

	  	$link = str_replace('impresiones_tag.php','', $_SERVER['HTTP_REFERER']);

	  foreach ($RFID_nuevos as $key => $value) {
	  		$datoss2[0]['campo']='RFID';
			$datoss2[0]['dato']=$value['RFID'];
	  		$datoss2[1]['campo']='SERIE';
			$datoss2[1]['dato']=$value['SERIE'];
	  		$datoss2[2]['campo']='DATO_QR';
			$datoss2[2]['dato']=$link."detalle_activo.php?id=".$value['RFID'];
	  		$datoss2[3]['campo']='ID_USUARIO';
			$datoss2[3]['dato']=$_SESSION['INICIO']['ID_USUARIO'];
			$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');

	  		$datoss3[0]['campo']='Codigo';
			$datoss3[0]['dato']=$value['RFID'];
			$this->modelo->insertar($datoss3,'RFID_IMPRESOS');

			$datoss4[0]['campo']='TAG_UNIQUE';
			$datoss4[0]['dato']=$value['RFID'];
	  		$datoss4[1]['campo']='TAG_SERIE';
			$datoss4[1]['dato']=$value['SERIE'];
			$this->modelo->insertar($datoss4,'ASSET');

			//se crea un registro en blanco en detalles

			$dato_asset = $this->modelo->asset($value['SERIE']);
			// print_r($dato_asset);die();
			if(count($dato_asset)>0)
			{
				$datoss5[0]['campo']='COMPANYCODE';
				$datoss5[0]['dato']='1000';
	  			$datoss5[1]['campo']='ID_ASSET';
				$datoss5[1]['dato']=$dato_asset[0]['ID_ASSET'];
	  			$datoss5[2]['campo']='FECHA_INV_DATE';
				$datoss5[2]['dato']= strval(date('d-m-Y'));
	  			$datoss5[3]['campo']='ACTU_POR';
				$datoss5[3]['dato']=$_SESSION['INICIO']['EMAIL'];
				$res = $this->modelo->insertar($datoss5,'PLANTILLA_MASIVA');
				// print_r($res);die();

				$log[3]['campo']='detalle';
				$log[3]['dato']='Etiqueta con asset:'.$dato_asset[0]['TAG_SERIE'].' y RFID:'.$dato_asset[0]['TAG_UNIQUE'].' genero un registro nuevo por impresion';
				$this->modelo->insertar($log,'log_activos');

			}



	  }

		// $d = 1;
		return array('resp'=>1,'msj'=>$msj);
	
	}else
	{

		return array('resp'=>2,'msj'=>'');
	}
	}

function reimprimir_tags_bloque($parametros)
	{
		$log[0]['campo']='usuario';
  		$log[0]['dato']=$_SESSION['INICIO']['USUARIO'];
  		$log[1]['campo']='accion';
		$log[1]['dato']='Reimpresion en bloque';
  		$log[2]['campo']='fecha';
		$log[2]['dato']=date('Y-m-d');

		// print_r($parametros);die();
	   $tags = preg_replace("/^\h*\v+/m", "",$parametros['tags']);
	   $tags_assets = explode("\n", $tags);
	   $tags_assets = array_filter($tags_assets, 'strlen');

		$v = $this->modelo->existe_datos();
		$RFID_nuevos = array();	
		$datoss2 = array();
		$msj='';
		if($v == -1)
		{
			$link = str_replace('impresiones_tag.php','', $_SERVER['HTTP_REFERER']);
			foreach ($tags_assets as $key => $value) {
				$generar = 1;
				// $rand = "500200010007002800".$rand;
				$articulo = $this->modelo->lista_articulos("'".$value."'",false,false,false,false,$exacto=true,$asset=true,false,false,false,false,false,true,false,false);
				if(count($articulo)>0)
				{
					$datoss2[0]['campo']='RFID';
					$datoss2[0]['dato']=$articulo[0]['RFID'];
			  		$datoss2[1]['campo']='SERIE';
					$datoss2[1]['dato']=$articulo[0]['tag'];
			  		$datoss2[2]['campo']='DATO_QR';
					$datoss2[2]['dato']=$link."detalle_activo.php?id=".$articulo[0]['RFID'];
			  		$datoss2[3]['campo']='ID_USUARIO';
					$datoss2[3]['dato']=$_SESSION['INICIO']['ID_USUARIO'];
					$this->modelo->insertar($datoss2,'IMPRIMIR_TAGS');

					$log[3]['campo']='detalle';
					$log[3]['dato']='Etiqueta con asset:'.$articulo[0]['tag'].' re impresa';
					$this->modelo->insertar($log,'log_activos');


				}else
				{
					$msj= $value.',';

				}
		  	}
			$d = 1;
			return array('resp'=>$d,'msj'=>$msj);
	
		}else
		{
			$d=2;
			return array('resp'=>$d,'msj'=>"");
		}
	}

	
	function generarCodigo($longitud) 
	{
       $key = '';
       $pattern = '1234567890';
       $max = strlen($pattern)-1;
       for($i=0;$i < $longitud;$i++) { 
       	$key .= mt_rand(0,$max);
       }
       return $key;
    }


    function articulos_especiales($parametros)
    {
    	if($parametros['articulos']==0){
    	$datos = $this->modelo-> lista_articulos($query=false,$loc=false,$cus=false,$pag=false,$whereid=false,$exacto=false,$asset=false,$bajas=$parametros['bajas'],$terceros=$parametros['terceros'],$patrimoniales=$parametros['patrimoniales'],$desde=false,$hasta=false);
        }else
        {
        	$eti = $this->modelo->cantidad_etiquetas();
        	$datos = $this->modelo->cantidad_registros();
        	$datos[1] = $eti[0]; 
        }

		return $datos;
    } 

	function lista_articulos_pag()
	{
		$datos = $this->modelo->lista_articulos_pag();
		$datos = count($datos);
		// print_r($datos);
		return $datos;
	}
	function lista_meses()
	{
		$datos = $this->modelo->meses_modificado();
		return $datos;
	}
	function vaciar_tag()
	{
		$delete = array();
		// $delete = array( array('campo'=>'ID_USUARIO','dato'=>$_SESSION['INICIO']['ID_USUARIO']));
		$datos = $this->modelo->eliminar($delete,'IMPRIMIR_TAGS');
		return $datos;
	}
	function buscar_articulos($buscar)
	{
		$datos = $this->modelo->buscar_articulos($buscar);
		return $datos;
	}
	function insertar_editar($parametros)
	{
		$datos[0]['campo'] ='CODIGO';
		$datos[0]['dato']= $parametros['cod'];
		$datos[1]['campo'] = 'DESCRIPCION';
		$datos[1]['dato']= $parametros['des'];
		if($parametros['id'] == '')
		{
		$datos = $this->modelo->insertar($datos);
	    }else
	    {
	    	$where[0]['campo']= 'ID_articulos';
		    $where[0]['dato'] = $parametros['id'];
	    	$datos = $this->modelo->editar($datos,$where);
	    }

		
		return $datos;

	}
	function eliminar($id)
	{
		$datos[0]['campo']='ID_articulos';
		$datos[0]['dato']=$id;
		$datosresp = $this->modelo->eliminar($datos);		
		return $datosresp;

	}
	function articulos_ddl($query)
	{
		$datos = $this->modelo->lista_articulos($query,'','','1-25',false);
		$cambio = [];
		foreach ($datos as $key => $value) {
			$cambio[] =['id'=>$value['id'],'text'=>utf8_encode($value['nom'])];
		}
		return $cambio;

	}
}
?>