<?php
declare(strict_types=1);
/**
 * controllers/get_usuario_ajax.php  — VERSIÓN CORREGIDA Y SEGURA
 *
 * BUG ORIGINAL: se accedía a $user['EsAdmin'] ANTES de que $user
 * fuera asignado → PHP Warning + valor undefined.
 *
 * MEJORAS:
 *  - Sesión segura verificada antes de responder
 *  - Solo admins o el propio usuario pueden consultar datos
 *  - Sin exponer Contrasena ni campos sensibles innecesarios
 */

ini_set('display_errors', '0');
error_reporting(E_ALL);

require_once __DIR__ . '/security.php';

if (session_status() === PHP_SESSION_NONE) {
    secureSessionConfig();
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

require_once 'conn.php';
require_once 'sesion.php';  // carga $sesion

// 1. Autenticación
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

// 2. Validar ID solicitado
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// 3. Control de acceso: solo el propio usuario o un admin puede ver los datos
$esAdmin      = (int)($sesion['EsAdmin'] ?? 0);
$usuarioActual = (int)$_SESSION['user_id'];

if ($esAdmin !== 1 && $usuarioActual !== $id) {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit;
}

// 4. Consulta — SIN Contrasena ni campos sensibles innecesarios
$stmt = $pdo->prepare("
    SELECT
        u.UsuarioId,
        u.NombreUsuario,
        u.ApellidoPaterno,
        u.ApellidoMaterno,
        u.Email,
        u.DepartamentoId,
        u.PuestoId,
        u.NumeroTelefono,
        u.TipoSangre,
        u.EsAdmin,
        ce.NombreContacto,
        ce.Parentezco,
        ce.NumeroTelefono AS ContactoTelefono
    FROM usuarios u
    LEFT JOIN contacto_emergencia ce ON ce.UsuarioId = u.UsuarioId
    WHERE u.UsuarioId = :id
    LIMIT 1
");
$stmt->execute([':id' => $id]);

// 5. CORRECCIÓN DEL BUG: asignar $user ANTES de usarlo
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

// Castear EsAdmin a int para consistencia en el JS
$user['EsAdmin'] = (int)$user['EsAdmin'];

echo json_encode($user, JSON_UNESCAPED_UNICODE);
exit;
