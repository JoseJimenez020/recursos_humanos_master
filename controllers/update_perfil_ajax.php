<?php
// controllers/update_perfil_ajax.php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Capturamos y silenciamos cualquier salida extra
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/conn.php';

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['success' => false, 'message' => 'No autenticado']);
  exit;
}

$usuarioId = $_SESSION['user_id'];
$telefono = filter_input(INPUT_POST, 'NumeroTelefono', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
$nombreCE = filter_input(INPUT_POST, 'NombreContacto', FILTER_SANITIZE_STRING);
$parentesco = filter_input(INPUT_POST, 'Parentezco', FILTER_SANITIZE_STRING);
$numeroCE = filter_input(INPUT_POST, 'NumeroEmergencia', FILTER_SANITIZE_STRING);

try {
  $pdo->beginTransaction();

  // 1) Actualizar usuarios
  $updUser = $pdo->prepare("
      UPDATE usuarios 
         SET NumeroTelefono = :tel,
             Email         = :mail
       WHERE UsuarioId = :uid
    ");
  $updUser->execute([
    'tel' => $telefono,
    'mail' => $email,
    'uid' => $usuarioId
  ]);

  // 2) Insert / Update contacto_emergencia
  $chk = $pdo->prepare("
      SELECT ContactoId 
        FROM contacto_emergencia 
       WHERE UsuarioId = :uid
    ");
  $chk->execute(['uid' => $usuarioId]);
  $existe = (bool) $chk->fetchColumn();

  if ($existe) {
    $sqlCE = "
          UPDATE contacto_emergencia
             SET NombreContacto = :nce,
                 Parentezco     = :par,
                 NumeroTelefono = :num
           WHERE UsuarioId = :uid
        ";
  } else {
    $sqlCE = "
          INSERT INTO contacto_emergencia
             (NombreContacto, Parentezco, NumeroTelefono, UsuarioId)
          VALUES
             (:nce, :par, :num, :uid)
        ";
  }

  $stmtCE = $pdo->prepare($sqlCE);
  $stmtCE->execute([
    'nce' => $nombreCE,
    'par' => $parentesco,
    'num' => $numeroCE,
    'uid' => $usuarioId
  ]);

  $pdo->commit();
  $result = [
    'success' => true,
    'message' => 'Perfil actualizado correctamente.'
  ];

} catch (Exception $e) {
  $pdo->rollBack();
  $result = [
    'success' => false,
    'message' => 'Error al actualizar: ' . $e->getMessage()
  ];
}

// Limpiamos buffer y devolvemos sólo JSON
ob_end_clean();
echo json_encode($result, JSON_UNESCAPED_UNICODE);
exit;