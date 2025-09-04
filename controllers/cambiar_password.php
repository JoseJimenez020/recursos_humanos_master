<?php
header('Content-Type: application/json; charset=utf-8');
// Captura cualquier salida accidental
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

// Ajusta la ruta si hace falta
require_once 'conn.php';

session_start();
$response = ['success'=>false,'message'=>'Error desconocido'];

// 1) Sesión
if (empty($_SESSION['user_id'])) {
  $response['message'] = 'No autenticado';
  echo json_encode($response);
  ob_end_clean();
  exit;
}

// 2) Recoge POST
$actual = $_POST['pass_actual']  ?? '';
$nueva  = $_POST['pass_nueva']   ?? '';
$repite = $_POST['pass_repetir'] ?? '';

// 3) Validaciones
if (!$actual || !$nueva || !$repite) {
  $response['message'] = 'Todos los campos son obligatorios';
  echo json_encode($response);
  ob_end_clean();
  exit;
}
if ($nueva !== $repite) {
  $response['message'] = 'Las contraseñas no coinciden';
  echo json_encode($response);
  ob_end_clean();
  exit;
}

// 4) Verifica y actualiza
try {
  // Tu columna es `Contrasena`
  $stmt = $pdo->prepare("SELECT Contrasena FROM usuarios WHERE UsuarioId=:id");
  $stmt->execute(['id'=>$_SESSION['user_id']]);
  $hash = $stmt->fetchColumn();

  if (!$hash || !password_verify($actual, $hash)) {
    $response['message'] = 'Contraseña actual incorrecta';
    echo json_encode($response);
    ob_end_clean();
    exit;
  }

  $newHash = password_hash($nueva, PASSWORD_DEFAULT);
  $upd = $pdo->prepare("UPDATE usuarios SET Contrasena=:p WHERE UsuarioId=:id");
  $upd->execute(['p'=>$newHash,'id'=>$_SESSION['user_id']]);

  $response = ['success'=>true,'message'=>'Contraseña actualizada correctamente'];
} catch (Throwable $e) {
  // Cualquier excepción interna
  $response['message'] = 'Error interno';
}

// 5) Imprime y limpia buffer
echo json_encode($response, JSON_UNESCAPED_UNICODE);
ob_end_clean();
exit;