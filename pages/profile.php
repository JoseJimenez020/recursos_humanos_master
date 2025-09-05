<?php
//require_once '../controllers/dashboard.php';
require_once '../controllers/logica_usuario.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
  <title>
    RH | Perfil
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
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.html">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.html">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.html">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.html">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.html">
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
          <a class="nav-link text-primary" href="../pages/felicitaciones.html">
            <i class="material-symbols-rounded opacity-5">celebration</i>
            <span class="nav-link-text ms-1">Felicitaciones</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/campanias.html">
            <i class="material-symbols-rounded opacity-5">campaign</i>
            <span class="nav-link-text ms-1">Campañas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/r_vacantes.html">
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
          <a class="nav-link text-primary" href="../pages/nom035.html">
            <i class="material-symbols-rounded opacity-5">comment</i>
            <span class="nav-link-text ms-1">NOM-35</span>
          </a>
        </li>

      </ul>
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
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/politicas.html">
            <i class="material-symbols-rounded opacity-5">policy</i>
            <span class="nav-link-text ms-1">Políticas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/reglamento_interno.html">
            <i class="material-symbols-rounded opacity-5">rule</i>
            <span class="nav-link-text ms-1">Reglamento Interno</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/procesos.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Procesos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/organigrama.html">
            <i class="material-symbols-rounded opacity-5">globe_book</i>
            <span class="nav-link-text ms-1">Organigrama</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/mision_vision.html">
            <i class="material-symbols-rounded opacity-5">public</i>
            <span class="nav-link-text ms-1">Misión, Visión</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/valores.html">
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
          <a class="nav-link text-primary" href="../pages/nom035.html">
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
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.html" type="button">
          <span class="nav-link-text ms-1">Comercial</span>
          <i class="material-symbols-rounded opacity-5">groups</i>
          <span id="contador_vacantes">4</span>
          <i class="material-symbols-rounded opacity-5">keyboard_arrow_down</i>
        </a>
        <a class="btn btn-outline-primary w-100" href="../pages/vacantes.html" type="button">
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Perfil</li>
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
                <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> class="avatar avatar-sm  me-3 ">
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
      <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-dark  opacity-6"></span>
      </div>
      <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <a href="#" data-bs-toggle="modal" data-bs-target="#fotoPerfilModal">
              <div class="avatar avatar-xl position-relative">
                <img <?php echo isset($sesion)
                  ? obtenerFotoUsuario($pdo, $sesion['UsuarioId'])
                  : 'src="../assets/img/small-logos/user.png"'
                  ?> alt="profile_image"
                  class="w-100 border-radius-lg shadow-sm">
              </div>
            </a>


          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $sesion['NombreUsuario']; ?>
                <?php echo $sesion['ApellidoPaterno']; ?>
                <?php echo $sesion['ApellidoMaterno'] ?? ''; ?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
                <?php echo $sesion['DepartamentoNombre'] ?? 'Sin departamento' ?>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="row">
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Configuración de la plataforma</h6>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 px-0">
                      <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                          onclick="darkMode(this)">
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                          for="flexSwitchCheckDefault1">Modo Oscuro</label>
                      </div>
                    </li>
                    <li class="list-group-item border-0 px-0">
                      <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                          onclick="navbarFixed(this)">
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                          for="flexSwitchCheckDefault1">Anclar barra de inicio</label>
                      </div>
                    </li>
                  </ul>
                  <div class="mt-3">
                    <h6 class="mb-0">Menú lateral</h6>
                    <p class="text-sm"><Em>Elige el color de la barra lateral</Em>.</p>
                  </div>
                  <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark"
                      onclick="sidebarType(this)">Oscura</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                      onclick="sidebarType(this)">Transparente</button>
                    <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white"
                      onclick="sidebarType(this)">Blanca</button>
                  </div>
                  <p class="text-sm d-xl-none d-block mt-2">Puedes elegir igual que en la vista de escritorio</p>
                  <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                    data-bs-target="#modal-form">Cambiar Contraseña</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-10 d-flex align-items-center">
                      <h6 class="mb-0">Información Personal</h6>&nbsp; &nbsp;
                      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-edit" data-user-id="<?php echo $sesion['UsuarioId']; ?>">Editar</button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">

                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nombre
                        completo:</strong>
                      &nbsp; <?php echo $sesion['NombreUsuario']; ?>
                      <?php echo $sesion['ApellidoPaterno']; ?>
                      <?php echo $sesion['ApellidoMaterno'] ?? ''; ?>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Número celular:</strong>
                      &nbsp;
                      <span id="tel-display"><?php echo $sesion['NumeroTelefono']; ?></span>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp;
                      <span id="email-display"><?php echo $sesion['Email'] ?? 'No disponible'; ?> </span>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Nombre):</strong>
                      &nbsp;
                      <span id="contacto-display"> <?php echo $sesion['NombreContacto'] ?? 'No hay registro'; ?> </span>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Parentesco):</strong>
                      &nbsp;
                      <span id="parentezco-display"> <?php echo $sesion['Parentezco'] ?? 'No hay registro'; ?> </span>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Número):</strong>
                      &nbsp;
                      <span id="emer-display"> <?php echo $sesion['contactoNumero'] ?? 'No hay registro'; ?> </span>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
              <div class="mb-5 ps-3">
                <h6 class="mb-1">Avisos</h6>
                <p class="text-sm">Revisa los últimos avisos publicados</p>
              </div>
              <div class="row">
                <div class="card-group">
                  <div class="card" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <a class="d-block blur-shadow-image">
                        <img
                          src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg"
                          alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                      </a>
                      <div class="colored-shadow"
                        style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);">
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="d-flex mt-n6 mx-auto">
                        <a class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </a>
                        <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </button>
                      </div>
                      <h5 class="font-weight-normal mt-3">
                        <a href="javascript:;">Título del aviso</a>
                      </h5>
                      <p class="mb-0">
                        Aquí va información adicional a la imagen del aviso que se quiera agregar.
                      </p>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer d-flex">
                      <p class="font-weight-normal my-auto">25 de enero del 2025</p>
                      <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
                      <p class="text-sm my-auto">Ale RH</p>
                    </div>
                  </div>
                  <div class="card" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <a class="d-block blur-shadow-image">
                        <img
                          src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg"
                          alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                      </a>
                      <div class="colored-shadow"
                        style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);">
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="d-flex mt-n6 mx-auto">
                        <a class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </a>
                        <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </button>
                      </div>
                      <h5 class="font-weight-normal mt-3">
                        <a href="javascript:;">Título del aviso</a>
                      </h5>
                      <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.
                      </p>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer d-flex">
                      <p class="font-weight-normal my-auto">30 de abril del 2025</p>
                      <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
                      <p class="text-sm my-auto">José Alberto Jiménez</p>
                    </div>
                  </div>
                  <div class="card" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <a class="d-block blur-shadow-image">
                        <img
                          src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg"
                          alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                      </a>
                      <div class="colored-shadow"
                        style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);">
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="d-flex mt-n6 mx-auto">
                        <a class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </a>
                        <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </button>
                      </div>
                      <h5 class="font-weight-normal mt-3">
                        <a href="javascript:;">Título del aviso</a>
                      </h5>
                      <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.
                      </p>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer d-flex">
                      <p class="font-weight-normal my-auto">30 de julio del 2025</p>
                      <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
                      <p class="text-sm my-auto">Admin</p>
                    </div>
                  </div>
                  <div class="card" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <a class="d-block blur-shadow-image">
                        <img
                          src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg"
                          alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                      </a>
                      <div class="colored-shadow"
                        style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);">
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="d-flex mt-n6 mx-auto">
                        <a class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </a>
                        <button class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip"
                          data-bs-placement="bottom" title="">
                        </button>
                      </div>
                      <h5 class="font-weight-normal mt-3">
                        <a href="javascript:;">Título del aviso</a>
                      </h5>
                      <p class="mb-0">
                        Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      </p>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer d-flex">
                      <p class="font-weight-normal my-auto">25 de julio de 2025</p>
                      <i class="material-symbols-rounded position-relative ms-auto text-lg me-1 my-auto">person</i>
                      <p class="text-sm my-auto">Juan Pérez</p>
                    </div>
                  </div>
                </div>
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
              Powered by
              <a href="https://www.fast-net.com.mx" class="font-weight-bold" target="_blank">Fast-net</a>
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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const editModalEl = document.getElementById('modal-edit');
      const form = document.getElementById('form-edit-usuario');
      const telDisplay = document.getElementById('tel-display');
      const emailDisplay = document.getElementById('email-display');
      const contactoDisplay = document.getElementById('contacto-display');
      const parentezcoDisplay = document.getElementById('parentezco-display');
      const emerDisplay = document.getElementById('emer-display');
      const telInput = form.querySelector('input[name="NumeroTelefono"]');
      const emailInput = form.querySelector('input[name="Email"]');
      const contactoInput = form.querySelector('input[name="NombreContacto"]');
      const parentescoInput = form.querySelector('input[name="Parentezco"]');
      const emergInput = form.querySelector('input[name="NumeroEmergencia"]');

      // Bootstrap 5 Modal instance
      const bsModal = new bootstrap.Modal(editModalEl);

      // 1) Cargar datos al abrir modal
      editModalEl.addEventListener('show.bs.modal', async () => {
        try {
          const resp = await fetch('../controllers/get_perfil_ajax.php');
          if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
          const u = await resp.json();
          telInput.value = u.NumeroTelefono || '';
          emailInput.value = u.Email || '';
          contactoInput.value = u.NombreContacto || '';
          parentescoInput.value = u.Parentezco || '';
          emergInput.value = u.ContactoTelefono || '';
        } catch (err) {
          console.error(err);
          Swal.fire('Error', 'No se pudo cargar tu información', 'error');
        }
      });

      // 2) Enviar cambios y actualizar DOM sin recargar
      form.addEventListener('submit', async e => {
        e.preventDefault();
        try {
          const resp = await fetch('../controllers/update_perfil_ajax.php', {
            method: 'POST',
            body: new FormData(form)
          });
          if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
          const result = await resp.json();

          await Swal.fire({
            title: result.success ? '¡Listo!' : 'Error',
            text: result.message,
            icon: result.success ? 'success' : 'error'
          });

          if (result.success) {
            bsModal.hide();

            // Actualiza sólo si existen los nodos en la página
            if (telDisplay) telDisplay.textContent = telInput.value;
            if (emailDisplay) emailDisplay.textContent = emailInput.value;
            if (contactoDisplay) contactoDisplay.textContent = contactoInput.value;
            if (parentezcoDisplay) parentezcoDisplay.textContent = parentescoInput.value;
            if (emerDisplay) emerDisplay.textContent = emergInput.value;
          }
        } catch (err) {
          console.error(err);
          Swal.fire('Error', 'Fallo de comunicación', 'error');
        }
      });
    });
  </script>

  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  <script src="../assets/js/settings.js"></script>
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
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="card card-plain">
            <div class="card-header pb-0 text-left">
              <h5 class="">Cambiar Contraseña</h5>
            </div>
            <div class="card-body">

              <form role="form text-left" method="post">
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
                <div class="text-center">
                  <button type="submit" name="actualizarPass"
                    class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">Cambiar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--FIN DEL MODAL PARA CAMBIAR CONTRASEÑA-->

  <!--MODAL PARA EDITAR USUARIO-->
  <div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Editar información</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="form-edit-usuario">
          <input type="hidden" name="UsuarioId" id="edit-UsuarioId">
          <div class="modal-body">
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Teléfono celular</label>
              <input name="NumeroTelefono" id="edit-NumeroTelefono" type="tel" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Email</label>
              <input name="Email" id="edit-Email" type="email" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Nombre contacto emergencia</label>
              <input name="NombreContacto" id="edit-NombreContacto" type="text" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Parentesco contacto emergencia</label>
              <input name="Parentezco" id="edit-Parentezco" type="text" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Número contacto emergencia</label>
              <input name="NumeroEmergencia" id="edit-NumeroEmergencia" type="tel" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-gradient-primary w-100">Guardar
              información</button>
            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- FIN DEL MODAL DE EDITAR USUARIO -->

  <!--MODAL FOTO DE PERFIL-->
  <div class="modal fade" id="fotoPerfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cambiar foto de perfil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="card bg-dark text-white border-0 mb-4">
            <img <?php echo isset($sesion)
              ? obtenerFotoUsuario($pdo, $sesion['UsuarioId'])
              : 'src="../assets/img/small-logos/user.png"'
              ?> alt="preview" class="card-img">
          </div>

          <!-- Formulario actualizado -->
          <form id="foto_perfil_usuario" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="UsuarioId" value="<?php echo $sesion['UsuarioId']; ?>">

            <p class="text-sm"><em>(JPEG, JPG). Tamaño máximo: 1 MB.</em></p>

            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Selecciona una imagen</label>
              <input type="file" name="foto" accept="image/jpeg,image/jpg" class="form-control" required>
            </div>

            <button type="submit" name="guardarFoto" class="btn bg-gradient-primary">Guardar</button>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN DEL MODAL FOTO DE PERFIL -->


</body>

</html>