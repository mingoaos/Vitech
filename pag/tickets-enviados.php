
<?php 
if(isset($_GET['x'])) {
  $x = $_GET['x'];
  switch ($x) {
    case 1:
      $status = "Pendente";
      $status_color = "red";
      $s = "P";
      break;
    case 2:
      $status = "Abertos";
      $status_color = "rgb(204, 204, 0)";
      $s = "A";
      break;
    case 3:
      $status = "Fechados";
      $status_color = "greenyellow";
      $s = "F";
      break;
  }
}



?>

<div class="card shadow mb-4">
            <div class="card-header py-4 px-4 ">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="m-0" style="font-weight: 800;">
                      <span style="color: #012970;">Tickets Enviados - </span>
                      <span style="color: <?php echo $status_color; ?>"><?php echo $status; ?></span>
                  </h6>
                </div>
            </div>
            <div class="card-body py-4">
                <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Reportado Por</th>
                      <th>Assunto</th>
                      <th>Data</th>
                      <th>Urgência</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr data-href="index.php?op=1">
                      <td>1</td>
                      <td>Brandon Jacob</td>
                      <td>Sala A0.05</td>
                      <td>2016-05-25</td>
                      <td><span class="badge bg-danger">Urgente</span></td>
                    </tr>
                    <tr data-href="https://example.com/report/2">
                      <td>2</td>
                      <td>Bridie Kessler</td>
                      <td>Não consigo entrar no inovar o que faco?</td>
                      <td>2014-12-05</td>
                      <td><span class="badge bg-danger">Urgente</span></td>
                    </tr>
                    <!-- Add more rows as needed -->
                  </tbody>
                </table>



