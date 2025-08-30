<?php
require_once '../controllers/dashboard.php';
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
          <a class="nav-link active bg-gradient-primary text-white" href="../pages/dashboard.php">
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
          <a class="nav-link text-primary" href="../pages/manuales.html">
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
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Salir</span>
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
          <a class="nav-link text-primary" href="../pages/manuales.html">
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
        <li class="nav-item">
          <a class="nav-link text-primary" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Salir</span>
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
            <div class="avatar avatar-xl position-relative">
              <img <?php echo isset($sesion) ? obtenerFotoUsuario($pdo, $sesion['UsuarioId']) : 'src="../assets/img/small-logos/user.png"' ?> alt="profile_image"
                class="w-100 border-radius-lg shadow-sm">
            </div>
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
          <!--<div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="javascript:;" role="tab"
                    aria-selected="true">
                    <i class="material-symbols-rounded text-lg position-relative">home</i>
                    <span class="ms-1">App</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;" role="tab"
                    aria-selected="false">
                    <i class="material-symbols-rounded text-lg position-relative">email</i>
                    <span class="ms-1">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;" role="tab"
                    aria-selected="false">
                    <i class="material-symbols-rounded text-lg position-relative">settings</i>
                    <span class="ms-1">Settings</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>-->
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
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Información de Perfil</h6>
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
                      <?php echo $sesion['NumeroTelefono']; ?>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp;
                      <?php echo $sesion['Email'] ?? 'No disponible'; ?>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Nombre):</strong>
                      &nbsp; Alec M. Thompson I</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Parentesco):</strong>
                      &nbsp; Padre</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Contacto de
                        emergencia (Número):</strong>
                      &nbsp; (44) 123 1234 123</li>

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
    <div class="fixed-plugin">
      <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-symbols-rounded py-2">edit</i>
      </a>
      <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
          <div class="float-start">
            <h5 class="mt-3 mb-0">Editar Información</h5>
            <p></p>
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
          <!-- Sidebar Backgrounds -->
          <div>
            <h6 class="mb-0"></h6>
          </div>
          <!-- Sidenav Type -->
          <form>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Número celular</label>
              <input type="number" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Número alternativo</label>
              <input type="number" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Nombre Contacto de emergencia</label>
              <input type="text" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Parentesco Contacto de emergencia</label>
              <input type="text" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3">
              <label class="form-label">Número de teléfono</label>
              <input type="number" class="form-control">
            </div>

            <div class="input-group input-group-static my-3">
              <a class="btn bg-gradient-primary w-100" href="" target="_blank" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Actualizar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Información</h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¡La información se actualizó correctamente!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
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
</body>

</html>