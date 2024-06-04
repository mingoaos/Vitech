<?php
session_start();

require './db/dbcon.php';
require './db/libphp.php';
require './db/noticiasCode.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$op = 0;
if (isset($_GET['op']))
  $op = $_GET['op'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Vitech</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/mystyle.css" rel="stylesheet">
</head>

<body>
  <?php
  if (!isset($_SESSION['user'])) {

    include "./pag/login/login.php";


  } else {

    ?>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

      <div class="d-flex align-items-center justify-content-between">
        <a href="./" class="logo d-flex align-items-center">
          <img src="assets/img/logo.png" alt="">
          <span class="d-none d-lg-block">Vitech</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->



      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

          <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
              <i class="bi bi-search"></i>
            </a>
          </li>

          <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-bell"></i>
              <span class="badge bg-primary badge-number">4</span>
            </a><!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
              <li class="dropdown-header">
                You have 4 new notifications
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div>
                  <h4>Lorem Ipsum</h4>
                  <p>Quae dolorem earum veritatis oditseno</p>
                  <p>30 min. ago</p>
                </div>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>


              <li class="dropdown-footer">
                <a href="#">Show all notifications</a>
              </li>

            </ul><!-- End Notification Dropdown Items -->

          </li><!-- End Notification Nav -->

          <?php
          $count = getCount($con, "SELECT COUNT(*) AS total FROM `noticia` WHERE Data_inicio < NOW() AND Data_fim > NOW()");
          ?>
          <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-newspaper"></i>
              <span class="badge bg-success badge-number"><?= $count ?></span>
            </a><!-- End noticias Icon -->
            <style>

            </style>
            <ul style="width: 350px; max-height: 650px; overflow-y: auto; "
              class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
              <li class="dropdown-header fw-bold">
                Você tem <?= $count ?> novas Notícias

              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <?php
              $noticias = getNoticia($con);

              if ($noticias != null) {


                foreach ($noticias as $row) {
                  ?>
                  <li class="message-item">
                    <div class="message-content position-relative">
                      <!-- Close button -->
                      <a href="#" class="close-icon position-absolute top-0 end-0 m-2 text-danger delete-message"
                        data-noticia-id="<?= $row['id_noticia'] ?>">
                        <i class="bi bi-x"></i>
                      </a>
                      <!-- Message content -->
                      <div class="text-center">
                        <h4 class='fw-bold text-primary'><?= $row['Assunto'] ?></h4>
                        <p style='word-wrap: break-word' class="text-black"><?= $row['Noticia'] ?></p>
                        <p>De <?= $row['formatted_Data_inicio'] ?> a <?= $row['formatted_Data_fim'] ?></p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>

                <?php }
              }
              ?>

            </ul><!-- End Messages Dropdown Items -->

          </li><!-- End Messages Nav -->

          <li class="nav-item dropdown pe-5">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <span class="d-none d-md-block dropdown-toggle ps-0"> <?php echo $_SESSION['user']['nome']; ?> </span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6><?php echo $_SESSION['user']['nome']; ?></h6>
                <span>Bem vindo!</span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="./?op=6">
                  <i class="bi bi-pencil-square"></i>
                  <span>Editar Perfil</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="pag/login/logout.php">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>

            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->

        </ul>
      </nav><!-- End Icons Navigation -->

      <?php if (isset($_SESSION['alert']) && isset($_SESSION['alertClass'])): ?>

        <div class="alert alert-<?= $_SESSION['alertClass']; ?> alert-dismissible fade show position-fixed top-0 end-0 m-3"
          role="alert">
          <?= $_SESSION['alert']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
      <?php endif; ?>

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

      <button class="btn btn-outline-primary btn" data-bs-toggle="modal" data-bs-target="#NoticiaModal"
        style="margin-bottom: 12px; width: 100%">Criar Notícia</button>
      <a class="btn btn-outline-success btn" style="margin-bottom: 12px; width: 100%" href="./?op=7">Criar Ticket</a>

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tickets-enviados-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-arrow-up"></i><span>Tickets Enviados</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tickets-enviados-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="./?op=1&x=1">
                <i class="bi bi-circle-fill" style="color:red;"></i><span>Pendente</span>
              </a>
            </li>
            <li>
              <a href="./?op=1&x=2">
                <i class="bi bi-circle-fill" style="color:#FFD700;"></i><span>Aberto</span>
              </a>
            </li>
            <li>
              <a href="./?op=1&x=3">
                <i class="bi bi-circle-fill" style="color:#32CD32;"></i><span>Fechado</span>
              </a>
            </li>
          </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tickets-recebidos-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-arrow-down"></i><span>Tickets Recebidos</span><i
              class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tickets-recebidos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="./?op=2&x=1">
                <i class="bi bi-circle-fill" style="color:red;"></i><span>Pendente</span>
              </a>
            </li>
            <li>
              <a href="./?op=2&x=2">
                <i class="bi bi-circle-fill" style="color:#FFD700	;"></i><span>Aberto</span>
              </a>
            </li>
            <li>
              <a href="./?op=2&x=3">
                <i class="bi bi-circle-fill" style="color:#32CD32;"></i><span>Fechado</span>
              </a>
            </li>
          </ul>
        </li><!-- End Forms Nav -->


        <li class="nav-item">
          <a class="nav-link collapsed" href="./?op=3">
            <i class="bi bi-journal-x"></i>
            <span>Não Atribuídos</span>
          </a>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>Tabelas</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="./?op=5">
                <i class="bi bi-circle"></i><span>Utilizadores</span>
              </a>
            </li>
            <li>
              <a href="tables-data.html">
                <i class="bi bi-circle"></i><span>Departamentos</span>
              </a>
            </li>
          </ul>
        </li><!-- End Tables Nav -->



        <li class="nav-heading">Pages</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>F.A.Q</span>
          </a>
        </li><!-- End F.A.Q Page Nav -->


      </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">



      <?php

      unset($_SESSION['tipoTicket']);
      $pag_file = "./index.php";
      switch ($op) {
        case 0:
          $pag_file = "./pag/dashboard.php";
          break;
        case 1:
          $pag_file = "./pag/ticketList.php";
          $_SESSION['tipoTicket'] = "Enviados";
          break;
        case 2:
          $pag_file = "./pag/ticketList.php";
          $_SESSION['tipoTicket'] = "Recebidos";
          break;
        case 3:

          $pag_file = "./pag/ticketList.php";
          $_SESSION['tipoTicket'] = "Não atribuidos";
          break;
        case 4:
          $pag_file = "./pag/ticketview.php";
          break;
        case 5:
          $pag_file = "./pag/users/user.php";
          break;
        case 6:
          $pag_file = "./pag/editarPerfil.php";
          break;
        case 7:
          $pag_file = "./pag/inserirTicketForm.php";
          break;

        default:
          $pag_file = "./pag/error-404.html";
          break;
      }

      if (!file_exists($pag_file))
        $pag_file = "./pag/error-404.html";
      require ($pag_file);
      ?>

    </main><!-- End #main -->

    <div class="modal fade" id="NoticiaModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Criar Notícia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form id="criarNoticia" id="noticiasForm" action="./db/form.php" method="POST">
              <div class="mb-3">
                <label class="fw-bold">Data Início:</label>
                <input id="dateInput" name="dataIni" class="flatpickr flatpickr-input form-control" type="text"
                  placeholder="Selecione a data.." readonly="readonly">
              </div>
              <div class="mb-3">
                <label class="fw-bold">Data Fim:</label>
                <input id="dateInput" name="dataFim" class="flatpickr flatpickr-input form-control" type="text"
                  placeholder="Selecione a data.." readonly="readonly">
              </div>
              <div class="mb-3">
                <label class="fw-bold">Assunto:</label>
                <input class="form-control" name="assunto" type="text">
              </div>
              <div class="mb-3">
                <label class="fw-bold">Notícia:</label>
                <textarea class="form-control input-lg" name="noticia" rows="3"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar Notícia</button>
          </div>
          </form>
        </div>
      </div>
    </div>


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>Vitech</span></strong>. All Rights Reserved
      </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>



    <!-- Popper.js for Bootstrap tooltips and popovers -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Flatpickr for date picking -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>




    <script>


      flatpickr("#dateInput", {

        minDate: "today",


        altInput: true,
        altFormat: "F j, Y H:i",

        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minTime: "7:00",
        maxTime: "23:00"
      });
    </script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/mymain.js"></script>

    <?php
  }
  ?>


</body>


</html>