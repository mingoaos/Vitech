<?php
require './db/dbcon.php';


$Deps = getDeps($con);
$Perms = getPerms($con);




?>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0" style="font-weight:800; color: #012970;">Utilizadores</h6>
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
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $user = getUser($con);

                    if (!empty($user)) {
                        foreach ($user as $row) {
                            ?>
                            <tr>
                                <td><?= $row['id_user'] ?></td>
                                <td><?= $row['nome'] ?></td>
                                <td><?= $row['email'] ?></td>

                                <td>

                                    <button type="button" class="btn btn-outline-primary btn-sm verMaisbtn"
                                        data-toggle="tooltip" data-placement="top" title="Ver Mais" data-toggle="modal"
                                        data-target="#viewModal" data-userid="<?= $row['id_user']; ?>">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>


                                    <button type="button" value="<?= $row['id_user']; ?>" data-toggle="tooltip"
                                        data-placement="top" title="Editar Dados" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" value="<?= $row['id_user']; ?>" data-toggle="tooltip"
                                        data-placement="top" title="Alterar Palavra-Passe"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-key-fill"></i>
                                    </button>

                                    <button id="deleteUser" type="button" value="<?= $row['id_user']; ?>" data-toggle="tooltip"
                                        data-placement="top" title="Eliminar" class="btn btn-outline-danger btn-sm">
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

<!-- Add Users Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Adicionar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="fw-bold">Nome:</label>
                    <input id="addNome" name="nome" class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Username:</label>
                    <input id="addUsername" name="username" class="form-control" type="text" readonly>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Email:</label>
                    <input id="addEmail" name="email" class="form-control" type="text" readonly>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Telefone:</label>
                    <input id="addTelefone" name="telefone" class="form-control" readonly></input>
                </div>
                <label for="departamento" class="form-label fw-bold col-md-7">Departamentos e Permissões</label>
                <div id="addDepsPerms" class="row mb-3">



                </div>

                <button id="addMaisDeps" type="button" class="btn btn-link mb-2"><i class="bi bi-plus-circle"></i>
                    Adicionar mais um departamento</button>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Adicionar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Ver Mais Modal -->
<div class="modal fade" id="verMaisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Ver Mais</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="fw-bold">Nome:</label>
                    <input id="VerMaisnome" name="nome" class="form-control" type="text" readonly>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Username:</label>
                    <input id="VerMaisusername" name="username" class="form-control" type="text" readonly>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Email:</label>
                    <input id="VerMaisemail" name="email" class="form-control" type="text" readonly>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Telefone:</label>
                    <input id="VerMaistelefone" name="telefone" class="form-control" readonly></input>
                </div>
                <label for="departamento" class="form-label fw-bold col-md-7">Departamentos e Permissões</label>
                <div id="VerMaisDepPerms" class="row mb-3">


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //inicializacao da datatable e etc...
        table = $('#datatable').DataTable({
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" },
                { "visible": false, "targets": 0 }
            ],

            "language": {
                "url": "./assets/json/pt_pt.json"

            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });


        //acoes ao pressionar em ver mais
        $('.verMaisbtn').click(function () {

            var userId = $(this).data('userid');

            $.ajax({
                url: "./db/userCode.php",
                type: "POST",
                data: { id_user: userId, type: "verMais" },

                success(response) {
                    var data = JSON.parse(response);

                    $('#verMaisModal').modal('show');
                    $('#VerMaisnome').val(data.nome);
                    $('#VerMaisusername').val(data.username);
                    $('#VerMaisemail').val(data.email);
                    $('#VerMaistelefone').val(data.telefone);

                    $('#VerMaisDepPerms').empty();
                    $.each(data['DepPerms'], function (index, item) {

                        var departamento = item.departamento;
                        var permissoes = item.permissoes;

                        let html = `
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <select class="form-select" name="departamento" required disabled>
                                    <option value="">${departamento}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="permissoes" required disabled>
                                    <option value="">${permissoes}</option>
                                </select>
                            </div>
                        </div>`;


                        $('#VerMaisDepPerms').append(html);
                    });
                }
            })
        });




        $('#addBtn').click(function () {
            $('#addModal').modal('show');
            $('#addDepsPerms').empty();
            $('#addDepsPerms').append(createDepsPermsTemplate());

        })
        $('#addMaisDeps').click(function () {
            $('#addDepsPerms').append(createDepsPermsTemplate(true));
        });

        $(document).on('click', '.btn-delete-row', function () {
            const idBtn = $(this).data('idbtn');

            $('#row-' + idBtn).remove();
        });


        let buttonIdCounter = 0;

        // Funcao para criar o template dos selects
        function createDepsPermsTemplate(includeButton = false) {
            let template = `
    <div class="row mb-3" id="row-${buttonIdCounter}">
        <div class="col-md-${includeButton ? 7 : 8}">
            <select class="form-select" name="departamento" required>
                <?php foreach ($Deps as $row) { ?>
                        <option value="<?= $row['id_departamento'] ?>"><?= $row['nome'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="permissoes" required>
                <?php foreach ($Perms as $row) { ?>
                        <option value="<?= $row['id_tipo_user'] ?>"><?= $row['nome'] ?></option>
                <?php } ?>
            </select>
        </div>`;

            if (includeButton && buttonIdCounter > 0) { 
               
                template += `
        <div style="padding-left: 3px" class="col-md-1">
            <button style="color:red;" id="btnDeleteRow-${buttonIdCounter}" data-idbtn="${buttonIdCounter}" class="btn btn-delete-row"><i class="bi bi-dash-circle"></i></button>
        </div>`;
            }

            template += `</div>`;
            buttonIdCounter++;
            return template;
        }
    })

</script>