<?php 
include('../modelo/notificacionesM.php');
require_once('../db/codigos_globales.php');
/**
 * 
 */
$controlador = new notificacionesC();
if(isset($_GET['lista']))
{
	echo json_encode($controlador->lista_notificacion($_POST['id']));
}
if(isset($_GET['insertar']))
{
	echo json_encode($controlador->insertar_editar($_POST));
}


class notificacionesC
{
	private $modelo;
	private $cod_global;
	
	function __construct()
	{
		$this->modelo = new notificacionesM();
		$this->cod_global = new codigos_globales();
		
	}
	function lista_notificacion($id)
	{
		session_start();
		$id = $_SESSION['INICIO']['ID_USUARIO'];
        $datos = $this->modelo->lista_notificaciones($id);
		return $datos;
    }
    function insertar_editar($parametros)
{
    $id = $parametros['id'];

    $datos[0]['campo'] = 'fecha_ultima_aceptacion';
    $datos[0]['dato']  = date('Y-m-d'); // Hoy

    $where[0]['campo'] = 'id_notificacion';
    $where[0]['dato']  = $id;

    return $this->modelo->editar_notificaciones($datos, $where);
}

}

