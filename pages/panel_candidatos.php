<?php
require '../controllers/logica_usuario.php';
// 1) Inicializamos la variable donde guardaremos el <script> de SweetAlert
$alertHtml = '';

// 2) Si viene un POST, determinamos si es registro o actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Registro de usuario (formulario principal flotante)
    if (isset($_POST['registrarU'])) {
        $alertHtml = RegistrarUsuarioCompleto($_POST, $pdo);
    }

    // Actualización de usuario (modal de edición)
    elseif (isset($_POST['updateUser'])) {
        $alertHtml = actualizarUsuario($_POST, $pdo);
    }

    // Vacaciones de usuario (formulario principal flotante)
    if (isset($_POST['RegistrarV'])) {
        $alertHtml = RegistrarVacaciones($_POST, $pdo);
    }


}

$filterName = trim($_GET['nombre'] ?? '');
// 3) Traemos departamentos para poblar ambos selects
$departamentos = GetDepartamento($pdo);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <title>
        RH | Documentos de candidatos
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

    <?php
    if ($sesion['EsAdmin'] === 1) {
        echo '<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="../pages/dashboard.php" target="_blank">
        <img src="../assets/img/favicon.ico" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Recursos Humanos</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Inicio</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.php">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.php">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.php">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.php">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.php">
            <i class="material-symbols-rounded opacity-5">psychology</i>
            <span class="nav-link-text ms-1">Valores</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/usuarios.php">
            <i class="material-symbols-rounded opacity-5">groups</i>
            <span class="nav-link-text ms-1">Usuarios</span>
          </a>
        </li>        
        <li class="nav-item">
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/panel_candidatos.php">
            <i class="material-symbols-rounded opacity-5">group_add</i>
            <span class="nav-link-text ms-1">Candidatos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/avisos.php">
            <i class="material-symbols-rounded opacity-5">add_alert</i>
            <span class="nav-link-text ms-1">Avisos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/felicitaciones.php">
            <i class="material-symbols-rounded opacity-5">celebration</i>
            <span class="nav-link-text ms-1">Felicitaciones</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/campanias.php">
            <i class="material-symbols-rounded opacity-5">campaign</i>
            <span class="nav-link-text ms-1">Campañas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/panel_vacantes.php">
            <i class="material-symbols-rounded opacity-5">explore</i>
            <span class="nav-link-text ms-1">Vacantes</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Contenido
            adicional</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/manuales.php">
            <i class="material-symbols-rounded opacity-5">collections_bookmark</i>
            <span class="nav-link-text ms-1">Capacitaciones | Manuales</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/nom035.php">
            <i class="material-symbols-rounded opacity-5">comment</i>
            <span class="nav-link-text ms-1">NOM-35</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn btn-outline mt-4 w-100 text-primary">
            <i class="material-symbols-rounded opacity-5">explore</i>
            <span class="nav-link-text ms-1">Vacantes</span>
            </a>
            ' . mostrarContador($pdo) . '
        </div>
    </div>
  </aside>';
    } elseif ($sesion['EsAdmin'] === 0) {
        echo '<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="../pages/dashboard.php" target="_blank">
        <img src="../assets/img/favicon.ico" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Recursos Humanos</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Inicio</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.php">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.php">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.php">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.php">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.php">
            <i class="material-symbols-rounded opacity-5">psychology</i>
            <span class="nav-link-text ms-1">Valores</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Contenido
            adicional</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/manuales.php">
            <i class="material-symbols-rounded opacity-5">collections_bookmark</i>
            <span class="nav-link-text ms-1">Capacitaciones | Manuales</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/nom035.php">
            <i class="material-symbols-rounded opacity-5">comment</i>
            <span class="nav-link-text ms-1">NOM-35</span>
          </a>
        </li>

      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline mt-4 w-100 text-primary">
          <i class="material-symbols-rounded opacity-5">explore</i>
          <span class="nav-link-text ms-1">Vacantes</span>
        </a>
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.php" type="button">
          <span class="nav-link-text ms-1">Comercial</span>
          <i class="material-symbols-rounded opacity-5">groups</i>
          <span id="contador_vacantes">4</span>
          <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
        </a>
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.php" type="button">
          <span class="nav-link-text ms-1">Técnico</span>
          <i class="material-symbols-rounded opacity-5">groups</i>
          <span id="contador_vacantes">4</span>
          <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
        </a>
      </div>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn btn-outline mt-4 w-100 text-primary">
            <i class="material-symbols-rounded opacity-5">explore</i>
            <span class="nav-link-text ms-1">Vacantes</span>
            </a>
            ' . mostrarContador($pdo) . '
        </div>
    </div>
  </aside>';
    }
    ?>
    <!-- CONTENIDO DEL BODY -->
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Candidatos</li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav d-flex align-items-center  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="avatar avatar-lg  me-3" <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?>>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="../pages/profile.php">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">user_attributes</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Perfil
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-password">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">password</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Cambiar contraseña</h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal"
                                        data-bs-target="#logoutModal">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="material-symbols-rounded">logout</i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Salir</h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h3 class="mb-0 h3 font-weight-bolder">
                                Lista de documentos de Candidatos
                            </h3>
                            <p class="mb-0 font-weight-normal text-sm">
                                Consulte, descargue y elimine los documentos de los candidatos en el sistema.
                            </p>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0 panel">
                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Nombre del candidato</label>
                                            <input type="text" name="nombre" class="form-control"
                                                value="<?= htmlspecialchars($filterName) ?>">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-icon btn-3 btn-primary" type="submit">
                                    <span class="btn-inner--icon"><i class="material-symbols-rounded">search</i></span>
                                    <span class="btn-inner--text">Buscar</span>
                                </button>
                                <button class="btn btn-icon btn-2 btn-primary" type="button"
                                    onclick="window.location.href='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>'">
                                    <span class="btn-inner--icon"><i class="material-symbols-rounded">Close</i></span>
                                </button>
                            </form>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Prueba C</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Test de ZAVIC</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Socioeconómico</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Formato Médico</th>
                                        <th class="text-secondary opacity-7 ps-2"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Parámetros de paginación
                                    $page = max(1, (int) ($_GET['page'] ?? 1));
                                    $perPage = 10; // puedes hacerlo configurable
                                    $offset = ($page - 1) * $perPage;

                                    // llamar a la función nueva
                                    $result = GetCandidatosPagina($pdo, $filterName, $perPage, $offset);
                                    $rows = $result['rows'];
                                    $total = $result['total'];
                                    $totalPages = (int) ceil($total / $perPage);

                                    // Si no hay filas
                                    if (empty($rows)) {
                                        echo '<tr><td colspan="6" class="text-center">Sin registros</td></tr>';
                                    } else {
                                        foreach ($rows as $u) {
                                            // inicializar variables por columna
                                            $pruebaC = $testZavic = $estudioSocio = $formatoMedico = null;

                                            // recorrer pruebas y asignar según coincidencias en nombre o ruta
                                            foreach ($u['pruebas'] as $p) {
                                                $nombre = strtolower($p['PruebaNombre'] ?? $p['PruebaRuta'] ?? '');
                                                $ruta = $p['PruebaRuta'] ?? '';

                                                if (strpos($nombre, 'pruebac') !== false || strpos($ruta, 'PruebaC') !== false || strpos($nombre, 'prueba c') !== false) {
                                                    $pruebaC = $ruta;
                                                    continue;
                                                }
                                                if (strpos($nombre, 'zavic') !== false || strpos($ruta, 'ZAVIC') !== false || strpos($nombre, 'testzavic') !== false) {
                                                    $testZavic = $ruta;
                                                    continue;
                                                }
                                                if (strpos($nombre, 'estudio') !== false || strpos($nombre, 'socio') !== false || strpos($ruta, 'EstudioSocio') !== false) {
                                                    $estudioSocio = $ruta;
                                                    continue;
                                                }
                                                if (strpos($nombre, 'formmed') !== false || strpos($nombre, 'formato') !== false || strpos($ruta, 'FormMedic') !== false || strpos($ruta, 'FormMedic') !== false) {
                                                    $formatoMedico = $ruta;
                                                    continue;
                                                }

                                            }

                                            // sanitizar texto
                                            $nombreCompleto = htmlspecialchars($u['NombreCompleto']);
                                            $base = htmlspecialchars($u['BaseAplica']);
                                            $puesto = htmlspecialchars($u['PuestoAplica'] ?? 'No disponible');

                                            echo '<tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">' . $nombreCompleto . '</h6>
                                                                <p class="text-xs text-secondary mb-0">Base que aplica: ' . $base . '</p>
                                                                <p class="text-xs text-secondary mb-0">Puesto: ' . $puesto . '</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">';

                                            // Prueba C
                                            if ($pruebaC) {
                                                echo '<button type="button" class="btn btn-success btn-sm" onclick="window.location.href=\'' . htmlspecialchars($pruebaC) . '\'">Descargar Prueba C</button>';
                                            } else {
                                                echo '<span class="text-muted small">Sin documento</span>';
                                            }

                                            echo '</td><td class="text-center">';

                                            // Test de ZAVIC
                                            if ($testZavic) {
                                                echo '<button type="button" class="btn btn-info btn-sm" onclick="window.location.href=\'' . htmlspecialchars($testZavic) . '\'">Descargar Cuestionario</button>';
                                            } else {
                                                echo '<span class="text-muted small">Sin documento</span>';
                                            }

                                            echo '</td><td class="text-center">';

                                            // Estudio socioeconómico
                                            if ($estudioSocio) {
                                                echo '<button type="button" class="btn btn-danger btn-sm" onclick="window.location.href=\'' . htmlspecialchars($estudioSocio) . '\'">Descargar Estudio</button>';
                                            } else {
                                                echo '<span class="text-muted small">Sin documento</span>';
                                            }

                                            echo '</td><td class="text-center">';

                                            // Formato Médico
                                            if ($formatoMedico) {
                                                echo '<button type="button" class="btn btn-warning btn-sm" onclick="window.location.href=\'' . htmlspecialchars($formatoMedico) . '\'">Descargar Formato</button>';
                                            } else {
                                                echo '<span class="text-muted small">Sin documento</span>';
                                            }

                                            echo '</td>
                                                    <td class="align-middle">
                                                        <!-- botón eliminar u otras acciones aquí -->
                                                        <a href="#" class="text-danger font-weight-bold text-xs btn-delete-candidato"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-notification"
                                                            data-candidato-id="' . (int) $u['CandidatoId'] . '"
                                                            data-candidato-nombre="' . htmlspecialchars($u['NombreCompleto'], ENT_QUOTES) . '">
                                                            <i class="material-symbols-rounded opacity-5">delete</i>
                                                        </a>
                                                    </td>
                                                  </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            // Construir base de query (preserva filtros)
                            $queryBase = [];
                            if ($filterName !== '')
                                $queryBase['nombre'] = $filterName;
                            ?>
                            <nav aria-label="Paginación usuarios" class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $buildUrl = function ($p) use ($queryBase) {
                                        $qp = array_merge($queryBase, ['page' => $p]);
                                        return '?' . http_build_query(data: $qp);
                                    };

                                    // Prev
                                    $prevDisabled = $page <= 1 ? ' disabled' : '';
                                    echo '<li class="page-item' . $prevDisabled . '"><a class="page-link" href="' . ($page > 1 ? $buildUrl($page - 1) : '#') . '"><</a></li>';

                                    // Páginas (limitar cantidad mostrada, p.ej. 7 botones)
                                    $maxButtons = 7;
                                    $start = max(1, $page - intval($maxButtons / 2));
                                    $end = min($totalPages, $start + $maxButtons - 1);
                                    if ($end - $start + 1 < $maxButtons) {
                                        $start = max(1, $end - $maxButtons + 1);
                                    }
                                    for ($i = $start; $i <= $end; $i++) {
                                        $active = $i === $page ? ' active' : '';
                                        echo '<li class="page-item' . $active . '"><a class="page-link" href="' . $buildUrl($i) . '">' . $i . '</a></li>';
                                    }

                                    // Next
                                    $nextDisabled = $page >= $totalPages ? ' disabled' : '';
                                    echo '<li class="page-item' . $nextDisabled . '"><a class="page-link" href="' . ($page < $totalPages ? $buildUrl($page + 1) : '#') . '">></a></li>';
                                    ?>
                                </ul>
                            </nav>

                            <?php
                            $startRow = $offset + 1;
                            $endRow = min($offset + $perPage, $total);
                            echo "<p class=\"text-muted\">Mostrando {$startRow}–{$endRow} de {$total}</p>";
                            ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="footer py-4 ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            Desarrollado por
                            <a href="https://www.fast-net.com.mx" class="font-weight-bold" target="_blank">FastNet</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script src="../assets/js/settings.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="logoutModalLabel">Cerrar sesión</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <p>Estás a punto de cerrar sesión.</p>
                        <p>¿Seguro que quieres continuar?</p>
                    </div>
                    <div class="modal-footer">
                        <button name="cerrarSesion" type="submit" class="btn bg-gradient-primary">Cerrar
                            sesión</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End logout modal-->

    <!--MODAL CAMBIAR CONTRASEÑA-->
    <div class="modal fade" id="modal-password" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form text-left" method="post">
                    <div class="modal-body">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password" name="password1" autocomplete="new-password" autofocus=""
                                class="form-control" required="" id="id_password1" onfocus=" focused(this)"
                                onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Repetir contraseña</label>
                            <input type="password" name="password2" autocomplete="new-password" class="form-control"
                                required="" id="id_password2" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="actualizarPass" class="btn bg-gradient-primary">Cambiar</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--FIN DEL MODAL PARA CAMBIAR CONTRASEÑA-->

    <!-- MODAL NOTIFICACIÓN BORRADO -->
    <div class="modal fade" id="modal-notification" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="material-symbols-rounded text-danger me-2">warning</i>
                    <h6 class="modal-title">Alerta</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-delete-user" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="modal-body text-center">
                        <i class="material-symbols-rounded h1 text-secondary">Eliminar Candidato</i>
                        <h4 class="text-gradient text-danger mt-4">Atención</h4>
                        <p>Está a punto de borrar a <strong id="modal-username"></strong>, ¿desea continuar?</p>
                        <input type="hidden" name="delete_candidato_id" id="delete-candidato-id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="confirm_delete_candidato" class="btn bg-gradient-primary">Sí,
                            continuar.</button>
                        <button type="button" class="btn btn-link text-primary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN DEL MODAL -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete-candidato').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    var id = this.getAttribute('data-candidato-id');
                    var nombre = this.getAttribute('data-candidato-nombre') || '';
                    document.getElementById('delete-candidato-id').value = id;
                    document.getElementById('modal-username').textContent = nombre;
                });
            });
        });
    </script>
</body>

</html>