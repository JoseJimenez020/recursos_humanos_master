<?php
// controllers/update_usuario.php
require_once 'conn.php';
require_once 'logica_usuario.php';

// 1) Forzar salida JSON y desactivar cualquier warning/notice
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors',   1);
ini_set('display_startup_errors', 1);
error_reporting(1);

// 2) Llamar a tu función y obtener resultado como array
$result = actualizarUsuario($_POST, $pdo);

// 3) Emitir JSON puro y terminar
echo json_encode($result, JSON_UNESCAPED_UNICODE);
exit;