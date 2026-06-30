<?php 
if(isset($_GET['api']))
{
	if($_GET['api'] == '123456789')
	{
	 $controlado = new printer();
	 echo json_encode($controlado->prueba());
	}
}


class printer
{
	
	function __construct()
	{
		# code...
	}
	function prueba()
	{
		$filename = "../controlador/temp/12345.png";
		$contenidoImagen = file_get_contents($filename);
		$imagenBase64 =base64_encode($contenidoImagen);
		echo print_r( utf8_encode($imagenBase64));die();
		return $imagenBase64;


//$data = file_get_contents($filename);
//$array = array();
///foreach(str_split($data) as $char){ 
	//array_push($array, ord($char));
//}
  //$bit = implode(' ', $array);

 // return $array;


	}
}

?>