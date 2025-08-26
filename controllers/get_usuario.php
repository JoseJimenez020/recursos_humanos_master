<?php
require 'conn.php';

$id = intval($_GET['id'] ?? 0);
$sql = "
  SELECT u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
         u.DepartamentoId, u.PuestoId, u.NumeroTelefono, u.TelefonoAlternativo, u.Email,
         ce.NombreContacto, ce.Parentezco, ce.NumeroTelefono AS NumeroEmergencia
    FROM usuarios u
    LEFT JOIN contacto_emergencia ce ON ce.UsuarioId = u.UsuarioId
   WHERE u.UsuarioId = :id
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
header('Content-Type: application/json');
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC) ?: []);