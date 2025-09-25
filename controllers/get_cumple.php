<?php
// get_cumple.php
header('Content-Type: application/json; charset=utf-8');
require_once 'conn.php';

$month = isset($_GET['month']) ? (int) $_GET['month'] : date('n');

$sql = "
  SELECT 
    DAY(u.FechaNacimiento) AS day,
    u.NombreUsuario,
    u.ApellidoPaterno,
    u.ApellidoMaterno,
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

$birthdays = [];
foreach ($rows as $r) {
    $d = (int) $r['day'];
    $src = $r['FotoContenido']
      ? 'data:image/jpeg;base64,' . base64_encode($r['FotoContenido'])
      : '../assets/img/small-logos/user.png';

    // Concatenar nombre completo
    $fullName = trim("{$r['NombreUsuario']} {$r['ApellidoPaterno']} {$r['ApellidoMaterno']}");

    $birthdays[$d][] = [
        'src'  => $src,
        'name' => $fullName
    ];
}

echo json_encode($birthdays);