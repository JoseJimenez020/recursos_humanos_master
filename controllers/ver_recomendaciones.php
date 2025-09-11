<?php
require_once '../controllers/conn.php';   // tu conexión PDO
require_once '../controllers/logica_vacantes.php'; // donde definiste GetTableRecomendaciones

header('Content-Type: text/html; charset=utf-8');

if (! isset($_GET['id']) || ! is_numeric($_GET['id'])) {
    echo '<tr><td colspan="4" class="text-center text-danger">ID inválido</td></tr>';
    exit;
}

$vacanteId = (int) $_GET['id'];
echo GetTableRecomendaciones($pdo, $vacanteId);