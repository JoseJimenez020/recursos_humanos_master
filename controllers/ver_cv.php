<?php
require 'conn.php';  // tu conexión $pdo

// Validar y sanear el parámetro
$manualId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($manualId < 1) {
    http_response_code(400);
    exit('ID inválido');
}

// Obtener el BLOB
$sql = "
  SELECT doc.DocumentoContenido
  FROM recomendaciones m
  JOIN documentos doc ON m.DocumentoId = doc.DocumentoId
  WHERE m.DocumentoId = :id
  LIMIT 1
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $manualId]);
$blob = $stmt->fetchColumn();

if (! $blob) {
    http_response_code(404);
    exit('Manual no encontrado');
}

// Enviar PDF al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="manual_' . $manualId . '.pdf"');
echo $blob;
exit;