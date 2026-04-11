<?php
declare(strict_types=1);
/**
 * controllers/descargar_archivo.php
 *
 * Reemplaza el acceso directo a ../uploads/archivo.ext
 * Uso en el HTML: href="../controllers/descargar_archivo.php?id=XXX"
 *
 * Características:
 *  - Verifica sesión antes de servir cualquier archivo
 *  - Nunca expone la ruta real del servidor
 *  - Solo sirve los tipos de archivo permitidos
 *  - Previene Path Traversal
 */

require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    secureSessionConfig();
    session_start();
}

require_once 'conn.php';

// 1. Autenticación — requiere sesión de candidato O de usuario
$isUsuario   = isset($_SESSION['user_id']);
$isCandidato = isset($_SESSION['candidato_id']);

if (!$isUsuario && !$isCandidato) {
    http_response_code(401);
    header('Location: /');
    exit;
}

// 2. Obtener ID de la prueba a descargar
$pruebaId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$pruebaId || $pruebaId <= 0) {
    http_response_code(400);
    die('ID inválido.');
}

// 3. Buscar el registro en la base de datos
$stmt = $pdo->prepare(
    "SELECT pc.PruebaId, pc.CandidatoId, pc.PruebaRuta, pc.PruebaNombre
     FROM pruebas_candidatos pc
     WHERE pc.PruebaId = :id
     LIMIT 1"
);
$stmt->execute([':id' => $pruebaId]);
$prueba = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prueba) {
    http_response_code(404);
    die('Archivo no encontrado.');
}

// 4. Control de acceso:
//    - Un candidato solo puede descargar SUS propios archivos
//    - Un usuario (empleado/admin) puede descargar cualquiera
if ($isCandidato && !$isUsuario) {
    if ((int)$prueba['CandidatoId'] !== (int)$_SESSION['candidato_id']) {
        http_response_code(403);
        die('Acceso denegado.');
    }
}

// 5. Construir ruta real y verificar que no haya Path Traversal
$uploadsDir = realpath(__DIR__ . '/../uploads');
// PruebaRuta se guardó como '../uploads/filename.ext', normalizar
$fileName   = basename($prueba['PruebaRuta']); // solo el nombre, sin directorio
$realPath   = realpath($uploadsDir . DIRECTORY_SEPARATOR . $fileName);

if ($realPath === false || strpos($realPath, $uploadsDir) !== 0) {
    http_response_code(400);
    die('Ruta inválida.');
}

if (!file_exists($realPath)) {
    http_response_code(404);
    die('El archivo no existe en el servidor.');
}

// 6. Detectar MIME real
$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($realPath);

$allowedMimes = [
    'application/pdf',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

if (!in_array($mimeType, $allowedMimes, true)) {
    http_response_code(415);
    die('Tipo de archivo no permitido para descarga.');
}

// 7. Servir el archivo de forma segura
$safeFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $prueba['PruebaNombre']);

header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $safeFileName . '"');
header('Content-Length: ' . filesize($realPath));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-cache, no-store');
header('Pragma: no-cache');

// Limpiar buffer de salida antes de enviar binario
if (ob_get_level()) {
    ob_end_clean();
}

readfile($realPath);
exit;
