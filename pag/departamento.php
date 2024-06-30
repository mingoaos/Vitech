<?php
require './db/dbcon.php';
unset($_SESSION['current_page']);
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0" style="font-weight:800; color: #012970;">Departamentos</h6>
            <button type="button" class="btn btn-success" id="addBtn">
                Adicionar <i class="bi bi-plus-lg"></i>
            </button>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive mt-4">
            <table class="table table-hover datatable" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $dep = getDep($con);

                    if (!empty($dep)) {
                        foreach ($dep as $row) {
                            ?>
                            <tr>

                                <td><?= $row['nome'] ?></td>

                                <td>

                                    <button type="button" data-depid="<?= $row['id_departamento']; ?>" data-toggle="tooltip"
                                        data-placement="top" title="Editar Dados"
                                        class="btn btn-outline-warning btn-sm editarBtn">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" data-depid="<?= $row['id_departamento']; ?>" data-toggle="tooltip"
                                        data-placement="top" title="Eliminar" class="btn btn-outline-danger btn-sm deleteBtn">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>



                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/editar Users Modal -->


<!-- Palavra passe Modal -->
<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="titleModal" class="modal-title fw-bold"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="./db/departamentoCode.php" method="POST">
                    <input type="hidden" id="id_departamento" name="id_departamento" class="hidden">
                    <input type="hidden" id="typeForm" name="typeForm" class="hidden">

                    <div class="mb-3">
                        <label class="fw-bold">Departamento</label>
                        <input id="departamento" name="departamento" class="form-control" type="text" required
                            maxlength="30">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Adicionar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        table = $('#datatable').DataTable({
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" },
            ],

            "language": {
                "url": "./assets/json/pt_pt.json"

            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });



        $('.editarBtn').click(function () {

            var depId = $(this).data('depid');

            $('#modal').modal('show');

            $('#titleModal').text('Editar');
            $('#id_departamento').val(depId);
            $('#typeForm').val('editar');

            $.ajax({
                url: "./db/departamentoCode.php",
                type: "POST",
                data: { id_departamento: depId, type: "verMais" },
                success(response) {
                    var data = JSON.parse(response);

                    $('#departamento').val(data.nome);


                }
            })

        })

        $('#addBtn').click(function () {

            $('#modal').modal('show');
            $('#titleModal').text('Adicionar');
            $('#typeForm').val('add');


        })


        $('.deleteBtn').click(function () {
            var depId = $(this).data('depid');

            Swal.fire({
                title: 'Apagar',
                text: 'Tem a certeza que deseja apagar este departamento',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: 'Sim, apague',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: './db/departamentoCode.php',
                        method: 'POST',
                        data: { id_departamento: depId, type: "delete" },
                        success: function (response) {

                            data = JSON.parse(response);
                            if (data.status == 'success') {
                                Swal.fire({
                                    title: 'Apagado',
                                    text: 'Departamento apagado com sucesso',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erro',
                                    text: 'Erro ao apagar o departamento',
                                    icon: 'error'
                                })
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire('Erro', 'Erro ao apagar o departamento', 'error');
                        }
                    });
                }
            });

        })

    });
</script>