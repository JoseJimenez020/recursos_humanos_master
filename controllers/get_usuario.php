<?php
require_once 'conn.php';

header('Content-Type: application/json; charset=utf-8');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$sql = "
  SELECT 
    u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
    u.Email, u.NumeroTelefono, u.TelefonoAlternativo,
    ce.NombreContacto, ce.Parentezco, ce.NumeroTelefono AS ContactoTelefono
  FROM usuarios u
  LEFT JOIN contacto_emergencia ce ON u.UsuarioId = ce.UsuarioId
  WHERE u.UsuarioId = :id
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

echo json_encode($user, JSON_UNESCAPED_UNICODE);
exit;