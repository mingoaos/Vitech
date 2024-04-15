
<?php 
if(isset($_GET['x'])) {
  $x = $_GET['x'];
  switch ($x) {
    case 1:
      $pendente = true;
      break;
    case 2:
      $aberto = true;
      break;
    case 3:
      $fechado = true;
      break;
  }
}



?>

<div class="card shadow mb-4">
<div class="card-header py-4 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h6 class="m-0" style="font-weight: 800;">
        <span style="color: #012970;">Tickets Enviados - </span>
        <a href="#" style="color: <?php echo ($pendente ? '#ff0000' : 'grey'); ?>;" role="button" onclick="changeColor(this, '#ff0000')">
            Pendente
        </a>
        <span style="color: #012970;"> - </span>
        <a href="#" style="color: <?php echo ($aberto ? '#FFD700' : 'grey'); ?>;" role="button" onclick="changeColor(this, '#FFD700')">
            Aberto
        </a>
        <span style="color: #012970;"> - </span>
        <a href="#" style="color: <?php echo ($fechado ? '#32CD32' : 'grey'); ?>;" role="button" onclick="changeColor(this, '#32CD32')">
            Fechado
        </a>
      </h6>

    </div>
</div>

            <div class="card-body py-4">
               
                <table class="table table-hover" id="datatable" width="100%" cellspacing="0">
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
                    <tr>
                      <td>1</td>
                      <td>Brandon Jacob</td>
                      <td data-href="index.php?op=1">Sala A0.05</td>
                      <td>2016-05-25</td>
                      <td><span class="badge bg-danger">Urgente</span></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bridie Kessler</td>
                      <td>Não consigo entrar no inovar o que faco?</td>
                      <td>2014-12-05</td>
                      <td><span class="badge bg-danger">Urgente</span></td>
                    </tr>
                    <!-- Add more rows as needed -->
                  </tbody>
                </table>
              </div>

  



