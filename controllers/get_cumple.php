<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'conn.php';

// Obtener mes (1–12) o usar el actual
$month = isset($_GET['month']) ? (int) $_GET['month'] : date('n');

// Consulta: día y foto (si la hay)
$sql = "
  SELECT 
    DAY(u.FechaNacimiento) AS day,
    f.FotoContenido
  FROM usuarios u
  LEFT JOIN fotos f
    ON f.EntidadTipo = 'usuario'
   AND f.EntidadId   = u.UsuarioId
  WHERE MONTH(u.FechaNacimiento) = :month
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':month' => $month]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar por día y armar URLs de foto
$birthdays = [];
foreach ($rows as $r) {
    $d = (int) $r['day'];
    $src = $r['FotoContenido']
        ? 'data:image/jpeg;base64,' . base64_encode($r['FotoContenido'])
        : '../assets/img/small-logos/user.png';
    $birthdays[$d][] = $src;
}

echo json_encode($birthdays);