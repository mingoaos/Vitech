<?php
unset($_SESSION['current_page']);
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

$departmentIdsString = implode(",", $_SESSION['user']['departamento']);
?>
<div class="pagetitle">
  <h1>Página inicial</h1>

</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">


        <div class="col-xxl-4 col-md-6">
          <div class="card info-card abertos-card" data-card-type="abertos">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <li><a class="dropdown-item" href="#" onclick="updateFiltro('Meus', '1')">Meus</a></li>
                <li><a class="dropdown-item" href="#" onclick="updateFiltro('Todos', '1')">Todos</a></li>
              </ul>
            </div>
            <div id="card-body-1" class="card-body">
              <h5 class="card-title">Abertos <span id="textoFiltro1">| Todos</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-mail-open-line"></i>
                </div>
                <div class="ps-3">
                  <h6><?= getCount($con, "SELECT COUNT(*) FROM ticket WHERE status = 'A' AND id_departamento_destino  IN ($departmentIdsString)") ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card pendentes-card" data-card-type="pendentes">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <li><a class="dropdown-item" href="#" onclick="updateFiltro('Meus', '2')">Meus</a></li>
                <li><a class="dropdown-item" href="#" onclick="updateFiltro('Todos', '2')">Todos</a></li>
              </ul>
            </div>
            <div id="card-body-2" class="card-body">
              <h5 class="card-title">Pendentes <span id="textoFiltro2">| Todos </span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-mail-settings-line"></i>
                </div>
                <div class="ps-3">
                  <h6><?= getCount($con, "SELECT COUNT(*) FROM ticket WHERE status = 'P' AND id_departamento_destino  IN ($departmentIdsString)") ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card naoatribuidos-card" data-card-type="naoatribuidos">
            <div class="card-body">
              <h5 class="card-title">Não Atribuídos <span>| Todos</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-mail-close-line"></i>
                </div>
                <div class="ps-3">
                  <h6><?= getCount($con, "SELECT COUNT(*) FROM ticket WHERE id_user_atribuido IS NULL AND id_departamento_destino  IN ($departmentIdsString)") ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>







        <!-- Alterações de estado -->
        <div class="col-12">
          <div class="card recent-abertos overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Alterações de estado</h5>

              <?php
              $acoes = atualizarRecentes($con, true);
              if (!empty($acoes)) {
                ?>
                <table class="table table-borderless table-hover ">
                  <thead>
                    <tr>
                      <th class="d-none" scope="col">#</th>
                      <th scope="col">Técnico</th>
                      <th scope="col">Assunto</th>
                      <th scope="col">Data</th>
                      <th scope="col">Tipo Ticket</th>
                      <th scope="col">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php


                    foreach ($acoes as $row) {
                      if (!empty($row['status_change'])) {


                        ?>
                        <tr class="table-<?= $row['color'] ?>">
                          <td class="d-none" href="?op=4&id=<?= $row['id_ticket'] ?>">
                            <?= $row['id_ticket'] ?>
                          </td>
                          <td><?= $row['nome_user'] ?></td>
                          <td class="fw-bold text-dark"><?= $row['assunto_local'] ?></td>
                          <td><?= $row['data_formated'] ?></td>
                          <td><?= ($row['tipo_ticket'] == 'I') ? 'Informação' : 'Avaria' ?></td>
                          <td><span class="badge bg-<?= $row['color'] ?>"><?= $row['status'] ?></span></td>
                        </tr>

                        <?php
                      }
                    }

                    ?>
                  </tbody>
                <?php } else {
                echo '<div style="background-color: #EEEEEE; display: flex; align-items: center; justify-content: center; border-radius: 10px; padding: 5px" class="fw-bold">Não foram encontrados dados...</div>';
              } ?>
              </table>

            </div>

          </div>
        </div><!-- End Recent abertos -->



      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

      <!-- Recent Activity -->
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Atividade Recente</h5>

          <div class="activity">

            <?php
            $acoes = atualizarRecentes($con);

            if (!empty($acoes)) {

              foreach ($acoes as $row) {

                ?>

                <div class="activity-item d-flex">
                  <div class="activite-label"><?= $row['tempo_decorrido'] ?></div>
                  <i class='bi bi-circle-fill activity-badge text-<?= $row['color'] ?> align-self-start'></i>
                  <div class="activity-content">
                    <?= $row['nome_user'] ?>     <?= $row['acao'] ?> <a class="fw-bold text-dark"
                      href="?op=4&id=<?= $row['id_ticket'] ?>">#<?= $row['id_ticket'] ?></a>
                  </div>
                </div><!-- End activity item-->

                <?php
              }
            } else {
              echo '<div style="background-color: #EEEEEE; display: flex; align-items: center; justify-content: center; border-radius: 10px; padding: 5px" class="fw-bold">Não foram encontrados dados...</div>';
            }


            ?>

          </div>

        </div>
      </div><!-- End Recent Activity -->

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Ticket reportados nos últimos 6 meses</h5>

          <!-- Bar Chart -->
          <canvas id="barChart" style="max-height: 400px;"></canvas>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              $.ajax({
                url: "./db/dashboardAjax.php",
                type: "POST",
                data: { type: "barAjax" },

                success: function (response) {
                  try {

                    const data = JSON.parse(response);
                    const labels = data.map(item => item.mes);
                    const chartData = data.map(item => item.total);

                    new Chart(document.querySelector('#barChart'), {
                      type: 'bar',
                      data: {
                        labels: labels,
                        datasets: [{
                          label: 'Tickets Reportados',
                          data: chartData,
                          backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)'

                          ],
                          borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)'

                          ],
                          borderWidth: 1
                        }]
                      },
                      options: {
                        scales: {
                          y: {
                            beginAtZero: true
                          }
                        }
                      }
                    });
                  } catch (error) {
                    console.error('Error parsing JSON:', error);
                  }
                },
                error: function (xhr, status, error) {
                  console.error('AJAX Error:', error);
                }
              });


              // Fazer as table rows clicaveis

              const rows = $(".table tbody tr");

              rows.each(function () {
                $(this).on("click", function () {
                  const href = $(this).find("td:first-child").attr("href");
                  if (href && href !== "") {
                    window.location.href = href;
                  }
                });
              });

            });

          </script>
          <!-- End Bar CHart -->

        </div>
      </div>




    </div><!-- End Right side columns -->

  </div>
</section>