<?php
// controllers/update_usuario_ajax.php

require 'conn.php';             // tu conexión a $pdo
require 'logica_usuario.php';    // ahí está actualizarUsuario()

// Forzamos salida JSON sin caídas de HTML o whitespace
header('Content-Type: application/json; charset=utf-8');

// Llamamos a la función que actualiza y devuelve un array con success/message
$result = actualizarUsuario($_POST, $pdo);

// Imprimimos el JSON
echo json_encode($result, JSON_UNESCAPED_UNICODE);
exit;