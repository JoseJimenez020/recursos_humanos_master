<?php
// controllers/get_usuario_ajax.php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// controllers/get_usuario_ajax.php
header('Content-Type: application/json; charset=utf-8');
require_once 'conn.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
  echo json_encode(['error'=>'ID inválido']);
  exit;
}

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
    ce.NombreContacto,
    ce.Parentezco,
    ce.NumeroTelefono AS ContactoTelefono
  FROM usuarios u
  LEFT JOIN contacto_emergencia ce
    ON ce.UsuarioId = u.UsuarioId
  WHERE u.UsuarioId = :id
  LIMIT 1
");
$stmt->execute(['id'=>$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
echo json_encode($user, JSON_UNESCAPED_UNICODE);
exit;