<?php
require '../controllers/logica_candidato.php';

$alertHtml = '';
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
        Candidatos Pruebas
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
</head>

<body class="g-sidenav-show bg-gray-100">


    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">RRHH</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pruebas fisiométricas
                        </li>
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
                                <img src="../assets/img/favicon.ico" class="avatar avatar-lg  me-3 ">
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
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
                                ¡Sé bienvenido!
                            </h3>
                            <br>
                            <p class="mb-0 font-weight-normal text-sm">
                                <?php echo $sesion['NombreCompleto'] ?>, a continuación se muestran las pruebas con las
                                que necesitamos que nos apoye. Descargue el documento para que pueda contestar y súbalo
                                con sus respuestas.
                            </p>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <h4 class="mb-0 h4 font-weight-bolder">Prueba C</h4>
                        <p>Instrucciones:</p>
                        <p class="mb-0 font-weight-normal text-sm">1. Adjunto encontrarán un Excel que tiene 2 pestañas.
                        </p>
                        <p class="mb-0 font-weight-normal text-sm">2. Habilitar las pestañas en Excel</p>
                        <p class="mb-0 font-weight-normal text-sm">3. Ingresar a la Pestaña de Hoja de Captura, e
                            ingresar tu nombre y edad.</p>
                        <p class="mb-0 font-weight-normal text-sm">4. Encontrarán cuatro palabras agrupadas, seleccionar
                            de esas 4, únicamente 2, una con la que "más" te identifiques y una con la que "menos" te
                            identifiques.</p>
                        <p class="mb-0 font-weight-normal text-sm">5. Poner un "1" en la fila de la palabra que más te
                            identifiques en la columna "+"</p>
                        <p class="mb-0 font-weight-normal text-sm">6. Poner un "1" en la fila de la palabra que menos te
                            identifiques en la columna "-"</p>
                        <p class="mb-0 font-weight-normal text-sm">7. Continuar con los grupos de 4 palabras hasta
                            terminar el test. No dejar ninguna en blanco.</p>
                        <br>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#ejemplopruebac">Ver ejemplo</button>
                        <button type="button" class="btn btn-success"
                            onclick="window.location.href='../docs/PruebaC.xlsx'">Descargar documento</button>

                        <form action="../controllers/logica_candidato.php" method="post" enctype="multipart/form-data">
                            <p class="mb-0 font-weight-normal text-sm">Subir el documento rellenado</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <input type="hidden" name="nombreUsuario"
                                            value="<?php echo htmlspecialchars($sesion['NombreCompleto'], ENT_QUOTES); ?>">
                                        <input type="hidden" name="apartado" value="PruebaC">
                                        <input type="file" name="archivo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Subir documento</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-10 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">

                    <div class="card-body p-3">
                        <h4 class="mb-0 h4 font-weight-bolder">Test de ZAVIC</h4>
                        <p>Instrucciones:</p>
                        <p class="mb-0 font-weight-normal text-sm">A continuación usted encontrará una serie de
                            situaciones que le van a sugerir 4 respuestas. Lea cada una de ellas cuidadosamente y anote
                            en la hoja de respuestas en el paréntesis que corresponda un número de la siguiente manera:
                        </p>
                        <p class="mb-0 font-weight-normal text-sm">El número 4 Cuando la respuesta sea más importante.
                        </p>
                        <p class="mb-0 font-weight-normal text-sm">El número 3 Cuando le sea importante pero no tanto
                            como la anterior.</p>
                        <p class="mb-0 font-weight-normal text-sm">El numero 2 Cuando la prefiera menos que las
                            anteriores.</p>
                        <p class="mb-0 font-weight-normal text-sm">El número 1 Cuando tenga menos importancia.</p>
                        <p class="mb-0 font-weight-normal text-sm">No deben repetirse los números en una misma
                            situación, siempre será 1,2,3 y 4 según sea su punto de vista. No conteste nada en este
                            cuadernillo hágalo en la hoja de respuestas, no deje ninguna sin contestar. </p>


                        <p class="mb-0 font-weight-normal text-sm">Registrar las respuestas en el documento en excel y
                            subirlo una vez terminado.</p>
                        <br>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#pruebaZAVIC">Ver ejemplo</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location.href='../docs/TestdeZAVIC.doc'">Descargar Cuestionario</button>
                        <button type="button" class="btn btn-success"
                            onclick="window.location.href='../docs/resultadosZAVIC.xls'">Descargar Cuadernillo de
                            respuestas</button>
                        <form action="../controllers/logica_candidato.php" method="post" enctype="multipart/form-data">
                            <p class="mb-0 font-weight-normal text-sm">Subir el cuadernillo rellenado</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <input type="hidden" name="nombreUsuario"
                                            value="<?php echo htmlspecialchars($sesion['NombreCompleto'], ENT_QUOTES); ?>">
                                        <input type="hidden" name="apartado" value="TestZAVIC">
                                        <label class="form-label"></label>
                                        <input type="file" name="archivo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Subir documento</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-10 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">

                    <div class="card-body p-3">
                        <h4 class="mb-0 h4 font-weight-bolder">Estudio Socioeconómico y Formato médico</h4>
                        <p>Instrucciones:</p>
                        <p class="mb-0 font-weight-normal text-sm">Rellene la información que pide cada uno de los
                            siguientes formatos:</p>


                        <p class="mb-0 font-weight-normal text-sm">Registrar las respuestas en el documento en excel y
                            subirlo una vez terminado.</p>
                        <br>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location.href='../docs/Estudiosocioeconomico.docx'">Descargar Estudio
                            Socioeconómico</button>
                        <button type="button" class="btn btn-info"
                            onclick="window.location.href='../docs/FORMATOMEDICO.docx'">Descargar Formato
                            Médico</button>
                        <form action="../controllers/logica_candidato.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Estudio socioeconómico</p>
                                    <div class="input-group input-group-outline my-3">
                                        <input type="hidden" name="nombreUsuario"
                                            value="<?php echo htmlspecialchars($sesion['NombreCompleto'], ENT_QUOTES); ?>">
                                        <input type="hidden" name="apartado" value="EstudioSocio">
                                        <label class="form-label"></label>
                                        <input type="file" name="archivo[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>Formato médico</p>
                                    <div class="input-group input-group-outline my-3">
                                        <input type="hidden" name="apartado2" value="FormMedic">
                                        <label class="form-label"></label>
                                        <input type="file" name="archivo[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Subir documentos</button>
                        </form>
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

    <div class="modal fade" id="ejemplopruebac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLongTitle">Cómo contestar Prueba C</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card bg-dark text-white border-0 mb-4">
                        <img src="../assets/img/pruebaC.PNG" alt="preview" class="card-img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pruebaZAVIC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLongTitle">Cómo contestar el Test de
                        ZAVIC</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <img src="../assets/img/pruebaZAVIC.PNG" alt="ejemplo prueba zavic" style="width:100vh">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>