<?php
session_start();

require './db/dbcon.php';
require './db/libphp.php';


$op = 0;
if(isset($_GET['op'])) 
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

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/mystyle.css" rel="stylesheet">
</head>

<body>
<?php
if (!isset($_SESSION['user'])) {

  include "./pag/login/login.php";


}
else
{

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

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

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

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-newspaper"></i>
            <span class="badge bg-success badge-number">2</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li class="message-item">
              <a href="#">
               
                <div class="text-center">
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

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
              <a class="dropdown-item d-flex align-items-center" href="pag/login/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <button class="btn btn-outline-primary btn" data-bs-toggle="modal" data-bs-target="#NoticiaModal" style="margin-bottom: 12px; width: 100%" >Criar Notícia</button>
    <button class="btn btn-outline-success btn" style="margin-bottom: 12px; width: 100%" >Criar Ticket</button>

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
          <i class="bi bi-journal-arrow-down"></i><span>Tickets Recebidos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tickets-recebidos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
            <i class="bi bi-circle-fill" style="color:red;"></i><span>Pendente</span>
            </a>
          </li>
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle-fill" style="color:#FFD700	;"></i><span>Aberto</span>
            </a>
          </li>
          <li>
            <a href="components-badges.html">
              <i class="bi bi-circle-fill" style="color:#32CD32;"></i><span>Fechado</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
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
            <a href="./?op=4">
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
          $pag_file = "./index.php";
          switch ($op) {
              case 0:
                  $pag_file = "./pag/dashboard.php";
                  break;
              case 1:
                  $pag_file = "./pag/tickets-enviados.php";
                  break;
              case 2:
                  $pag_file =  "./pag/ticketview.php";
                  break;
              case 3:
                  $pag_file = "./pag/user/user.php";
                  break;
              case 4:
                  $pag_file = "./pag/users/user.php";
                  break;    


              default:
                  $pag_file = "./pag/error-404.html";
                  break;
              }

      if(!file_exists($pag_file))
        $pag_file="./pag/error-404.html";
      require($pag_file);   
    ?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Vitech</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.datatables.net/v/bs4/dt-2.0.3/b-3.0.1/r-3.0.1/rg-1.5.0/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.js"></script>

  <!-- Template Main JS File -->
  
  
<?php
}
?>

<div class="modal fade" id="NoticiaModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold">Criar Notícia</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                 
                    <div class="modal-body">
                    <form id="criarNoticia" id="noticiasForm" action="./db/noticias.php" method="POST">
                      <div class="mb-3"> 
                        <label class="fw-bold">Data Início:</label>
                        <input id="dateInput" name="dataIni"class="flatpickr flatpickr-input form-control" type="text" placeholder="Selecione a data.." readonly="readonly">
                      </div>
                      <div class="mb-3"> 
                        <label class="fw-bold">Data Fim:</label>
                        <input id="dateInput" name="dataFim" class="flatpickr flatpickr-input form-control" type="text" placeholder="Selecione a data.." readonly="readonly">
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

</body>

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
</html>