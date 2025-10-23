<?php
// Configuración
$baseDir = '../docs'; // carpeta donde están los archivos
if (!isset($_GET['file'])) {
    http_response_code(400); exit('Archivo no especificado');
}

// Sanitizar entrada
$requested = basename($_GET['file']); // evita ../ y rutas con subdirectorios
$path = realpath($baseDir . DIRECTORY_SEPARATOR . $requested);

// Verificar ruta dentro del directorio permitido
if ($path === false || strpos($path, realpath($baseDir)) !== 0 || !is_file($path)) {
    http_response_code(404); exit('Archivo no encontrado');
}

// Determinar mime type seguro
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $path) ?: 'application/octet-stream';
finfo_close($finfo);

// Cabeceras para forzar descarga
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . basename($path) . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($path));

// Enviar el archivo (leer en bloque para archivos grandes)
$chunkSize = 8192;
$handle = fopen($path, 'rb');
if ($handle === false) {
    http_response_code(500); exit('Error al abrir el archivo');
}
while (!feof($handle)) {
    echo fread($handle, $chunkSize);
    flush();
}
fclose($handle);
exit;