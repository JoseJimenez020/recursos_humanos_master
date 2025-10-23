<?php
// /controllers/usuario_foto.php
declare(strict_types=1);
require_once 'conn.php'; // tu conexión $pdo

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    exit;
}

$stmt = $pdo->prepare("SELECT FotoContenido, FotoId FROM fotos WHERE EntidadTipo = 'usuario' AND EntidadId = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || empty($row['FotoContenido'])) {
    // Sirve placeholder estático si no hay blob
    header('Content-Type: image/png');
    readfile(__DIR__ . '/../assets/img/small-logos/user.png');
    exit;
}

$blob = $row['FotoContenido'];
$etag = '"' . md5($blob) . '"';
$lastModified = gmdate('D, d M Y H:i:s', filemtime(__FILE__)) . ' GMT';

// Manejo de cache conditional
if ((isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag)
    || (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] === $lastModified)
) {
    header('HTTP/1.1 304 Not Modified');
    exit;
}

// Detectar tipo básico (si sabes que son JPEG solo usar image/jpeg)
header('Content-Type: image/jpeg');
header('Content-Length: ' . strlen($blob));
header('Cache-Control: public, max-age=86400');
header('ETag: ' . $etag);
header('Last-Modified: ' . $lastModified);

// Salida binaria
echo $blob;
exit;