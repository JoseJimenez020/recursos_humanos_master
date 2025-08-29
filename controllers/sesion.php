<?php

if (isset($_SESSION['user_id'])) {

  $stmt = $pdo->prepare('SELECT 
    u.UsuarioId,
    u.Username,
    u.EsAdmin,
    u.NombreUsuario,
    u.ApellidoPaterno,
    u.ApellidoMaterno,
    u.DepartamentoId,
    d.DepartamentoNombre
  FROM usuarios u
  LEFT JOIN departamento d 
    ON u.DepartamentoId = d.DepartamentoId
  WHERE u.UsuarioId = :id
');
  $stmt->bindParam(':id', $_SESSION['user_id']);
  $stmt->execute();
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  $sesion = null;

  if (count($results) > 0) {
    $sesion = $results;
  }
  //var_dump($results);
}

/**
 * Devuelve el atributo src de la imagen de perfil para un usuario.
 *
 * @param PDO $pdo
 * @param int $usuarioId
 * @return string   Algo como: src="data:image/jpeg;base64,..." o
 *                  src="../assets/img/small-logos/user.png"
 */
function obtenerFotoUsuario(PDO $pdo, int $usuarioId): string
{
  $sql = "SELECT FotoContenido
        FROM fotos
       WHERE EntidadTipo = :tipo
         AND EntidadId   = :id
       LIMIT 1
    ";
  $stmt = $pdo->prepare($sql);
  // Aquí sí usamos dos placeholders y los bindamos correctamente
  $stmt->execute([
    'tipo' => 'usuario',
    'id' => $usuarioId
  ]);

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row && !empty($row['FotoContenido'])) {
    $base64 = base64_encode($row['FotoContenido']);
    return 'src="data:image/jpeg;base64,' . $base64 . '"';
  }

  // Si no hay foto, devolvemos la imagen por defecto
  return 'src="../assets/img/small-logos/user.png"';
}


