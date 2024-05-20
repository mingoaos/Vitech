
<?php 

$filtro = [
  1 => false, // Filter 1
  2 => false, // Filter 2
  3 => false  // Filter 3
];

if(isset($_GET['x'])) {
  $x = $_GET['x'];
  switch ($x) {
    case 1:
      $filtro[1] = true;
      break;
    case 2:
      $filtro[2]  = true;
      break;
    case 3:
      $filtro[3]  = true;
      break;
  }
}




unset($_SESSION['current_page']);
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

if(isset($_SESSION['tipoTicket'])){
  $tipoTicket = $_SESSION['tipoTicket'];
}


?>

<script>
  getTickets($filtro,$tipoTicket);
</script>
<div class="card shadow mb-4">
<div class="card-header py-4 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h6 class="m-0" style="font-weight: 800;">
        <span style="color: #012970;">Tickets <?=$tipoTicket?></span>
        <?php if($tipoTicket != "Não atribuidos"):?>
          <span style="color: #012970;"> - </span>
          <a href="#" style="color: <?= ($filtro[1] ? 'red' : 'grey;'); ?>;" role="button" onclick="changeFiltro(this, '#ff0000', '1', '<?= $tipoTicket ?>')">
              Pendente
          </a>
          <span style="color: #012970;"> - </span>
          <a href="#" style="color: <?= ($filtro[2] ? 'gold' : 'grey;'); ?>;" role="button" onclick="changeFiltro(this, '#FFD700' ,'2', '<?= $tipoTicket ?>')">
              Aberto
          </a>
          <span style="color: #012970;"> - </span>
          <a href="#" style="color: <?= ($filtro[3] ? 'limegreen' : 'grey;'); ?>;" role="button" onclick="changeFiltro(this, '#32CD32', '3', '<?= $tipoTicket ?>')">
              Fechado
          </a>

          <input type="hidden" id="filtroInput" name="filtroInput" value="<?= htmlspecialchars(json_encode($filtro)) ?>">


        <?php endif; ?>
      </h6>

    </div>
</div>

            <div class="card-body py-4">
               
             <table class="table table-hover datatable" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= ($tipoTicket == 'Enviados') ? 'Técnico atribuído' : 'Reportado por' ?></th>
                        <th>Assunto</th>
                        <th>Data</th>
                        <th>Urgência</th>
                    </tr>
                </thead>
                <tbody id="ticketTableBody">
                    <!-- Table rows will be dynamically added here -->
                </tbody>
                </table>
              </div>

              <script>

                 
                document.addEventListener('DOMContentLoaded', function () {
                  
                  
                  

                  document.querySelector('#datatable tbody').addEventListener('click', function (event) {
                      tr = event.target.closest('tr');
                      var firstTd = tr.querySelector('td:first-child');
                      TdText = firstTd.textContent.trim();
                      if(TdText){
                        var href = './?op=3&id=' + TdText;
                          console.log(href);
                          if (href) {
                              window.location = href;
                          }
                      }
                  });


              });
              </script>




  



