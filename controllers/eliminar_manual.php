<?php
session_start();
require 'conn.php';  // donde creas tu $pdo

// Validar ID
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    exit('ID inválido');
}
$manualId = (int) $_GET['id'];

try {
    $pdo->beginTransaction();

    // 1) Obtener DocumentoId antes de eliminar
    $stmt = $pdo->prepare("SELECT DocumentoId FROM manuales WHERE ManualId = ?");
    $stmt->execute([$manualId]);
    $docId = $stmt->fetchColumn();

    // 2) Borrar de manuales
    $stmt = $pdo->prepare("DELETE FROM manuales WHERE ManualId = ?");
    $stmt->execute([$manualId]);

    // 3) Borrar de documentos (si existía)
    if (!empty($docId)) {
        $stmt = $pdo->prepare("DELETE FROM documentos WHERE DocumentoId = ?");
        $stmt->execute([$docId]);
    }

    $pdo->commit();
    header('Location: ../pages/manuales.php?msg=eliminado');
    exit;
}
catch (Exception $e) {
    $pdo->rollBack();
    exit('Error al eliminar el manual.');
}