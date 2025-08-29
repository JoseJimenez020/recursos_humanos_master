<?php
// delete_user.php
header('Content-Type: application/json');
require_once 'conn.php';
require_once '../controllers/logica_usuario.php';

// Decodificar cuerpo JSON
$input  = json_decode(file_get_contents('php://input'), true);
$userId = isset($input['user_id']) && is_numeric($input['user_id'])
          ? (int) $input['user_id']
          : 0;

// Validación mínima
if ($userId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de usuario inválido'
    ]);
    exit;
}

// Llamar a la función
$response = eliminarUsuario($pdo, $userId);

// Devolver el resultado como JSON
echo json_encode($response);