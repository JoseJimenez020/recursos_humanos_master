<?php
require '../controllers/dashboard.php';
$alertHtml = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['regAviso'])) {
    $alertHtml = registrarAviso($_POST, $pdo);
  }

  if (isset($_POST['borrarAviso'])) {
    $alertHtml = borrarAviso($_POST, $pdo);
  }

  if (isset($_POST['editarAviso'])) {
    $alertHtml = editarAviso($_POST, $pdo);
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
    RH | Control de Campañas
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
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
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/campanias.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Campañas</li>
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
                <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> class="avatar avatar-lg  me-3 ">
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
    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal" data-bs-target="#modal-password">
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
    <a class="dropdown-item border-radius-md" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
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

    <div class="container-fluid py-2">

      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h3 font-weight-bolder">Campañas</h3>
        </div>

      </div>
      <div class="row ">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Campañas activas</h6>
                  <br><br>
                </div>
                <div class="card-body">
                  <div class="row">
                    <?= getAvisosPanel($pdo, '1') ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Agregar campaña</h6>
            </div>
            <div class="card-body p-3">
              <form method="POST" enctype="multipart/form-data">
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Título</label>
                  <input type="text" name="avisoTitulo" class="form-control">
                </div>
                <div class="input-group input-group-dynamic">
                  <textarea class="form-control" name="avisoDesc" rows="5"
                    placeholder="Escribe una pequeña de lo que trata la campaña. El tamaño recomendado de la imagen es de 800 x 533 px."
                    spellcheck="false"></textarea>
                </div>
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Foto</label>
                  <input type="file" name="avisoFoto" class="form-control">
                </div>
                <input type="hidden" name="esAviso" value="1">
                <div class="text-center">
                  <button type="submit" name="regAviso"
                    class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0 toast-btn"
                    data-target="successToast">Registrar
                    campaña</button>
                </div>
                <?= $alertHtml ?>
              </form>
            </div>
          </div>
        </div>

        <!--MODAL PARA EDITAR AVISO-->
        <div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title">Editar Campaña</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- Campo oculto para el ID -->
                  <input type="hidden" name="avisoId" id="edit-aviso-id">
                  <div class="input-group my-3 input-group-outline">
                    <label class="form-label">Título del aviso</label>
                    <input type="text" name="avisoTitulo" id="edit-aviso-title" class="form-control">
                  </div>
                  <div class="input-group input-group-dynamic mb-3">
                    <textarea name="avisoDesc" id="edit-aviso-desc" class="form-control" rows="4"
                      placeholder="Descripción..."></textarea>
                  </div>
                  <div class="mb-3 text-center">
                    <img src="" id="edit-aviso-img-preview" class="img-fluid shadow border-radius-lg"
                      style="max-height:200px;" alt="Foto actual">
                  </div>
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Cambiar foto (opcional)</label>
                    <input type="file" name="avisoFoto" id="edit-aviso-file" class="form-control">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="editarAviso" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    data-target="successToast">
                    Guardar cambios
                  </button>
                  <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">
                    Cancelar
                  </button>
                </div>
                <!-- Aquí se muestra la alerta -->
                <?= $alertHtml ?? '' ?>
              </form>
            </div>
          </div>
        </div>
        <!-- FIN DEL MODAL DE EDITAR AVISO -->

        <!-- MODAL NOTIFICACIÓN BORRADO -->
        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
          aria-hidden="true">
          <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <i class="material-symbols-rounded text-danger me-2">
                  warning
                </i>
                <h6 class="modal-title font-weight-normal" id="modal-title-notification">
                  Mensaje de confirmación</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="py-3 text-center">
                  <i class="material-symbols-rounded h1 text-secondary">
                    Borrar Aviso
                  </i>
                  <h4 class="text-gradient text-danger mt-4">Atención</h4>
                  <p>Estás a punto de borrar la campaña
                    "<span id="aviso-name"></span>".
                    ¿Estás seguro de continuar?
                  </p>
                </div>
              </div>
              <div class="modal-footer">
                <form method="POST">
                  <input type="hidden" name="AvisoId" id="aviso-id">
                  <button type="submit" name="borrarAviso" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    data-target="warningToast">
                    Sí, continuar
                  </button>
                  <?= $alertHtml ?>
                </form>
                <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">
                  Cancelar
                </button>
              </div>

            </div>
          </div>
        </div>
        <!-- FIN DEL MODAL NOTIFICACIÓN BORRADO -->

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
                Desarrollado para
                <a href="https://www.fast-net.com.mx" class="font-weight-bold" target="_blank">FastNet</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
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
  <script>
    const modal = document.getElementById('modal-notification');
    modal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const avisoId = button.getAttribute('data-aviso-id');
      const avisoName = button.getAttribute('data-aviso-name');

      document.getElementById('aviso-id').value = avisoId;
      document.getElementById('aviso-name').textContent = avisoName;
    });
  </script>
  <script>
    // Al abrir el modal, inyecta valores en campos e imagen
    const editModal = document.getElementById('modal-edit');
    editModal.addEventListener('show.bs.modal', event => {
      const btn = event.relatedTarget;
      const id = btn.getAttribute('data-aviso-id');
      const title = btn.getAttribute('data-aviso-title');
      const desc = btn.getAttribute('data-aviso-desc');
      const esc = btn.getAttribute('data-aviso-esc');
      const src = btn.getAttribute('data-aviso-src');

      document.getElementById('edit-aviso-id').value = id;
      document.getElementById('edit-aviso-title').value = title;
      document.getElementById('edit-aviso-desc').value = desc;
      document.getElementById('edit-aviso-img-preview').src = src;
    });

    // Previsualizar nueva imagen antes de enviar
    document
      .getElementById('edit-aviso-file')
      .addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
          document
            .getElementById('edit-aviso-img-preview')
            .src = ev.target.result;
        };
        reader.readAsDataURL(file);
      });
  </script>
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
</body>

</html>