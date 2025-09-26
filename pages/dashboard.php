<?php
require '../controllers/dashboard.php';

$alertHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Registro de usuario (formulario principal flotante) 
  if (isset($_POST['mandarMensaje'])) {
    $alertHtml = registrarQueja($_POST, $pdo);
  }

  if (isset($_POST['borrarQueja'])) {
    $alertHtml = borrarQueja($_POST, $pdo);
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <style>

  </style>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
  <title>
    Recursos Humanos | Inicio
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/calendario.css">
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
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Administrador</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/usuarios.php">
            <i class="material-symbols-rounded opacity-5">groups</i>
            <span class="nav-link-text ms-1">Usuarios</span>
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
            ' . mostrarContador($pdo) . '
        </div>
    </div>
  </aside>';
  }
  ?>

  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Inicio</li>
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
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> class="avatar avatar-lg me-3">
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
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

    <div class="container-fluid py-2">

      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h3 font-weight-bolder">Dashboard</h3>
        </div>
      </div>
      <div class="row">

        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card">
            <div class="card card-body">
              <div class="row gx-4 mb-2">
                <div class="col-auto">
                  <div class="avatar avatar-xl position-relative">
                    <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> alt="profile_image"
                      class="w-100 border-radius-lg shadow-sm">
                  </div>
                </div>
                <div class="col-auto my-auto">
                  <div class="h-100">
                    <h5 class="mb-1">
                      <?php echo $sesion['NombreUsuario']; ?>
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                      <?php echo $sesion['DepartamentoNombre'] ?? 'Sin departamento' ?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="row">
                  <h6 class="mb-0">¡Sé bienvenid@!</h6>
                  <h6 class="mb-0" id="fechaCompleta"></h6>
                  <a href="http://45.188.76.34:8081/" target="_blank"> <img class="border-radius-lg w-50"
                      src="../assets/img/BIOTIME.png" alt=""> </a>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="row">
                <div class="col-md-auto mx-auto">
                  <div id="carouselAvisos" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <?= getCarouselFelicitaciones($pdo) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Cumpleaños</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                  <i class="material-symbols-rounded me-2 text-lg">cake</i>
                  <small id="month-year"></small>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="calendar">
                <div class="weekdays">
                  <div>Dom</div>
                  <div>Lun</div>
                  <div>Mar</div>
                  <div>Mie</div>
                  <div>Jue</div>
                  <div>Vie</div>
                  <div>Sab</div>
                </div>
                <div class="days mb-0 font-weight-normal text-sm" id="days"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Vacaciones</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                  <i class="material-symbols-rounded me-2 text-lg">do_not_disturb_on</i>
                  <small>No molestar &nbsp; </small>
                </div>
              </div>
            </div>
            <div class="card-body p-3 timeline timeline-one-side scrollable-timeline">
              <div class="timeline timeline-one-side">
                <?= GetTimelineVacaciones($pdo) ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Avisos</h6>
                  <br><br>
                </div>
                <div class="card-group">
                  <?= getAvisosDash($pdo) ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Campañas</h6>
            </div>
            <div class="card-body p-3">
              <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner mb-4">
                  <?= getCarouselAvisos($pdo, "1") ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <footer class="footer py-4  ">
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
  </div>

  <?php
  if ($sesion['DepartamentoId'] === 11) {
    echo '<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-4 py-2">
      <i class="material-symbols-rounded py-3">local_post_office</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Buzón de quejas</h5>
          <!--<p>¿Tienes alguna inconformidad?</p>-->
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidenav Type -->
        <div class="mt-3 timeline timeline-one-side scrollable-timeline1">
          <ul class="list-group">
            ' . GetBuzonQuejas($pdo) . '
          </ul>
        </div>
        <!-- Navbar Fixed -->
        <hr class="horizontal dark my-sm-4">
        <div class="w-100 text-center">
        </div>
      </div>
    </div>
  </div>';
  } else {
    echo '<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-4 py-2">
      <i class="material-symbols-rounded py-3">mail</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Buzón de quejas</h5>
          <p>¿Tienes alguna inconformidad?</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>        
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <form method="POST">
         <input type="hidden" name="UsuarioId" id="mensaje-UsuarioId" value="' . $_SESSION['user_id'] . '">
        <div>
          <h6 class="mb-0">Deja tu comentario aquí</h6>
        </div>
        <div class="mt-3">
          <div class="input-group input-group-dynamic">
            <textarea name="mensajeContenido" class="input-group input-group-outline mb-4" rows="12"
              placeholder="Describe cuál es la situación y nos pondremos en contacto contigo, recuerda que es confidencial."
              spellcheck="false"></textarea>
          </div>
        </div>        
        <hr class="horizontal dark my-sm-4">
        <div class="w-100 text-center">
          <button type="submit" name="mandarMensaje" class="btn btn-dark mb-0 me-2">
            Enviar
          </button>
        </div>
      </form>
      ' . $alertHtml . '
      </div>
    </div>
  </div>';
  }
  ?>


  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
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
  <script src="../assets/js/calendario.js"></script>
  <script>
    function obtenerMesActual() {
      const fecha = new Date();
      const numeroMes = fecha.getMonth() + 1;
      const nombresMeses = [
        "enero", "febrero", "marzo", "abril", "mayo", "junio",
        "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
      ];
      const diasSemana = [
        "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"
      ];

      const nombreMes = nombresMeses[fecha.getMonth()];
      const diaSemana = diasSemana[fecha.getDay()];
      const diaMes = fecha.getDate();
      const año = fecha.getFullYear();

      const fechaCompleta = `${diaSemana}, ${diaMes} de ${nombreMes} del ${año}`;

      return {
        numero: numeroMes,
        nombre: nombreMes,
        fechaCompleta: fechaCompleta
      };
    }

    // Mostrar en HTML
    const mesActual = obtenerMesActual();
    //document.getElementById("mes").textContent = `${mesActual.nombre}`;//${mesActual.numero} - para cuando se mande a pedir por php
    document.getElementById("fechaCompleta").textContent = mesActual.fechaCompleta;
  </script>

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

  <!-- Modal Ver Queja -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLongTitle">Mensaje enviado por: </h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body font-weight-light">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-icon btn-2 btn-primary btn-mail">
            <i class="material-symbols-rounded">mail</i>
          </button>
          <button type="button" class="btn btn-icon btn-2 btn-primary btn-phone">
            <i class="material-symbols-rounded">phone_enabled</i>
          </button>

        </div>
      </div>
    </div>
  </div>
  <!--FIN DEL MODAL VER QUEJA-->
  <!-- MODAL NOTIFICACIÓN BORRADO -->
  <div class="modal fade" id="modal-notification" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="material-symbols-rounded text-danger me-2">warning</i>
          <h6 class="modal-title">Alerta</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <i class="material-symbols-rounded h1 text-secondary">Borrar Mensaje</i>
          <h4 class="text-danger mt-4">Atención</h4>
          <p>
            Está a punto de borrar el mensaje de
            <strong><span id="modal-username">@Nombre_usuario</span></strong>,
            ¿Está seguro que desea continuar?
          </p>
        </div>
        <div class="modal-footer">
          <form id="deleteForm" method="POST">
            <input type="hidden" name="QuejaId" id="delete-quejaid" value="">
            <button type="submit" name="borrarQueja" class="btn bg-gradient-primary">Sí, continuar</button>
          </form>
          <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN DEL MODAL NOTIFICACIÓN BORRADO -->
  <script>
    // Espera a que el DOM y Bootstrap estén listos
    document.addEventListener('DOMContentLoaded', function () {
      var modalEl = document.getElementById('exampleModalLong');

      modalEl.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        var nombre = btn.getAttribute('data-nombre');
        var mensaje = btn.getAttribute('data-mensaje');
        var email = btn.getAttribute('data-email');
        var telefono = btn.getAttribute('data-telefono');

        // Elementos del modal
        var tituloEl = modalEl.querySelector('.modal-title');
        var bodyEl = modalEl.querySelector('.modal-body');
        var btnMail = modalEl.querySelector('.btn-mail');
        var btnPhone = modalEl.querySelector('.btn-phone');

        // Actualizar contenido
        tituloEl.textContent = 'Mensaje enviado por: ' + nombre;
        bodyEl.textContent = mensaje;

        // Mostrar u ocultar botones según datos
        btnMail.style.display = email ? '' : 'none';
        btnPhone.style.display = telefono ? '' : 'none';

        // Asignar acciones
        btnMail.onclick = () => window.location.href = 'mailto:' + email;
        btnPhone.onclick = () => window.location.href = 'https://wa.me/' + telefono;
      });
    });
  </script>
  <script>
    // Captura el modal y escucha cuando se abre
    var deleteModal = document.getElementById('modal-notification');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      // El botón que disparó el modal
      var btn = event.relatedTarget;
      // Extraemos los data-attributes
      var nombre = btn.getAttribute('data-nombre');
      var quejaId = btn.getAttribute('data-quejaid');

      // Actualizamos el texto del nombre
      deleteModal.querySelector('#modal-username').textContent = nombre;

      // Asignamos el ID al campo oculto del formulario
      document.getElementById('delete-quejaid').value = quejaId;
    });
  </script>
  <!-- Modal -->
  <div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60vw;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Calendario completo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <!-- Aquí inyectaremos el calendario -->
          <div id="modalCalendarBody"></div>
        </div>
      </div>
    </div>
  </div>
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
              <input type="password" name="password1" autocomplete="new-password" autofocus="" class="form-control"
                required="" id="id_password1" onfocus=" focused(this)" onfocusout="defocused(this)">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Repetir contraseña</label>
              <input type="password" name="password2" autocomplete="new-password" class="form-control" required=""
                id="id_password2" onfocus="focused(this)" onfocusout="defocused(this)">
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
  <!-- MODAL PARA VER MÁS SOBRE LA FELICITACIÓN -->
  <div class="modal fade" id="felicitacionModal" tabindex="-1" role="dialog" aria-labelledby="modal-default"
    aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title font-weight-normal" id="modal-title-default">¡Felicidades!</h6>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
            the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large
            language ocean.</p>
          <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a
            paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link  ml-auto" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>