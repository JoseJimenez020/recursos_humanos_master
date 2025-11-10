<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
  echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Inicia sesión para continuar.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = '../pages/sign-in.php';
                });
            });
        </script>";
}

require 'sesion.php';
require 'logout.php';
function alertScript(string $title, string $text, string $icon, string $redir = null): string
{
  // 1) Preparamos el objeto de opciones de Swal
  $swalOptions = [
    'title' => $title,
    'text' => $text,
    'icon' => $icon
  ];
  // 2) Codificamos a JSON para JS (escapa comillas, barras, tildes, etc.)
  $jsonOpts = json_encode($swalOptions, JSON_UNESCAPED_UNICODE);

  // 3) Si hay redirección, la añadimos como JS puro pero escapada
  $jsRedir = $redir
    ? 'window.location.href = ' . json_encode($redir, JSON_UNESCAPED_UNICODE) . ';'
    : '';

  // 4) Devolvemos un único <script> con código limpio
  return <<<HTML
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire($jsonOpts).then(function() {
      $jsRedir
    });
  });
</script>
HTML;
}

/**
 * Devuelve bloques HTML para el timeline de vacaciones activas.
 *
 * @param PDO $pdo Conexión PDO a la base de datos
 * @return string  Bloques HTML o mensaje de ausencia de vacaciones
 */
function GetTimelineVacaciones(PDO $pdo): string
{
  // 1) Fecha de hoy para filtro
  $hoy = date('Y-m-d');

  // 2) Consulta uniendo usuarios con vacaciones activas
  $sql = "
      SELECT 
        u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno,
        v.FechaInicio, v.FechaFin
      FROM vacaciones v
      JOIN usuarios   u ON u.UsuarioId = v.UsuarioId
      WHERE v.FechaFin >= :hoy
      ORDER BY v.FechaInicio ASC
    ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['hoy' => $hoy]);
  $vacaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // 3) Si no hay vacaciones activas
  if (empty($vacaciones)) {
    return <<<HTML
<div class="text-center text-secondary py-3">
  No hay nadie de vacaciones por el momento
</div>
HTML;
  }

  // 4) Clases posibles para el icono
  $clases = ['text-success', 'text-danger', 'text-info', 'text-warning', 'text-primary'];

  // 5) Generar bloques
  $html = '';
  foreach ($vacaciones as $v) {
    // Nombre completo
    $nombre = htmlspecialchars(
      "{$v['NombreUsuario']} {$v['ApellidoPaterno']} {$v['ApellidoMaterno']}"
    );

    // Formato dd/mm/yy
    $inicio = date('d/m/y', strtotime($v['FechaInicio']));
    $fin = date('d/m/y', strtotime($v['FechaFin']));

    // Selección aleatoria de color
    $colorIcono = $clases[array_rand($clases)];

    $html .= <<<HTML
<div class="timeline-block mb-3">
  <span class="timeline-step">
    <i class="material-symbols-rounded {$colorIcono} text-gradient">hotel</i>
  </span>
  <div class="timeline-content">
    <h6 class="text-dark text-sm font-weight-bold mb-0">{$nombre}</h6>
    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
      Del {$inicio} al {$fin}
    </p>
  </div>
</div>
HTML;
  }

  return $html;
}

function mostrarContador($pdo): string
{
  $sql = "SELECT COUNT(*) FROM `vacantes` WHERE `Status` = 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $contador = $stmt->fetchColumn(); // Obtiene directamente el número

  $html = '<a class="btn btn-outline-primary w-100" href="../pages/vacantes.php" type="button">
                <span class="nav-link-text ms-1">Activas</span>
                <i class="material-symbols-rounded opacity-5">groups</i>
                <span id="contador_vacantes">' . $contador . '</span>
                <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
            </a>';

  return $html;
}

function registrarQueja(array $data, PDO $pdo): string
{
  $userId = filter_var($data['UsuarioId'], FILTER_SANITIZE_STRING);
  $mensajeContenido = filter_var($data['mensajeContenido'], FILTER_SANITIZE_STRING);
  try {
    $pdo->beginTransaction();
    $sqlM = "INSERT INTO quejas 
            (UsuarioId, FechaMensaje, Mensaje)
            VALUES
            (:usuario, CURDATE(), :mensaje)";

    $stM = $pdo->prepare($sqlM);
    $stM->execute([
      ':usuario' => $userId,
      'mensaje' => $mensajeContenido
    ]);

    $pdo->commit();

    return alertScript(
      '¡Éxito!',
      'Mensaje enviado correctamente.',
      'success',
      '../pages/dashboard.php'
    );

  } catch (PDOException $e) {
    $pdo->rollBack();
    return alertScript(
      'Error',
      'No se pudo registrar: ' . $e->getMessage(),
      'error'
    );
  }
}

function GetBuzonQuejas($pdo): string
{
  $sql = "
      SELECT
        q.QuejaId,
        q.FechaMensaje,
        q.Mensaje,
        u.NombreUsuario,
        u.ApellidoPaterno,
        u.ApellidoMaterno,
        u.Email,
        u.NumeroTelefono,
        d.DepartamentoNombre
      FROM quejas q
      LEFT JOIN usuarios u ON q.UsuarioId = u.UsuarioId
      LEFT JOIN departamento d ON u.DepartamentoId = d.DepartamentoId
      ORDER BY q.FechaMensaje DESC
    ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($rows)) {
    return '<li class="list-group-item">No hay mensajes disponibles.</li>';
  }

  $html = '';
  foreach ($rows as $me) {
    // Nombre completo
    $full = htmlspecialchars("{$me['NombreUsuario']} {$me['ApellidoPaterno']} {$me['ApellidoMaterno']}", ENT_QUOTES);
    $fecha = date('d/m/Y', strtotime($me['FechaMensaje']));
    $mensaje = htmlspecialchars($me['Mensaje'], ENT_QUOTES);
    $email = htmlspecialchars($me['Email'], ENT_QUOTES);
    $telefono = htmlspecialchars($me['NumeroTelefono'], ENT_QUOTES);
    $quejaid = htmlspecialchars($me['QuejaId'], ENT_QUOTES);

    $html .= <<<HTML
<li class="list-group-item d-flex">
  <div class="flex-grow-1">
    <h6>$full</h6>
    <p class="small">Departamento: {$me['DepartamentoNombre']}</p>
    <p class="small">Fecha: $fecha</p>
  </div>
  <div class="text-end">
    <a
      href="javascript:;"
      class="btn btn-link text-dark px-2"
      data-bs-toggle="modal"
      data-bs-target="#exampleModalLong"
      data-nombre="$full"
      data-mensaje="$mensaje"
      data-email="$email"
      data-telefono="$telefono"
    ><i class="material-symbols-rounded">visibility</i></a>
    <a
      href="javascript:;"
      class="btn btn-link text-danger px-2"
      data-bs-toggle="modal"
      data-bs-target="#modal-notification"
      data-nombre="$full"
      data-quejaid="$quejaid"
    ><i class="material-symbols-rounded">delete</i></a>
  </div>
</li>
HTML;
  }

  return $html;
}

/**
 * Elimina una queja de la base de datos y devuelve un script SweetAlert.
 *
 * @param  array   $data Datos del POST, debe incluir 'QuejaId'
 * @param  PDO     $pdo  Conexión PDO
 * @return string        Un <script> con la llamada a alertScript()
 */
function borrarQueja(array $data, PDO $pdo): string
{
  // 1) Sanitizar y validar el ID
  $quejaId = filter_var($data['QuejaId'] ?? null, FILTER_VALIDATE_INT);

  try {
    // 2) Iniciar transacción
    $pdo->beginTransaction();

    // 3) Ejecutar borrado
    $sql = "DELETE FROM quejas WHERE QuejaId = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $quejaId]);

    // 4) Confirmar cambios
    $pdo->commit();

    // 5) Retornar alerta de éxito y redirigir
    return alertScript(
      '¡Éxito!',
      'Mensaje eliminado correctamente.',
      'success',
      '../pages/dashboard.php'
    );

  } catch (PDOException $e) {
    // 6) Revertir en caso de error y notificar
    $pdo->rollBack();
    return alertScript(
      'Error',
      'No se pudo eliminar el mensaje: ' . $e->getMessage(),
      'error'
    );
  }
}

function registrarAviso(array $post, PDO $pdo): string
{
  // 1. Sanitizar inputs
  $titulo = trim(filter_var($post['avisoTitulo'], FILTER_SANITIZE_STRING));
  $descrip = trim(filter_var($post['avisoDesc'], FILTER_SANITIZE_STRING));
  $esAviso = (int) filter_var($post['esAviso'], FILTER_SANITIZE_NUMBER_INT);
  $usuarioId = (int) $_SESSION['user_id'];

  try {
    $pdo->beginTransaction();

    // 2. Insertar el aviso sin foto
    $sqlAviso = "INSERT INTO avisos
            (TituloAviso, Fecha, DescripcionAviso, EsCampana, UsuarioId)
            VALUES
            (:titulo, NOW(), :descrip, :esAviso, :usuarioId)";
    $stmtAviso = $pdo->prepare($sqlAviso);
    $stmtAviso->execute([
      ':titulo' => $titulo,
      ':descrip' => $descrip,
      ':esAviso' => $esAviso,
      ':usuarioId' => $usuarioId,
    ]);
    $avisoId = $pdo->lastInsertId();

    // 3. Verificar que el array $_FILES venga poblado
    if (!isset($_FILES['avisoFoto'])) {
      throw new Exception('$_FILES["avisoFoto"] no existe. Verifica el name y enctype del form.');
    }

    $file = $_FILES['avisoFoto'];

    // 4. Depuración: ¿qué error reporta PHP?
    if ($file['error'] !== UPLOAD_ERR_OK) {
      // Puedes comentar esta línea para ver el código de error en pantalla
      throw new Exception("Error en la subida de archivo: código {$file['error']}");
    }

    // 5. Validar que sea realmente un upload
    if (!is_uploaded_file($file['tmp_name'])) {
      throw new Exception('El archivo no se reconoció como subida HTTP válida.');
    }

    // 6. Validar tipo de imagen de forma más laxa
    $info = getimagesize($file['tmp_name']);
    if ($info === false) {
      throw new Exception('El archivo no es una imagen válida.');
    }
    // $info[2] es IMAGETYPE_XXX
    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
    if (!in_array($info[2], $allowedTypes, true)) {
      throw new Exception('Formato de imagen no admitido. Solo JPG, PNG o GIF.');
    }

    // 7. Leer contenido binario
    $contenido = file_get_contents($file['tmp_name']);

    // 8. Insertar en fotos
    $sqlFoto = "INSERT INTO fotos
            (FotoContenido, EntidadTipo, EntidadId)
            VALUES
            (:contenido, 'aviso', :entidadId)";
    $stmtFoto = $pdo->prepare($sqlFoto);
    $stmtFoto->execute([
      ':contenido' => $contenido,
      ':entidadId' => $avisoId,
    ]);
    $fotoId = $pdo->lastInsertId();

    // 9. Actualizar avisos con FotoId
    $sqlUpd = "UPDATE avisos
            SET FotoId = :fotoId
            WHERE AvisoId = :avisoId";
    $stmtUpd = $pdo->prepare($sqlUpd);
    $stmtUpd->execute([
      ':fotoId' => $fotoId,
      ':avisoId' => $avisoId,
    ]);

    $pdo->commit();

    return alertScript(
      '¡Éxito!',
      'Información registrada correctamente.',
      'success'
    );

  } catch (Exception $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    // En producción podrías loguear $e->getMessage() y mostrar un mensaje más genérico
    return alertScript(
      'Error',
      'No se pudo registrar el aviso: ' . $e->getMessage(),
      'error'
    );
  }
}

function getAvisosPanel(PDO $pdo, $tipo)
{
  $sql = "SELECT 
        a.AvisoId, a.TituloAviso, a.Fecha, a.DescripcionAviso, 
        a.EsCampana, f.FotoContenido, u.NombreUsuario, u.ApellidoPaterno
        FROM avisos a
        LEFT JOIN usuarios u ON u.UsuarioId = a.UsuarioId
        LEFT JOIN fotos f ON f.EntidadTipo = 'aviso'
                         AND f.EntidadId = a.AvisoId
        WHERE EsCampana=" . $tipo . " ";

  $params = [];

  // Preparar y ejecutar
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($rows)) {
    return '<div class="col-md-4 mb-4">
          <div class="card" data-animation="false">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <a class="d-block blur-shadow-image">
                  </a>
              </div>
              <div class="card-body text-center">
                  <h5 class="font-weight-normal mt-3">
                      <a href="">Sin registros</a>
                  </h5>
                  <p class="mb-0">Por el momento no hay información registrada disponible
                  </p>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer d-flex">
              </div>
          </div>
      </div>';
  }

  $html = '';
  foreach ($rows as $a) {
    $src = $a['FotoContenido']
      ? 'data:image/jpeg;base64,' . base64_encode($a['FotoContenido'])
      : '../assets/img/small-logos/alerta.png';
    $full = "{$a['NombreUsuario']} {$a['ApellidoPaterno']}";
    // truncate to 152 chars
    $desc = strip_tags($a['DescripcionAviso']);
    if (mb_strlen($desc) > 150) {
      $desc = mb_substr($desc, 0, 150) . '…';
    }

    $html .= '<div class="col-md-4 mb-4"> 
    <div class="card" data-animation="true">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <a class="d-block blur-shadow-image stretched-link">
                <img src="' . $src . '"
                    alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
            </a>
            <div class="colored-shadow stretched-link"
                style="background-image: url(&quot;' . $src . '&quot;);">
            </div>
        </div>
        <div class="card-body text-center">
            <div class="d-flex mt-n6 mx-auto">
                <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal" href="../pages/campania_ext.php?avisoId=' . $a['AvisoId'] . '"
                    data-bs-placement="bottom" title="Borrar" data-aviso-name="' . $a['TituloAviso'] . '" data-aviso-id="' . $a['AvisoId'] . '" data-bs-target="#modal-notification">
                    <i class="material-symbols-rounded text-lg">delete</i>
                </a>
                <button class="btn btn-link text-info me-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                    data-bs-placement="bottom" title="Editar" data-aviso-id="' . $a['AvisoId'] . '" data-aviso-title="' . htmlspecialchars($a['TituloAviso'], ENT_QUOTES) . '"
                    data-aviso-desc="' . htmlspecialchars($a['DescripcionAviso'], ENT_QUOTES) . '"
                    data-aviso-src="' . $src . '" data-bs-target="#modal-edit">
                    <i class="material-symbols-rounded text-lg">edit</i>
                </button>
            </div>
            <h5 class="font-weight-normal mt-3">
                ' . $a['TituloAviso'] . '
            </h5>
            <p class="mb-0">' . $desc . '
            </p>
        </div>';
    if ($a['EsCampana'] === 0) {
      $html .= '<hr class="dark horizontal my-0">
        <div class="card-footer d-flex">
            <p class="font-weight-normal my-auto">' . date('d/m/Y', strtotime($a['Fecha'])) . '</p>
            <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
            <p class="text-sm my-auto">' . $full . '</p>
        </div>';
    }
    $html .= '</div>
  </div>';
  }
  return $html;
}

function getAvisosDash(PDO $pdo): string
{
  $sql = "SELECT 
        a.AvisoId, a.TituloAviso, a.Fecha, a.DescripcionAviso, 
        a.EsCampana, f.FotoContenido, u.NombreUsuario, u.ApellidoPaterno
        FROM avisos a
        LEFT JOIN usuarios u ON u.UsuarioId = a.UsuarioId
        LEFT JOIN fotos f ON f.EntidadTipo = 'aviso'
                         AND f.EntidadId = a.AvisoId
        WHERE EsCampana = 0";

  $params = [];

  // Preparar y ejecutar
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($rows)) {
    return '<div class="col-md-4 mb-4">
          <div class="card" data-animation="false">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <a class="d-block blur-shadow-image">
                  </a>
              </div>
              <div class="card-body text-center">
                  <h5 class="font-weight-normal mt-3">
                      <a href="">Sin registros</a>
                  </h5>
                  <p class="mb-0">Por el momento no hay información disponible
                  </p>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer d-flex">
              </div>
          </div>
      </div>';
  }

  $html = '';
  foreach ($rows as $a) {
    $src = $a['FotoContenido']
      ? 'data:image/jpeg;base64,' . base64_encode($a['FotoContenido'])
      : '../assets/img/small-logos/alerta.png';

    // truncate to 152 chars
    $desc = strip_tags($a['DescripcionAviso']);
    if (mb_strlen($desc) > 150) {
      $desc = mb_substr($desc, 0, 150) . '…';
    }

    $html .= '<div class="card" data-animation="true">     
    <a href="../pages/campania_ext.php?avisoId=' . $a['AvisoId'] . '">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="d-block blur-shadow-image">
            <img src="' . $src . '"
                alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
        </div>
        <div class="colored-shadow"
            style="background-image: url(&quot;' . $src . '&quot;);">
        </div>
    </div>
    <div class="card-body text-center">
        <div class="d-flex mt-n6 mx-auto">
            <div class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="">
            </div>
            <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="">
            </button>
        </div>
        <h5 class="font-weight-normal mt-3">
            <a href="../pages/campania_ext.php?avisoId=' . $a['AvisoId'] . '">' . $a['TituloAviso'] . '</a>
        </h5>
        <p class="mb-0">
            ' . $desc . '
        </p>
    </div>
    <hr class="dark horizontal my-0">
    <div class="card-footer d-flex">
        <p class="font-weight-normal my-auto">' . date('d/m/Y', strtotime($a['Fecha'])) . '</p>
    </div> </a>
    <a href="../pages/campania_ext.php?avisoId=' . $a['AvisoId'] . '" class="stretched-link"></a>
</div> ';
  }
  return $html;
}

function borrarAviso(array $data, PDO $pdo): string
{
  // 1) Sanitizar y validar el ID
  $avisoId = filter_var($data['AvisoId'] ?? null, FILTER_VALIDATE_INT);

  try {
    // 2) Iniciar transacción
    $pdo->beginTransaction();

    // 3) Obtener FotoId asociada (si existe)
    $stmt = $pdo->prepare("
            SELECT f.FotoId
            FROM fotos f
            WHERE f.EntidadTipo = 'aviso'
              AND f.EntidadId   = :id
        ");
    $stmt->execute([':id' => $avisoId]);
    $fotoId = $stmt->fetchColumn();

    // 4) Borrar la foto para evitar registros huérfanos
    if ($fotoId) {
      $pdo->prepare("DELETE FROM fotos WHERE FotoId = :f")
        ->execute([':f' => $fotoId]);
    }

    // 5) Borrar el aviso
    $pdo->prepare("DELETE FROM avisos WHERE AvisoId = :id")
      ->execute([':id' => $avisoId]);

    // 6) Confirmar transacción
    $pdo->commit();

    // 7) Retornar alerta de éxito y redirigir
    return alertScript(
      '¡Éxito!',
      'Aviso eliminado correctamente.',
      'success'
    );

  } catch (Exception $e) {
    // En caso de error, revertir y notificar
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    return alertScript(
      'Error',
      'No se pudo eliminar el aviso: ' . $e->getMessage(),
      'error'
    );
  }
}

function getCarouselAvisos(PDO $pdo, int $tipo): string
{
  // 1) Fetch all campana-type avisos
  $sql = "
        SELECT 
            a.AvisoId,
            a.TituloAviso,
            a.Fecha,
            a.DescripcionAviso,
            f.FotoContenido
        FROM avisos a
        LEFT JOIN fotos f
          ON f.EntidadTipo = 'aviso'
         AND f.EntidadId   = a.AvisoId
        WHERE a.EsCampana = :tipo
        ORDER BY a.Fecha DESC
    ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['tipo' => $tipo]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // 2) If no records, render a placeholder
  if (empty($rows)) {
    return '<div class="carousel-item active text-center p-5">No hay campañas</div>';
  }

  // 3) Begin carousel container
  $carouselId = "avisosCarousel";
  $html = '<div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">';
  $html .= '<div class="carousel-inner mb-4">';

  // 4) Build each slide
  foreach ($rows as $i => $a) {
    // make first slide active
    $activeClass = $i === 0 ? ' active' : '';

    // thumbnail (base64 or fallback)
    if (!empty($a['FotoContenido'])) {
      $imgSrc = 'data:image/jpeg;base64,' . base64_encode($a['FotoContenido']);
    } else {
      $imgSrc = '../assets/img/small-logos/alerta.png';
    }

    // truncate to 152 chars
    $desc = strip_tags($a['DescripcionAviso']);
    if (mb_strlen($desc) > 150) {
      $desc = mb_substr($desc, 0, 150) . '…';
    }

    // safely escape title
    $title = htmlspecialchars($a['TituloAviso'], ENT_QUOTES, 'UTF-8');

    // build slide
    $html .= <<<HTML
    <div class="carousel-item{$activeClass}">
        <a href="../pages/campania_ext.php?avisoId={$a['AvisoId']}">
            <div 
                class="page-header min-vh-45 m-3 border-radius-md"
                style="background-image: url('{$imgSrc}'); background-size: cover;">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 my-auto">
                            <h4 class="text-white fadeIn2 fadeInBottom">{$title}</h4>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">{$desc}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
HTML;
  }

  // 5) Close inner and add controls
  $html .= <<<HTML
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#{$carouselId}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{$carouselId}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
HTML;

  return $html;
}

function editarAviso(array $post, PDO $pdo): string
{
  // 1) Sanitizar y validar
  $avisoId = filter_var($post['avisoId'] ?? null, FILTER_VALIDATE_INT);
  $titulo = trim(filter_var($post['avisoTitulo'] ?? '', FILTER_SANITIZE_STRING));
  $descrip = trim(filter_var($post['avisoDesc'] ?? '', FILTER_SANITIZE_STRING));

  if (!$avisoId || !$titulo || !$descrip) {
    return alertScript('Error', 'Faltan datos para editar.', 'error');
  }

  try {
    $pdo->beginTransaction();

    // 2) Actualizar título/desc/EsCampana
    $sql = "UPDATE avisos
                SET TituloAviso    = :titulo,
                    DescripcionAviso= :descrip
                WHERE AvisoId = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':titulo' => $titulo,
      ':descrip' => $descrip,
      ':id' => $avisoId,
    ]);

    // 3) ¿Hay foto nueva?
    if (
      isset($_FILES['avisoFoto']) &&
      $_FILES['avisoFoto']['error'] === UPLOAD_ERR_OK &&
      is_uploaded_file($_FILES['avisoFoto']['tmp_name'])
    ) {
      // Validar imagen
      $info = getimagesize($_FILES['avisoFoto']['tmp_name']);
      $allowed = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
      if ($info === false || !in_array($info[2], $allowed, true)) {
        throw new Exception('Formato de imagen no válido.');
      }

      // 4) Obtener y guardar contenido binario
      $contenido = file_get_contents($_FILES['avisoFoto']['tmp_name']);

      // 5) Insertar nueva foto
      $ins = $pdo->prepare("
                INSERT INTO fotos
                  (FotoContenido, EntidadTipo, EntidadId)
                VALUES
                  (:contenido, 'aviso', :id)
            ");
      $ins->execute([
        ':contenido' => $contenido,
        ':id' => $avisoId,
      ]);
      $newFotoId = $pdo->lastInsertId();

      // 6) Actualizar Avisos.FotoId al nuevo
      $pdo->prepare("
                UPDATE avisos
                SET FotoId = :f
                WHERE AvisoId = :id
            ")->execute([':f' => $newFotoId, ':id' => $avisoId]);

      // 7) Borrar foto anterior (FK en avisos ya apunta al nuevo)
      $old = $pdo->prepare("
                SELECT FotoId
                FROM fotos
                WHERE EntidadTipo='aviso'
                  AND EntidadId = :id
                  AND FotoId <> :new
                ORDER BY FotoId DESC
                LIMIT 1
            ");
      $old->execute([':id' => $avisoId, ':new' => $newFotoId]);
      if ($oldFoto = $old->fetchColumn()) {
        $pdo->prepare("DELETE FROM fotos WHERE FotoId = :f")
          ->execute([':f' => $oldFoto]);
      }
    }

    $pdo->commit();

    return alertScript(
      '¡Éxito!',
      'Información actualizada correctamente.',
      'success'
    );

  } catch (Exception $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    return alertScript(
      'Error',
      'No se pudo actualizar la información: ' . $e->getMessage(),
      'error'
    );
  }
}

/**
 * Obtiene un aviso/campaña por su ID.
 *
 * @param PDO $pdo Conexión PDO
 * @param int $avisoId ID del aviso
 * @return array|null Datos del aviso o null si no existe
 */
function getAvisoById(PDO $pdo, int $avisoId): ?array
{
  $sql = "
        SELECT 
            a.TituloAviso,
            a.DescripcionAviso,
            a.Fecha,
            u.NombreUsuario,
            u.ApellidoPaterno,
            f.FotoContenido
        FROM avisos a
        LEFT JOIN usuarios u
            ON u.UsuarioId = a.UsuarioId
        LEFT JOIN fotos f
            ON f.EntidadTipo = 'aviso'
           AND f.EntidadId     = a.AvisoId
        WHERE a.AvisoId = :id
        LIMIT 1
    ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id' => $avisoId]);
  $aviso = $stmt->fetch(PDO::FETCH_ASSOC);

  return $aviso !== false ? $aviso : null;
}

function getCarouselFelicitaciones(PDO $pdo): string
{
  // 1) Fetch all campana-type avisos
  $sql = "SELECT u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno, 
                   f.FelicitacionId, f.MensajeFelicitacion, foto.FotoContenido
            FROM felicitaciones f
            LEFT JOIN usuarios u ON u.UsuarioId = f.UsuarioId
            LEFT JOIN fotos foto ON foto.EntidadTipo = 'usuario'
                                 AND foto.EntidadId   = u.UsuarioId
            WHERE 1=1
    ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // 2) If no records, render a placeholder
  if (empty($rows)) {
    return '<div class="carousel-item">
              <div class="page-header min-vh-15 border-radius-lg">
                  <div class="card" data-animation="false"
                      style="background-image: url("https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80");">
                      <div class="card-body d-flex align-items-center w-100">
                          <div class="text-start flex-grow-1">
                              <h6 class="font-weight-bold text-primary mb-1">
                                  <a href="#" class="text-primary">¡Que tengas un gran día!
                                      <i class="material-symbols-rounded me-2 text-lg">celebration</i>
                                  </a>
                              </h6>
                              <small class="text-muted d-block">
                                  La vida es una aventura emocionante, vívela.
                              </small>
                          </div>
                      </div>
                  </div>
              </div>
          </div>';
  }

  // 3) Begin carousel container
  $carouselId = "carouselAvisos";
  $html = '<div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">';
  $html .= '<div class="carousel-inner">';

  // 4) Build each slide
  foreach ($rows as $i => $a) {
    // make first slide active
    $activeClass = $i === 0 ? ' active' : '';
    $full = "{$a['NombreUsuario']} {$a['ApellidoPaterno']}";

    // thumbnail (base64 or fallback)
    if (!empty($a['FotoContenido'])) {
      $imgSrc = 'data:image/jpeg;base64,' . base64_encode($a['FotoContenido']);
    } else {
      $imgSrc = '../assets/img/small-logos/user.png';
    }

    // build slide
    $html .= <<<HTML
    <div class="carousel-item{$activeClass}">
      <a href="#"
     data-bs-toggle="modal"
     data-bs-target="#felicitacionModal"
     data-usuario-id="{$a['UsuarioId']}"
     data-nombre="{$full}"
     data-mensaje="{$a['MensajeFelicitacion']}"
     data-foto="{$imgSrc}">
    <div class="page-header min-vh-15 border-radius-lg">
        <div class="card" data-animation="false"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <div class="card-body d-flex align-items-center w-100">
                <!-- Imagen al lado izquierdo -->
                <div class="me-3">
                    <img src="{$imgSrc}" alt="usuario" class="avatar-sm2">
                </div>
                <!-- Contenido textual centrado verticalmente -->
                <div class="text-start flex-grow-1">
                    <h6 class="font-weight-bold text-primary mb-1">¡Felicidades! {$full}
                            <i class="material-symbols-rounded me-2 text-lg">celebration</i>
                    </h6>
                    <small class="text-muted d-block">
                        {$a['MensajeFelicitacion']}
                    </small>
                </div>
            </div>
        </div>
    </div>
  </a>
</div>
HTML;
  }

  // 5) Close inner and add controls
  $html .= <<<HTML
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#{$carouselId}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{$carouselId}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
HTML;

  return $html;
}

function ActualizarPassword($password1, $password2, $UsuarioId, $pdo)
{

  $password1 = filter_var($password1, FILTER_SANITIZE_STRING);
  $password2 = filter_var($password2, FILTER_SANITIZE_STRING);

  if ($password1 !== $password2) {
    $error = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.',
                        icon: 'error'
                    }).then(() => {
                    window.location.href = '';
                });
            });
            </script>";
    return $error;
  }

  $hashed_password = password_hash($password1, PASSWORD_DEFAULT);


  try {
    // Inserción principal
    $stmt = $pdo->prepare("UPDATE usuarios SET 
            Contrasena = :password
        WHERE UsuarioId = :id");

    $stmt->execute([
      ':password' => $hashed_password,
      ':id' => $UsuarioId
    ]);

    $exito = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Contraseña actualizada exitosamente.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = '';
                    });
                });
            </script>";

    return $exito;

  } catch (PDOException $e) {
    echo "Error al actualizar los datos: " . $e->getMessage();
    $error = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrio un error inesperado.',
                        icon: 'error'
                    }).then(() => {
                    window.location.href = '';
                });
            });
            </script>";
    return $error;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizarPass'])) {
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  echo ActualizarPassword($password1, $password2, $_SESSION['user_id'], $pdo);

}

function getContenedorPuesto(int $id, PDO $pdo): string
{
  $sql = "SELECT u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno, p.PuestoNombre, f.FotoContenido FROM usuarios u LEFT JOIN puesto p ON u.PuestoId = p.PuestoId LEFT JOIN fotos f ON f.EntidadTipo = 'usuario' AND f.EntidadId = u.UsuarioId WHERE u.UsuarioId = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['id' => $id]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $html = '';
  foreach ($rows as $row) {
    $src = '../controllers/usuario_foto.php?id=' . $row['UsuarioId'] . '';

    $fullEscaped = htmlspecialchars(
      "{$row['NombreUsuario']} {$row['ApellidoPaterno']}",
      ENT_QUOTES,
      'UTF-8'
    );
    $puestoEscaped = htmlspecialchars($row['PuestoNombre'], ENT_QUOTES, 'UTF-8');

    $html .= "<p>
                <img src=\"{$src}\" alt=\"{$fullEscaped}\">
                <span class=\"text-xs font-weight-bold mb-0\">{$fullEscaped}</span>
                <span class=\"text-xs text-secondary mb-0\">{$puestoEscaped}</span>
              </p>";
  }
  return $html;
}

function getTableACargo(array $puestos, array $bases, PDO $pdo): string
{
    // Normalizar arrays
    $puestos = array_values(array_map('intval', array_filter($puestos, 'strlen')));
    $bases = array_values(array_map('trim', array_filter($bases, 'strlen')));

    $whereParts = [];
    $params = [];

    if (!empty($puestos)) {
        $ph = [];
        foreach ($puestos as $i => $p) {
            $key = ":p{$i}";
            $ph[] = $key;
            $params[$key] = $p;
        }
        $whereParts[] = 'u.PuestoId IN (' . implode(',', $ph) . ')';
    }

    if (!empty($bases)) {
        $phb = [];
        foreach ($bases as $i => $b) {
            $key = ":b{$i}";
            $phb[] = $key;
            $params[$key] = $b;
        }
        $whereParts[] = 'u.Base IN (' . implode(',', $phb) . ')';
    }

    if (empty($whereParts)) {
        return '<tr><td colspan="2" class="text-center">Sin registros</td></tr>';
    }

    $where = implode(' AND ', $whereParts);

    $sql = "SELECT u.UsuarioId, u.NombreUsuario, u.ApellidoPaterno, u.ApellidoMaterno, p.PuestoNombre, u.Base, f.FotoContenido
            FROM usuarios u
            LEFT JOIN puesto p ON u.PuestoId = p.PuestoId
            LEFT JOIN fotos f ON f.EntidadTipo = 'usuario' AND f.EntidadId = u.UsuarioId
            WHERE ($where) AND u.UsuarioActivo = 1
            ORDER BY p.PuestoNombre ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        return '<tr><td colspan="2" class="text-center">Sin registros</td></tr>';
    }

    $html = '';
    foreach ($rows as $u) {
        $src = '../controllers/usuario_foto.php?id=' . $u['UsuarioId'] . '';

        $full = htmlspecialchars("{$u['NombreUsuario']} {$u['ApellidoPaterno']} {$u['ApellidoMaterno']}", ENT_QUOTES, 'UTF-8');
        $puesto = htmlspecialchars($u['PuestoNombre'] ?? 'Sin registros', ENT_QUOTES, 'UTF-8');

        $html .= '<tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <img src="' . $src . '" class="avatar avatar-sm me-3 border-radius-lg" alt="' . $full . '">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">' . $full . '</h6>
                          <p class="text-xs text-secondary mb-0"> Base ' . htmlspecialchars($u['Base'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">' . $puesto . '</p>
                    </td>
                  </tr>';
    }

    return $html;
}

function getModalSubordinados(string $modalId, array $puestos, array $bases, PDO $pdo): void
{
    // Normalizar inputs para usar en atributos y en la consulta
    $puestosClean = array_values(array_map('intval', array_filter($puestos, 'strlen')));
    $basesClean = array_values(array_map('trim', array_filter($bases, 'strlen')));
  
    // Generar filas ya en servidor
    $rowsHtml = getTableACargo($puestosClean, $basesClean, $pdo);

    // Imprimir modal (Bootstrap 5)
    echo '<div class="modal fade" id="' .$modalId . '" tabindex="-1" aria-labelledby="' . htmlspecialchars($modalId, ENT_QUOTES, 'UTF-8') . 'Label" aria-hidden="true">';
    echo '  <div class="modal-dialog modal-lg" role="document">';
    echo '    <div class="modal-content">';
    echo '      <div class="modal-header">';
    echo '        <h5 class="modal-title" id="' . htmlspecialchars($modalId, ENT_QUOTES, 'UTF-8') . 'Label">Gente a cargo</h5>';
    echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '      </div>';
    echo '      <div class="modal-body">';
    echo '        <div class="table-responsive p-0">';
    echo '          <table class="table align-items-center mb-0">';
    echo '            <thead>';
    echo '              <tr>';
    echo '                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre completo</th>';
    echo '                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Puesto</th>';
    echo '              </tr>';
    echo '            </thead>';
    echo '            <tbody>';
    echo                $rowsHtml;
    echo '            </tbody>';
    echo '          </table>';
    echo '        </div>';
    echo '      </div>';
    echo '      <div class="modal-footer">';
    echo '        <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Cerrar</button>';
    echo '      </div>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';

}