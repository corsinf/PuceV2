<?php 
include('../lib/phpmailer/enviar_emails.php');
/**
 * 
 */
$controlador = new email_puce();

if($_SERVER['REQUEST_METHOD']=='GET')
{
	if(isset($_GET['email_puce']))
	{
		$parametros = $_GET;
		echo json_encode($controlador->enviar_puce($parametros));
	}
}
class email_puce
{
	
	private $email;
	function __construct()
	{
		$this->email = new enviar_emails();
	}

	function enviar_puce($parametros)
	{
		// print_r($parametros);die();
		$to = $parametros['usuario'];
		$cuerpo_correo = 'Informe generado desde App movil por: '.$parametros['usuario'];
		$titulo_correo = str_replace('_',' ',$parametros['informe']).' de  activos ';
		$correo_respaldo ='soporte@corsinf.com'; //'CONTROLDEACTIVOS@puce.edu.ec';
		$archivos = false;
		if (file_exists("C:\\PUCE\\image\\".$parametros['informe'].".xls")) {
			$archivos[0] = $parametros['informe'].".xls";
		}
		$nombre = 'Control de activos';
		return $this->email->enviar_email_puce($to,$cuerpo_correo,$titulo_correo,$correo_respaldo,$archivos,$nombre,$HTML=false);

	}
}
?>