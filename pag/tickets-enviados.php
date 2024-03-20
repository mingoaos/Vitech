
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
                                <th>Ações</th>
                            </tr>
                            <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>28</td>
                    <td>2016-05-25</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Bridie Kessler</td>
                    <td>Developer</td>
                    <td>35</td>
                    <td>2014-12-05</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Ashleigh Langosh</td>
                    <td>Finance</td>
                    <td>45</td>
                    <td>2011-08-12</td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Angus Grady</td>
                    <td>HR</td>
                    <td>34</td>
                    <td>2012-06-11</td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Raheem Lehner</td>
                    <td>Dynamic Division Officer</td>
                    <td>47</td>
                    <td>2011-04-19</td>
                  </tr>
                </tbody>
              </table>



