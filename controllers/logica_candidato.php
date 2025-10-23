<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'conn.php';

if (isset($_SESSION['candidato_id'])) {
    $stmt = $pdo->prepare('SELECT 
    CandidatoId, NombreCompleto, NumeroCandidato, CorreoCandidato, Edad, BaseAplica, PuestoAplica
    FROM candidatos
  WHERE CandidatoId = :id
');
    $stmt->bindParam(':id', $_SESSION['candidato_id']);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    $sesion = null;

    if (count($results) > 0) {
        $sesion = $results;
    }
}
if (!isset($_SESSION['candidato_id'])) {
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Inicia sesión para continuar.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = '../pages/sign-in.php';
                });
            });
        </script>";
}

function CerrarSesion()
{

    session_unset(); // Destruye las variables de sesión
    session_destroy(); // Destruye la sesión

    return true;

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerrarSesion'])) {

    if (CerrarSesion()) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  title: 'Sesión finalizada.',
                  icon: 'success',
                  draggable: true
                }).then(() => {
                    window.location.href = '../pages/sign-in.php';
                });
            });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrio un problema al cerrar sesión.',
                    icon: 'error'
                });
            });
        </script>";
    }
}
// alertScript corregida (asegura comillas y carga SweetAlert si hace falta)
function alertScript(string $title, string $text, string $icon, string $redir = null): string
{
    $swalOptions = [
        'title' => $title,
        'text' => $text,
        'icon' => $icon
    ];
    $jsonOpts = json_encode($swalOptions, JSON_UNESCAPED_UNICODE);

    $jsRedir = $redir
        ? 'window.location.href = ' . json_encode($redir, JSON_UNESCAPED_UNICODE) . ';'
        : '';

    return <<<HTML
<script>
  (function loadAndShow() {
    function show() {
      Swal.fire($jsonOpts).then(function() {
        $jsRedir
      });
    }
    if (typeof Swal === 'undefined') {
      var s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
      s.onload = show;
      s.onerror = show;
      document.head.appendChild(s);
    } else {
      show();
    }
  })();
</script>
HTML;
}

// Manejo POST: detecta subida y delega en processFileUploads
if ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_FILES['archivo']) || isset($_FILES['archivo'][0]))) {

    // apartados pueden venir como apartado (string) o apartado[] (array) o apartado2
    $apartadoInput = $_POST['apartado'] ?? ($_POST['apartado2'] ?? null);
    $nombreUsuario = $_POST['nombreUsuario'] ?? null;

    echo processFileUploads($_FILES['archivo'] ?? null, $apartadoInput, $nombreUsuario, $pdo, $sesion);
    exit;
}

// processFileUploads completo (soporta archivo[] y apartado[] — mapea por índice)
function processFileUploads(array $filesArray = null, $postApartado = null, ?string $postNombre = null, PDO $pdo, ?array $sesion = null): string
{
    // Configuración
    $uploadDir = realpath(__DIR__ . '/../uploads') ?: __DIR__ . '/../uploads';
    if (!is_dir($uploadDir))
        mkdir($uploadDir, 0755, true);

    $maxFileSize = 10 * 1024 * 1024; // 10 MB
    $allowedExt = ['xls', 'xlsx', 'doc', 'docx', 'pdf'];
    $allowedMime = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/pdf'
    ];

    // Helpers
    $sanitizeSectionName = function ($s) {
        $s = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $s);
        return substr($s, 0, 50);
    };
    $sanitizeFileNamePart = function ($s) {
        $s = preg_replace('/\s+/', '', (string) $s);
        $s = preg_replace('/[^A-Za-z0-9_-]/', '', $s);
        return substr($s, 0, 80);
    };
    $getExtension = function ($name) {
        $p = pathinfo($name, PATHINFO_EXTENSION);
        return strtolower((string) $p);
    };

    // Normalizar archivos y mapear apartados por índice
    $uploadedFiles = [];
    $apartados = $postApartado;
    // Si apartados vienen como string y hay parametro apartado2, preferir array formado
    if (!is_array($apartados) && isset($_POST['apartado2']) && $_POST['apartado2'] !== null) {
        // si el form usa apartado y apartado2 separados, los ponemos en array para mapear
        $apartados = is_array($postApartado) ? $postApartado : [$postApartado, $_POST['apartado2']];
    }

    if ($filesArray && isset($filesArray['name'])) {
        if (is_array($filesArray['name'])) {
            $count = count($filesArray['name']);
            for ($i = 0; $i < $count; $i++) {
                $uploadedFiles[] = [
                    'name' => $filesArray['name'][$i],
                    'tmp' => $filesArray['tmp_name'][$i],
                    'size' => $filesArray['size'][$i],
                    'error' => $filesArray['error'][$i],
                    'apartado' => is_array($apartados) ? ($apartados[$i] ?? null) : $apartados
                ];
            }
        } else {
            $uploadedFiles[] = [
                'name' => $filesArray['name'],
                'tmp' => $filesArray['tmp_name'],
                'size' => $filesArray['size'],
                'error' => $filesArray['error'],
                'apartado' => is_array($apartados) ? ($apartados[0] ?? $apartados) : $apartados
            ];
        }
    }

    if (empty($uploadedFiles)) {
        return alertScript('Error', 'No se recibió ningún archivo.', 'error', null);
    }

    // Preparar inserción
    $insertStmt = $pdo->prepare('INSERT INTO pruebas_candidatos (CandidatoId, PruebaRuta, PruebaNombre) VALUES (:cid, :ruta, :nombre)');

    $messages = [];
    $candidatoId = $sesion['CandidatoId'] ?? null;
    $partName = $sanitizeFileNamePart($postNombre ?? 'anonimo');

    foreach ($uploadedFiles as $index => $f) {
        $fname = $f['name'] ?? 'archivo';
        // Validaciones básicas
        if (($f['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            $code = $f['error'] ?? UPLOAD_ERR_PARTIAL;
            $messages[] = "Error en archivo {$fname} (code {$code}).";
            continue;
        }
        if (($f['size'] ?? 0) > $maxFileSize) {
            $messages[] = "Archivo demasiado grande: {$fname}. Límite: 10 MB.";
            continue;
        }
        $ext = $getExtension($fname);
        if (!in_array($ext, $allowedExt, true)) {
            $messages[] = "Extensión no permitida: {$fname}.";
            continue;
        }
        $tmp = $f['tmp'] ?? '';
        if (!is_uploaded_file($tmp)) {
            $messages[] = "Origen del archivo inválido: {$fname}.";
            continue;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmp);
        finfo_close($finfo);
        if (!in_array($mime, $allowedMime, true)) {
            $messages[] = "Tipo MIME no permitido: {$fname}.";
            continue;
        }

        // apartados por archivo (si no hay, usar valor general 'doc')
        $fileApartadoRaw = $f['apartado'] ?? $postApartado ?? 'doc';
        $fileApartado = $sanitizeSectionName($fileApartadoRaw ?: 'doc');

        // Construir nombre seguro: Apartado_NombreUsuario_indice.ext para evitar colisiones
        $baseName = $fileApartado . '_' . $partName;
        // Añadir índice para asegurar nombres distintos si vienen con mismo apartado y mismo nombre
        $baseNameIndexed = $baseName . '_' . ($index + 1);
        $finalName = $baseNameIndexed . '.' . $ext;
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $finalName;

        // Si existe (muy improbable por índice), añadir timestamp
        if (file_exists($targetPath)) {
            $finalName = $baseNameIndexed . '_' . time() . '.' . $ext;
            $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $finalName;
        }

        if (!move_uploaded_file($tmp, $targetPath)) {
            $messages[] = "No se pudo mover el archivo: {$fname}.";
            continue;
        }
        @chmod($targetPath, 0644);

        $relativePath = '../uploads/' . $finalName;

        try {
            $insertStmt->execute([
                ':cid' => $candidatoId,
                ':ruta' => $relativePath,
                ':nombre' => $finalName
            ]);
        } catch (Exception $e) {
            @unlink($targetPath);
            $messages[] = "Error al guardar registro en BD para: {$fname}.";
            continue;
        }

        $messages[] = "OK: {$finalName}";
    }

    // Clasificar resultados
    $ok = [];
    $err = [];
    foreach ($messages as $m) {
        if (strpos($m, 'OK:') === 0)
            $ok[] = $m;
        else
            $err[] = $m;
    }

    // Redirección destino cuando todo OK
    $successRedirect = '../pages/candidatos.php';

    if (!empty($err) && empty($ok)) {
        $text = implode(" ", $err);
        return alertScript('No se subieron los archivos', $text, 'error', null);
    } elseif (!empty($err) && !empty($ok)) {
        $text = "Archivos subidos: " . implode(" ", $ok) . " Errores: " . implode(" ", $err);
        return alertScript('Subida parcial', $text, 'warning', null);
    } else {
        $text = "¡Archivos subidos con éxito!";
        return alertScript('Subida correcta', $text, 'success', $successRedirect);
    }
}