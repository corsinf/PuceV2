<?php
if(!class_exists('db'))
{
	include('../db/db.php');
}
/**
 * 
 */
class notificacionesM
{
	private $db;
	
	function __construct()
	{
		$this->db = new db();

	}
   function lista_notificaciones($id = '')
{
    $hoy = date('Y-m-d');

    $sql = "SELECT id_notificacion, id_usuario, fecha_desde, fecha_hasta, estado, mensaje, fecha_ultima_aceptacion 
            FROM NOTIFICACIONES 
            WHERE estado = 1 
            AND ('$hoy' BETWEEN CONVERT(DATE, fecha_desde) AND CONVERT(DATE, fecha_hasta))
            AND (fecha_ultima_aceptacion IS NULL OR CONVERT(DATE, fecha_ultima_aceptacion) < '$hoy')";

    if ($id) {
        $sql .= " AND id_usuario = " . intval($id);
    }

    $sql .= " ORDER BY fecha_desde DESC";

    $datos = $this->db->datos($sql);
    return $datos;
}



function editar_notificaciones($datos, $where) {
    return $this->db->update('NOTIFICACIONES', $datos, $where);
}


}