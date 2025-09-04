<?php
// controllers/get_perfil_ajax.php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Desactivar cualquier salida extra
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/conn.php';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

try {
    $stmt = $pdo->prepare("
      SELECT
        u.NumeroTelefono,
        u.Email,
        ce.NombreContacto,
        ce.Parentezco,
        ce.NumeroTelefono AS ContactoTelefono
      FROM usuarios u
      LEFT JOIN contacto_emergencia ce
        ON ce.UsuarioId = u.UsuarioId
      WHERE u.UsuarioId = :id
      LIMIT 1
    ");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno']);
}
exit;