<?php
// update_usuario_ajax.php
require_once 'conn.php';
require_once 'logica_usuario.php';

header('Content-Type: application/json; charset=utf-8');
// Silencia warnings para no romper el JSON
error_reporting(0);
ini_set('display_errors', 0);

try {
    // 1) Sanitizar y validar el departamento
    $depId = filter_input(INPUT_POST, 'DepartamentoId', FILTER_VALIDATE_INT);
    if (!$depId) {
        throw new Exception('Departamento inválido.');
    }
    // 2) Verificar que exista en la BD
    $chk = $pdo->prepare("SELECT 1 FROM departamento WHERE DepartamentoId = :d");
    $chk->execute(['d' => $depId]);
    if (!$chk->fetch()) {
        throw new Exception('El departamento seleccionado no existe.');
    }

    // 3) Llamar al update real
    $result = actualizarUsuario($_POST, $pdo);

} catch (\PDOException $e) {
    $result = [
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ];
} catch (\Exception $e) {
    $result = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

exit;