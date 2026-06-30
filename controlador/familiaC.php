<?php 
include('../modelo/familiaM.php');
require_once('../db/codigos_globales.php');
/**
 * 
 */
$controlador = new familiaC();
if(isset($_GET['lista']))
{
	$query = '';
	if(isset($_GET['q']))
	{
		$query = $_GET['q'];
	}
	echo json_encode($controlador->lista_familia($query));
}
if(isset($_GET['lista_subfamilia']))
{
	$id = $_GET['fam'];
	$query = '';
	if(isset($_GET['q']))
	{
		$query = $_GET['q'];
	}
	echo json_encode($controlador->lista_subfamilia($id,$query));
}
if(isset($_GET['insertar']))
{
	echo json_encode($controlador->insertar_editar($_POST['parametros']));
}
if(isset($_GET['insertar_sub']))
{
	echo json_encode($controlador->insertar_editar_sub($_POST['parametros']));
}
// if(isset($_GET['eliminar']))
// {
// 	echo json_encode($controlador->eliminar($_POST['id']));
// }


class familiaC
{
	private $modelo;
	private $cod_global;
	
	function __construct()
	{
		$this->modelo = new familiaM();
		$this->cod_global = new codigos_globales();
		
	}
	function lista_familia($query)
	{
		$datos = $this->modelo->lista_familia(false,$query);
		return $datos;
	}
	function lista_subfamilia($fam,$query)
	{
		$datos = $this->modelo->lista_subfamilia($id=false,$fam,$query);
		return $datos;
	}
	function insertar_editar($parametros)
	{
		$datos[0]['campo'] ='detalle_familia';
		$datos[0]['dato']= $parametros['familia'];
		if($parametros['id']=='')
		{
			return $this->modelo->insertar('FAMILIAS',$datos);
			
		}else
		{
			$where[0]['campo'] = 'id_familia';
			$where[0]['dato'] = $parametros['id'];
			return $this->modelo->insertar('FAMILIAS',$datos,$where);
		}
		
		return $datos;
	}

	function insertar_editar_sub($parametros)
	{
		$datos[0]['campo'] ='detalle_familia';
		$datos[0]['dato']= $parametros['subfamilia'];
		$datos[1]['campo'] ='familia';
		$datos[1]['dato']= $parametros['familia'];
		if($parametros['id']=='')
		{
			return $this->modelo->insertar('FAMILIAS',$datos);
			
		}else
		{
			$where[0]['campo'] = 'id_familia';
			$where[0]['dato'] = $parametros['id'];
			return $this->modelo->insertar('FAMILIAS',$datos,$where);
		}
		
		return $datos;
	}

	// function compara_datos($parametros)
	// {
	// 	$text ='';
	// 	$marca = $this->modelo->lista_estado($parametros['id']);
	// 	if($marca[0]['CODIGO']!=$parametros['cod'])
	// 	{
	// 		$text.=' Se modifico CODIGO en GENERO de '.$marca[0]['CODIGO'].' a '.$parametros['cod'];
	// 	}
	// 	if ($marca[0]['DESCRIPCION']!= $parametros['des']) {
	// 		$text.=' Se modifico DESCRIPCION en GENERO DE '.$marca[0]['DESCRIPCION'].' a '.$parametros['des'];
	// 	}

	// 	return $text;
		
	// }
	// function eliminar($id)
	// {
	// 	$datos[0]['campo']='ID_ESTADO';
	// 	$datos[0]['dato']=$id;
	// 	$datos = $this->modelo->eliminar($datos);		
	// 	return $datos;

	// }
}
?>