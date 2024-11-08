<?php


$id = isset($_GET['id']) ? $_GET['id'] : 0;


$ticket = getTicket($con, $id);

$resposta = getRespostas($con, $id);

$isfechado = ($ticket['status'] == 'F') ? true : false;
?>

<style>
    .V1 {
        display: flex;
    }

    .V2 {
        width: 75%;
    }

    .V3 {
        width: 25%;
        margin-left: auto;
    }

    @media (max-width: 1080px) {
        .V1 {
            display: block;
        }

        .V2 {
            width: 100%;
        }

        .V3 {
            width: 100%;
            margin-left: 0;
            margin-top: 20px;
        }
    }


    #addUserDiv a {
        display: block;
        margin-right: 0;
        box-sizing: border-box;
        text-align: left;
    }
</style>

<script>
    function aparecerlocalresponder() {
        var responseDiv = $("#responseDiv");
        if (responseDiv.css("display") === "none") {
            responseDiv.css("display", "block");
        } else {
            responseDiv.css("display", "none");
        }
    }

    function aparecerlocalrespostas() {
        var respostasDadas = $("#respostasDadas");
        var iconBtnAparecer = $("#iconBtnAparecer");

        if (respostasDadas.css("display") === "none") {
            iconBtnAparecer.removeClass("bi-plus-lg").addClass("bi-dash-lg");
            respostasDadas.css("display", "block");
        } else {
            iconBtnAparecer.removeClass("bi-dash-lg").addClass("bi-plus-lg");
            respostasDadas.css("display", "none");
        }
    }



</script>


<body>
    <div class="container" style="max-width: 2000px;">
        <div class="card shadow">
            <div class="card-body">

                <div style="width: 100%; display: flex; border-bottom: 1px solid gray">
                    <a href="<?= $_SESSION['current_page'] ?>" style="display: flex; margin-top: 3px;">
                        <i class="bi bi-arrow-left arrow"></i>
                    </a>
                    <h1 style="margin-top: 10px"><?= $ticket['assunto_local'] ?></h1>
                    <h2 class="id_ticket">#<?= $ticket['id_ticket'] ?></h2>
                </div>

                <div style="display: flex; margin-top: 20px;">
                    <i class="bi bi-person-circle" style="font-size: 50px; margin-right: 15px;"></i>
                    <div class="V1" style="gap: 20px; width: 100%;">

                        <div class="V2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <div class="fs20"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; display: flex; height: 40px; align-items: center; padding-left: 10px; background-color: transparent; border-bottom: 1px solid gray;">
                                            <div style="display: flex;">
                                                <div class="mx-2"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <?= $ticket['user_criado'] ?>
                                                </div>

                                            </div>

                                        </div>
                                    </h2>
                                    <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <?= $ticket['mensagem_sintomas'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="width: 100%; margin-top: 25px; border-width: 0.01em;">
                            <div id="responseDiv" style="width: 100%; margin-bottom: 20px; display: none;">
                                <form action="./db/respostasCode.php" method="POST">
                                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                                        <textarea placeholder="Escreva a sua resposta" name="resposta"
                                            class="form-control" id="exampleFormControlTextarea1" rows="5"
                                            style="border: none; border-bottom: 1px solid gray; border-radius: 0%;"></textarea>
                                        <input type="hidden" id="id_ticket" name="id_ticket"
                                            value="<?= $ticket['id_ticket'] ?>" />
                                        <button type="submit" class="btn btn-primary grandão" id="btnResponder" <?=$isfechado ? 'disabled' : ''?>
                                            style="display: flex; height: 150px; width: 70px; align-items: center; justify-content: center;">
                                            <i class="bi bi-arrow-up-short" style="font-size: 50px;"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div style="margin-top: 20px; display: flex; gap: 5px; margin-top: -4px;">
                                <button class="btn btn-success" id="btnAparecerResponder" <?=$isfechado ? 'disabled' : ''?>
                                    style="height: 35px; display: flex; align-items: center;"
                                    onclick="aparecerlocalresponder()">
                                    <i class="bi bi-arrow-left-right" style="margin-right: 8px;"></i>Responder
                                </button>

                            </div>
                            <hr style="width: 100%; margin-top: 15px; border-width: 0.01em;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-top: -5px;">
                                <button class="btn grandão"
                                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #EEEEEE; color: black"
                                    onclick="aparecerlocalrespostas()">
                                    <i id="iconBtnAparecer" class="bi bi-plus-lg"></i>
                                </button>
                                <span>Exibir todas as respostas</span>
                            </div>

                            <div id="respostasDadas" style="display: none;">

                                <?php
                                if (!empty($resposta) && is_array($resposta)) {


                                    foreach ($resposta as $index => $row) { ?>
                                        <div class="resposta" style="display: flex; margin-top: 20px;">
                                            <i class="bi bi-person-circle" style="font-size: 50px; margin-right: 15px;"></i>
                                            <div class="accordion" id="accordionExample" style="width: 100%">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                                        <div class="fs20"
                                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; display: flex; height: 40px; align-items: center; padding-left: 10px; background-color: transparent; border-bottom: 1px solid gray;">
                                                            <div style="display: flex;">
                                                                <div class="mx-2"
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                    <?= $row['nome'] ?>
                                                                </div>
                                                                <span
                                                                    style="color: gray; font-size: 15px; display:flex; align-items: last baseline; margin-bottom: 3px;">
                                                                    <?= $row['data'] ?>
                                                                </span>
                                                            </div>
                                                            <?php if ($row['id_user'] == $_SESSION['user']['id_user']): ?>
                                                                <div style="margin-left: auto; margin-right: 13px;">
                                                                    <button style="font-size: 20px; color:red;" data-respostaid="<?=$row['id_resposta']?>" class="btn btnApagarResposta"><i
                                                                            class="bi bi-trash-fill"></i></button>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                    </h2>
                                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse show"
                                                        aria-labelledby="heading<?= $index ?>"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <?= $row['resposta'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                            </div>

                            <hr style="border-width: 0.01em; width: 100%; margin-top: 15px;">

                        </div>

                        <div class="V3">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item"
                                    style="background-color: transparent !important; border: none;">
                                    <h2 class="accordion-header" id="headingOne">
                                        <div class="fs20"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; display: flex; align-items: center;background-color: transparent;">
                                            <div
                                                style="gap: 10px; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; flex-direction: column;">
                                                <div style="display: flex; font-size: 15px; margin-top: 10px;">
                                                    <i class="mx-2 bi bi-circle-fill"
                                                        style="font-size: 12px;color:#32CD32; margin-top: 3px;"></i>
                                                    <div>
                                                        <h6 style="font-weight: bold; text-transform: uppercase;">
                                                            <?= $ticket['data'] ?>
                                                        </h6>
                                                        <span
                                                            style="font-size: 15px; color: gray; position: relative; top: -7px;">Data
                                                            Criado</span>
                                                    </div>
                                                </div>
                                                <div style="display: flex; font-size: 15px; margin-top: 10px;">
                                                    <i class="mx-2 bi bi-circle-fill"
                                                        style="font-size: 12px;color:#32CD32; margin-top: 3px;"></i>
                                                    <div>
                                                        <h6 style="font-weight: bold; text-transform: uppercase;">
                                                            <?= !empty($ticket['data_acao']) ? $ticket['data_acao'] : 'Nenhuma Alteração Feita' ?>
                                                        </h6>
                                                        <span
                                                            style="font-size: 15px; color: gray; position: relative; top: -7px;">Última
                                                            alteração</span>
                                                    </div>
                                                </div>
                                                <hr style="border-width: 0.01em; width: 100%; margin: 0px;">
                                            </div>
                                        </div>
                                    </h2>

                                    <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body" style="overflow: visible; position: relative;">
                                            <div>
                                                <div style="display:flex;">
                                                    <span>Estado</span>

                                                    <div class="dropdown" style="margin-left: auto;">
                                                        <a style=" text-decoration: none; color: black;" type="button" <?=$ticket['id_criador'] == $_SESSION['user']['id_user'] ? 'disabled' : ''?>
                                                            id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-gear-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu" style="z-index: 1060;"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <h6 class="dropdown-header">Estados</h6>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setStatus('P', 'Pendente','red','<?= $ticket['id_ticket'] ?>')"><i
                                                                    class="mx-2 bi bi-circle-fill"
                                                                    style="font-size: 12px;color:red; "></i>Pendente</a>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setStatus('A', 'Aberto','#FFD700','<?= $ticket['id_ticket'] ?>')">
                                                                <i class="mx-2 bi bi-circle-fill"
                                                                    style="font-size: 12px;color:#FFD700; "></i>Aberto</a>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="setStatus('F', 'Fechado','#32CD32','<?= $ticket['id_ticket'] ?>')"><i
                                                                    class="mx-2 bi bi-circle-fill"
                                                                    style="font-size: 12px;color:#32CD32; "></i>Fechado</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-top: 3px;">
                                                <i id="estadoBola" class="mx-2 bi bi-circle-fill"
                                                    style="font-size: 12px; color: <?= $ticket['statusColor'] ?>;"></i>
                                                <div>
                                                    <h6 id="estadoText"
                                                        style="font-weight: bold; text-transform: uppercase; margin-top: 10px;">
                                                        <?= $ticket['statusText'] ?>
                                                    </h6>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr style="border-width: 0.01em; width: 100%; margin: 0px;">
                                    <div class="accordion-body"
                                        style="overflow: visible !important; text-overflow: ellipsis;">
                                        <div>
                                            <div style="display:flex;">
                                                <span>Técnico atribuído</span>
                                            </div>
                                            <div
                                                style="display: flex; align-items: center; margin-top: 3px; position: relative; z-index: 1050;">
                                                <i class="bi bi-person-circle"
                                                    style="margin-right: 10px; font-size: 25px;"></i>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary-overlay dropdown-toggle" <?=$isfechado || $ticket['id_criador'] == $_SESSION['user']['id_user'] ? 'disabled' : ''?>
                                                        type="button" id="userDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <?= !empty($ticket['user_atribuido']) ? $ticket['user_atribuido'] : 'Nenhum Técnico atribuído' ?>
                                                    </button>
                                                    <ul class="dropdown-menu pt-0" aria-labelledby="userDropdown"
                                                        id="divDropdown" style="position: absolute; z-index: 1060;">
                                                        <input type="text" id="input"
                                                            class="form-control border-0 border-bottom shadow-none mb-2"
                                                            placeholder="Search..." onkeyup="filterFunction()">
                                                        <a class="btn btnUserAtrib" data-userid="null" href="#">Nenhum
                                                            Técnico</a>
                                                        <div id="addUserDiv">

                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="z-index: 1000;border-width: 0.01em; width: 100%; margin: 0px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script>


    $(document).ready(function () {
        var allusers = <?= json_encode(getUser($con,$ticket['id_criador'])); ?>;
        var id_ticket = <?= json_encode($id); ?>;
        var html = ``;

        allusers.forEach((user) => {
            html += `<a class="btn btnUserAtrib" data-userid="${user.id_user}" href="#">${user.nome}</a>`;
        });

        $('#addUserDiv').append(html);


        $(document).on('click', '.btnUserAtrib', function () {
            var userId = $(this).data('userid');


            $.ajax({
                url: './db/userAtribCode.php',
                type: 'POST',
                data: { id_ticket: id_ticket, id_user: userId, type: 'mudarAtribuido' },
                success(response) {

                    var data = JSON.parse(response)[0];
                    if (data.action === "success") {
                        $('#userDropdown').text(data.nome);
                    }

                }
            })

        })

        $(document).on('click', '.btnApagarResposta', function () {
            var id_resposta = $(this).data('respostaid')
            var button = $(this);
            console.log(id_resposta);
            Swal.fire({
                title: 'Apagar',
                text: 'Tem a certeza que deseja apagar esta resposta',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: 'Sim, apague',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                $.ajax({
                    url: './db/respostasCode.php',
                    type: 'POST',
                    data: { id_resposta: id_resposta, type: 'deleteResposta' },
                    success(response) {
                    
                        var data = JSON.parse(response);

                        if (data === 'success') {
                            button.closest('.resposta').remove();
                            Swal.fire('Apagado!', 'A resposta foi apagada com sucesso.', 'success');
                        } else {
                            Swal.fire('Erro!', 'Ocorreu um erro ao apagar a resposta.', 'error');
                        }
                    },
                });
            });
        });

    })






    function filterFunction() {
        const input = $('#input').val().toUpperCase();
        const div = $('#divDropdown');
        const a = div.find('a');

        a.each(function () {
            const txtValue = $(this).text();
            if (txtValue.toUpperCase().indexOf(input) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
</script>