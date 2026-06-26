<?php
require '../controllers/logica_vacantes.php';
$alertHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Registro de recomedación (formulario principal flotante)
  if (isset($_POST['recomendarAAlguien'])) {
    $alertHtml = registrarRecomendacion($pdo, $_POST, $_FILES['CVRecomendado']);
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
  <title>
    RH | Vacantes
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
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
          <a class="nav-link text-primary" href="../pages/panel_candidatos.php">
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vacantes</li>
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
                <img class="avatar avatar-lg  me-3" <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?>>
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
                <li>
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
                Vacantes
              </h3>
              <p class="mb-0 font-weight-normal text-sm">
                Éstas son las vacantes activas por el momento:
              </p>
            </div>
          </div>
          <div class="card-body p-3">
            <div class="card-body pt-4 p-3">
              <ul class="list-group">
                <?= getVistaVacantes($pdo) ?>
              </ul>
              <br>
            </div>
            <p class="mb-0 font-weight-normal text-sm">
              Si refieres a un candidato que sea contratado y permanezca en la empresa durante al menos cuatro meses, al
              cuarto mes recibirás un bono de $500 pesos como agradecimiento por tu recomendación.</p>
              <br>
               <p class="mb-0">🔹 ¿Cómo participar?</p>
            <p class="mb-0 font-weight-normal text-sm">
              1. Recomienda a un candidato que cumpla con el perfil del puesto.</p>
            <p class="mb-0 font-weight-normal text-sm">
              2. Asegúrate de que indique tu nombre como referencia en su proceso de selección.</p>
            <p class="mb-0 font-weight-normal text-sm">
              3. Si es contratado y cumple tres meses en la empresa, recibirás tu bono al cuarto mes.</p>              
            <p class="mb-0 font-weight-normal text-sm">
              El programa de referidos está abierto a todos nuestros empleados exceptuando a directivos, responsables de
              área, personal de recursos humanos y cualquier colaborador asociado con el proceso de selección de
              candidatos. A quién puedes recomendar: Candidatos que actualmente no están empleados en la empresa y que no han
              solicitado un puesto en FastNet.
              </p>
              <br>
            <p class="mb-0 font-weight-normal text-sm">
              Reglas adicionales del programa.</p>
            <p class="mb-0 font-weight-normal text-sm">
              • Las personas referidas deben enviarse al departamento de recursos humanos e incluir el título del
              trabajo y el código de referencia, el nombre completo del candidato, el nombre completo y los datos de
              contacto laboral del empleado que hace la recomendación, y el currículum del aspirante.</p>
            <p class="mb-0 font-weight-normal text-sm">
              • Si un candidato es recomendado por más de un empleado, sólo el primero que lo refirió es elegible para
              el recibir el bono.</p>
            <p class="mb-0 font-weight-normal text-sm">
              • Sólo se pueden referir candidatos para ofertas de trabajo que se hayan publicado oficialmente.</p>
            <p class="mb-0 font-weight-normal text-sm">
              • Los pagos de la bonificación sólo se otorgan después de que el candidato referido haya sido empleado y
              haya completado con éxito su período de prueba en la empresa.
              </p>
            <p class="mb-0 font-weight-normal text-sm">
              • No hay límite en la cantidad de candidatos que puede recomendar un empleado.
              </p>
            <p class="mb-0 font-weight-normal text-sm">
              ¡Anímate a invitar a personas que compartan nuestros valores y ganas de crecer! Para más información,
              puedes contactar al área de Recursos Humanos.</p>
              <br>
            <p class="mb-0 font-weight-normal text-sm">
              📌 Juntos seguimos creciendo como equipo. ¡Tu recomendación vale!
            </p>
          </div>
        </div>
      </div>
    </div>

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

  <!-- MODAL PARA MANDAR LA INFORMACIÓN-->
  <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true"
    data-usuario-id="<?= $_SESSION['user_id'] ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Información</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form role="form text-left" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <p class="mb-0">Deja la información de la persona para ponernos en contacto.</p>
            <input type="hidden" name="VacanteId" value="">
            <input type="hidden" name="UsuarioId" value="">
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Nombre</label>
              <input type="text" name="nombreRecomendado" class="form-control" onfocus="focused(this)"
                onfocusout="defocused(this)">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Teléfono</label>
              <input type="tel" name="telefonoRecomendado" class="form-control" onfocus="focused(this)"
                onfocusout="defocused(this)">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Email</label>
              <input type="email" name="emailRecomendado" class="form-control" onfocus="focused(this)"
                onfocusout="defocused(this)">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label"></label>
              <input type="file" name="CVRecomendado" class="form-control" onfocus="focused(this)"
                onfocusout="defocused(this)">
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" name="recomendarAAlguien"
              class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">
              Enviar
            </button>
          </div>
          <?= $alertHtml ?>
        </form>
      </div>
    </div>
  </div>
  <script>
    const modal = document.getElementById('modal-form');

    modal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const vacanteId = button.getAttribute('data-vacante-id');
      const usuarioId = button.getAttribute('data-usuario-id');

      modal.querySelector('input[name="VacanteId"]').value = vacanteId;
      modal.querySelector('input[name="UsuarioId"]').value = usuarioId;
    });
  </script>
  <!--FIN DEL MODAL-->
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
</body>

</html>