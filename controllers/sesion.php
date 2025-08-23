<?php

if (isset($_SESSION['UsuarioId'])) {
    
  $stmt = $pdo->prepare('SELECT UsuarioId, Username, EsAdmin, NombreUsuario, ApellidoPaterno, ApellidoMaterno FROM usuarios WHERE UsuarioId = :id');
  $stmt->bindParam(':id', $_SESSION['UsuarioId']);
  $stmt->execute();
  $results = $stmt->fetch(PDO::FETCH_ASSOC);

  $sesion = null;

  if (count($results) > 0) {
    $sesion = $results;
  }
  //var_dump($results);
}

function obtenerFotoAsesor($pdo, $usuarioId) {
  $sql = "SELECT FotoContenido FROM fotos WHERE EntidadTipo = 'usuario' AND EntidadId = $usuarioId;";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":id", $usuarioId, PDO::PARAM_INT);
  $stmt->execute();
  $foto = $stmt->fetch(PDO::FETCH_ASSOC);

  $fotoBase64 = $foto ? base64_encode($foto['AsesorFoto']) : null;
  $imagen = $fotoBase64 ? 'src="data:image/jpeg;base64,' . $fotoBase64 . '"' : 'src="../assets/img/small-logos/user.png"';

  return $imagen;
}

?>