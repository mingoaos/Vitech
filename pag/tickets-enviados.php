
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

$id=0;
if(isset($_GET['id'])) {
  $id = $_GET['id'];
}

unset($_SESSION['current_page']);
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];


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
               
                <table class="table table-hover datatable" id="datatable" width="100%" cellspacing="0">
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
                    <?php
                     
                        $resultado = getTicketList($con);

                          foreach($resultado as $ticket)
                          {
                            
                              ?>
                              <tr class="table-warning">
                                  <td><?= $ticket['id_ticket'] ?></td>
                                  <td><?= $ticket['nome_user'] ?></td>     
                                  <td><?= $ticket['assunto_local'] ?></td>
                                  <td><?= $ticket['data'] ?></td>
                                  <td><?php if($ticket['urgencia']) echo("<span class='badge bg-danger'>Urgente</span>") ?></td>
                                
                              </tr>
                              <?php
                          }
                      
                    ?>
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
                        var href = './?op=2&id=' + TdText;
                          console.log(href);
                          if (href) {
                              window.location = href;
                          }
                      }
                  });


              });
              </script>




  



