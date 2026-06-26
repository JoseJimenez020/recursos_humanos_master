<?php
require '../controllers/dashboard.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>
    RH | Procesos
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
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/procesos.php">
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
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/procesos.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Procesos</li>
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
    <div class="container-fluid px-2 px-md-4">
      <div class="page-header min-height-100 border-radius-xl mt-4">
      </div>
      <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto my-auto">
            <div class="h-100">
              <h3 class="mb-0 h3 font-weight-bolder">
                Procesos
              </h3>
              <p class="mb-0 font-weight-normal text-sm">
                Consulta la información sobre los procesos.
              </p>
            </div>
          </div>
          <div class="card-body p-3">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Nombre</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                      Departamento</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Opciones</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Última modificación</th>
                    <!--<th></th>-->
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso de denuncias internas</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Todos</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success"
                        onclick="descargarPDF('../docs/PROCESO_DENUNCIAS_INTERNAS.pdf', 'Denuncias internas.pdf')">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary"
                        onclick="verPDFSweetAlert('../docs/PROCESO_DENUNCIAS_INTERNAS.pdf')">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">12/09/25</span>
                    </td>
                    <!--<td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>-->
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user2">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso Uso del BioTime</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Todos</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success"
                        onclick="descargarPDF('../docs/USO_BIOTIME.pdf', 'Denuncias internas.pdf')">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary"
                        onclick="verPDFSweetAlert('../docs/USO_BIOTIME.pdf')">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">12/09/25</span>
                    </td>
                    <!--<td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>-->
                  </tr>
                  <!--<tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso Número tres</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Programación</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">19/09/17</span>
                    </td>
                    <td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user4">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso Número cuatro</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Técnico</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">24/12/08</span>
                    </td>
                    <td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user5">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso Número cinco</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Recursos Humanos</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">04/10/21</span>
                    </td>
                    <td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/icons/pdf-logo.png" class="avatar avatar-sm me-3 border-radius-lg"
                            alt="user6">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0">Proceso Número seis</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ejemplo</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">Descargar</span>
                      <span class="badge badge-sm bg-gradient-secondary">Ver</span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">14/09/20</span>
                    </td>
                    <td class="align-middle text-center">
                      <a class="btn btn-link text-primary ms-auto border-0" data-toggle="tooltip" data-bs-toggle="modal"
                        data-bs-target="#modal-notification">
                        <i class="material-symbols-rounded text-lg">delete</i>
                      </a>
                    </td>
                  </tr>-->
                </tbody>
              </table>
              <!-- Script para ver los documentos en la misma página -->
              <script>
                function verPDFSweetAlert(url) {
                  Swal.fire({
                    title: 'Vista previa del Proceso',
                    html: `<iframe src="${url}" width="100%" height="700px" style="border:none;"></iframe>`,
                    width: '75%',
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                      popup: 'swal2-pdf-modal'
                    }
                  });
                }
              </script>
              <!--Fin del script para ver documentos-->

              <!-- Script para validar la descarga -->
              <script>
                function descargarPDF(url, nombreArchivo) {
                  const enlace = document.createElement('a');
                  enlace.href = url;
                  enlace.download = nombreArchivo;
                  document.body.appendChild(enlace);
                  enlace.click();
                  document.body.removeChild(enlace);
                }
              </script>
              <!--Fin del script para validar la descarga-->

            </div>

            <!-- MODAL NOTIFICACIÓN BORRADO -->
            <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
              aria-labelledby="modal-notification" aria-hidden="true">
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
                        Borrar Proceso
                      </i>
                      <h4 class="text-gradient text-danger mt-4">Atención</h4>
                      <p>Está a punto de borrar el Proceso "Nombre del Proceso", ¿Está seguro que
                        desea
                        continuar?</p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-primary toast-btn" data-bs-dismiss="modal"
                      data-target="warningToast">Sí,
                      continuar.</button>
                    <button type="button" class="btn btn-link text-primary ml-auto"
                      data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN DEL MODAL NOTIFICACIÓN BORRADO -->

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
  <!--<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">note_add</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Agregar nuevo Proceso</h5>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>-->
        <!-- End Toggle Button -->
      <!--</div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">-->
        <!-- Sidebar Backgrounds -->
        <!--<div>
          <p>A continuación ingrese la información que se solicita</p>
        </div>-->
        <!-- Sidenav Type -->

        <!-- Navbar Fixed -->
        <!--<div class="mt-3 d-flex">
          <form>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Nombre</label>
              <input type="text" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Documento</label>
              <input type="file" class="form-control">
            </div>
            <div class="input-group input-group-static my-3">
              <label>Fecha</label>
              <input type="date" class="form-control">
            </div>
          </form>
        </div>
        <hr class="horizontal dark my-3">
        <a class="btn bg-gradient-primary w-100" href="">Subir Proceso</a>
      </div>
    </div>
  </div>-->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
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