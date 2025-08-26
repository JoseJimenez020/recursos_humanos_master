<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="es">

<head>
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
</head>

<body class="g-sidenav-show bg-gray-100">

  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
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
  </aside>
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Home</li>
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
                <img src="../assets/img/small-logos/user.png" class="avatar avatar-sm  me-3 ">
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="../pages/profile.html">
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
                  <a class="dropdown-item border-radius-md" href="../pages/sign-in.html">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <i class="material-symbols-rounded">logout</i>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Salir
                        </h6>
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
                    <img src="../assets/img/small-logos/user.png" alt="profile_image"
                      class="w-100 border-radius-lg shadow-sm">
                  </div>
                </div>
                <div class="col-auto my-auto">
                  <div class="h-100">
                    <h5 class="mb-1">
                      Nombre_Usuario
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                      Departamento
                    </p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="row">
                  <h6 class="mb-0">¡Sé bienvenid@!</h6>
                  <h6 class="mb-0" id="fechaCompleta">¡Sé bienvenid@!</h6>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="row">
                <div class="col-md-auto mx-auto">
                  <div id="carouselAvisos" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item">
                        <div class="page-header min-vh-15 border-radius-lg">
                          <div class="card" data-animation="false"
                            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                            <div class="card-body d-flex align-items-center w-100">
                              <!-- Imagen al lado izquierdo -->
                              <div class="me-3">
                                <img src="../assets/img/bruce-mars.jpg" alt="usuario" class="avatar-sm2">
                              </div>

                              <!-- Contenido textual centrado verticalmente -->
                              <div class="text-start flex-grow-1">
                                <h6 class="font-weight-bold text-primary mb-1">
                                  <a href="#" class="text-primary">¡Felicidades! Oliver Liam
                                    <i class="material-symbols-rounded me-2 text-lg">celebration</i>
                                  </a>
                                </h6>
                                <small class="text-muted d-block">
                                  Enhorabuena por este nuevo logro. Te deseamos mucho éxito en esta nueva etapa.
                                </small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <div class="page-header min-vh-10 border-radius-lg">
                          <div class="page-header min-vh-15 border-radius-lg">
                            <div class="card" data-animation="false"
                              style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                              <div class="card-body d-flex align-items-center w-100">
                                <!-- Imagen al lado izquierdo -->
                                <div class="me-3">
                                  <img src="../assets/img/team-4.jpg" alt="usuario" class="avatar-sm2">
                                </div>

                                <!-- Contenido textual centrado verticalmente -->
                                <div class="text-start flex-grow-1">
                                  <h6 class="font-weight-bold text-primary mb-1">
                                    <a href="#" class="text-primary">¡Felicidades! Lucas Harper
                                      <i class="material-symbols-rounded me-2 text-lg">celebration</i>
                                    </a>
                                  </h6>
                                  <small class="text-muted d-block">
                                    Enhorabuena por este nuevo logro. Te deseamos mucho éxito en esta nueva etapa.
                                  </small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="carousel-item active">
                        <div class="page-header min-vh-15 border-radius-lg">
                          <div class="card" data-animation="false"
                            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                            <div class="card-body d-flex align-items-center w-100">
                              <!-- Imagen al lado izquierdo -->
                              <div class="me-3">
                                <img src="../assets/img/team-5.jpg" alt="usuario" class="avatar-sm2">
                              </div>

                              <!-- Contenido textual centrado verticalmente -->
                              <div class="text-start flex-grow-1">
                                <h6 class="font-weight-bold text-primary mb-1">
                                  <a href="#" class="text-primary">¡Felicidades! Ethan James
                                    <i class="material-symbols-rounded me-2 text-lg">celebration</i>
                                  </a>
                                </h6>
                                <small class="text-muted d-block">
                                  Enhorabuena por este nuevo logro. Te deseamos mucho éxito en esta nueva etapa.
                                </small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="min-vh-10 position-relative w-100 top-0 ">
                      <a class="carousel-control-prev text-primary" href="#carouselAvisos" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon position-absolute bottom-50 " aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </a>
                      <a class="carousel-control-next text-primary" href="#carouselAvisos" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon position-absolute bottom-50 " aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </a>
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
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-success text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-danger text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-info text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-warning text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-primary text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
                <div class="timeline-block">
                  <span class="timeline-step">
                    <i class="material-symbols-rounded text-dark text-gradient">hotel</i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Usuario_nombre</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Del fecha/de/inicio al
                      fecha/de/vuelta
                    </p>
                  </div>
                </div>
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
                      <p class="text-sm my-auto">Alejandra Sánchez</p>
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
                      <p class="text-sm my-auto">Administrador</p>
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
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Campañas</h6>
            </div>
            <div class="card-body p-3">
              <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner mb-4">
                  <div class="carousel-item">
                    <a href="../pages/campania_ext.html">
                      <div class="page-header min-vh-45 m-3 border-radius-md"
                        style="background-image: url('../assets/img/campania_acoso.jpg');">
                        <span class="mask bg-gradient-dark"></span>
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-8 my-auto">
                              <h4 class="text-white fadeIn2 fadeInBottom">Acoso Laboral</h4>
                              <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">¿Qué hacer en caso de? Acudir con el departamento de Recursos Humanos, RH, de manera presencial o al correo electrónico: recursoshumuanos@fast-net.com.mx</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="carousel-item">
                    <a href="../pages/campania_ext.html">
                      <div class="page-header min-vh-45 m-3 border-radius-md"
                        style="background-image: url('../assets/img/campania1.jpg');">
                        <span class="mask bg-gradient-dark"></span>
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-6 my-auto">
                              <h4 class="text-white fadeIn2 fadeInBottom">Work with the rockets</h4>
                              <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Wealth creation is an
                                evolutionarily recent positive-sum game. Status is an old zero-sum game. </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="carousel-item">
                    <div class="page-header min-vh-45 m-3 border-radius-md"
                      style="background-image: url('../assets/img/campania2.JPG');">
                      <span class="mask bg-gradient-dark"></span>
                      <div class="container">
                        <div class="row">
                          <div class="col-lg-8 my-auto">
                            <h4 class="text-white fadeIn2 fadeInBottom">Work with the best</h4>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Free people make free choices.
                              Free choices mean you get unequal outcomes. </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item active">
                    <div class="page-header min-vh-45 m-3 border-radius-md"
                      style="background-image: url('https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-2-min.jpg');">
                      <span class="mask bg-gradient-dark"></span>
                      <div class="container">
                        <div class="row">
                          <div class="col-lg-8 my-auto">
                            <h4 class="text-white fadeIn2 fadeInBottom">Work from home</h4>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">You’re spending time to save
                              money
                              when you should be spending money to save time.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="min-vh-45 position-absolute w-100 top-0">
                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon position-absolute bottom-50" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon position-absolute bottom-50" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </a>
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
  </div>
  <div class="fixed-plugin">
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
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Deja tu comentario aquí</h6>
        </div>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <div class="input-group input-group-dynamic">
            <textarea class="input-group input-group-outline mb-4" rows="12"
              placeholder="Describe cuál es la situación y nos pondremos en contacto contigo, recuerda que es confidencial."
              spellcheck="false"></textarea>
          </div>
        </div>
        <!-- Navbar Fixed -->

        <hr class="horizontal dark my-sm-4">
        <div class="w-100 text-center">
          <a href="" class="btn btn-dark mb-0 me-2" target="_blank" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Enviar
          </a>
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
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Mensaje enviado correctamente</h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Gracias por compartir tus comentarios, nos pondremos en contacto contigo tan pronto como nos sea posible.
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

</body>

</html>