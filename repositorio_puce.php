<?php
// proxy_imagen.php - Versión con CORS001
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración con el nombre del servidor
$servidor_imagenes = "\\\\CORS001\\xampp\\htdocs\\img\\";
// Alternativa si solo se comparte la carpeta img
// $servidor_imagenes = "\\\\CORS001\\img\\";

$nombre_imagen = $_GET['nombre'] ?? '';

if (empty($nombre_imagen)) {
    header("Content-Type: image/jpeg");
    readfile("img/sin_imagen.jpg");
    exit;
}

$nombre_imagen = basename($nombre_imagen);
$nombre_imagen = preg_replace('/[^a-zA-Z0-9._-]/', '', $nombre_imagen);
$ruta_completa = $servidor_imagenes . $nombre_imagen;

if (file_exists($ruta_completa)) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $ruta_completa);
    finfo_close($finfo);
    
    header("Content-Type: " . $mime_type);
    header("Content-Length: " . filesize($ruta_completa));
    header("Cache-Control: public, max-age=86400");
    readfile($ruta_completa);
    exit;
} else {
    // Imagen por defecto
    header("Content-Type: image/jpeg");
    readfile("img/sin_imagen.jpg");
    exit;
}
?>