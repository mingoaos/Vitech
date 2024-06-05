<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;


$ticket = getTicket($con, $id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accordion Example</title>
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

        .grandão {
            transition: transform 0.3s ease;
        }

        .grandão:hover {
            transform: scale(1.2);
        }
    </style>

    <script>
        function aparecerlocalresposder() {
            var responseDiv = document.getElementById("responseDiv");
            if (responseDiv.style.display === "none") {
                responseDiv.style.display = "block";
            } else {
                responseDiv.style.display = "none";
            }
        }

        function aparecerlocalrespostas() {
            var respostasDadas = document.getElementById("respostasDadas");
            if (respostasDadas.style.display === "none") {
                respostasDadas.style.display = "block";
            } else {
                respostasDadas.style.display = "none";
            }
        }
    </script>

</head>

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
                                                <span
                                                    style="color: gray; font-size: 15px; display:flex; align-items: last baseline; margin-bottom: 3px; margin-left: 1px;">Data
                                                    criada: <?= $ticket['data'] ?></span>
                                            </div>
                                            <a href=""
                                                style="margin-left: auto; margin-right: 20px; font-size: 15px; text-decoration: none; color: gray;"
                                                class="grandão">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
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
                                <div style="display: flex; gap: 10px; margin-top: 10px;">
                                    <textarea placeholder="escreva a resposta" class="form-control"
                                        id="exampleFormControlTextarea1" rows="5"
                                        style="border: none; border-bottom: 1px solid gray; border-radius: 0%;"></textarea>
                                    <button class="btn btn-primary grandão"
                                        style="display: flex; height: 30px; width: 30px; align-items: center; justify-content: center;">
                                        <i class="bi bi-arrow-up-short" style="font-size: 20px;"></i>
                                    </button>
                                </div>
                            </div>

                            <div style="margin-top: 20px; display: flex; gap: 5px; margin-top: -4px;">
                                <button class="btn btn-success"
                                    style="height: 35px; display: flex; align-items: center;"
                                    onclick="aparecerlocalresposder()">
                                    <i class="bi bi-arrow-left-right" style="margin-right: 8px;"></i>Responder
                                </button>
                                <button class="btn btn-danger" style="height: 35px; display: flex; align-items: center;">
                                    <i class="bi bi-check2-square" style="margin-right: 8px;"></i>Fechar Ticket
                                </button>
                            </div>
                            <hr style="width: 100%; margin-top: 15px; border-width: 0.01em;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-top: -5px;">
                                <button class="btn grandão"
                                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #EEEEEE; color: black"
                                    onclick="aparecerlocalrespostas()">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <span>Exibir todas as respostas</span>
                            </div>

                            <div id="respostasDadas" style="display: none;">
                                <div style="display: flex; margin-top: 20px;">
                                    <i class="bi bi-person-circle" style="font-size: 50px; margin-right: 15px;"></i>
                                    <div class="accordion" id="accordionExample" style="width: 100%">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <div class="fs20"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; display: flex; height: 40px; align-items: center; padding-left: 10px; background-color: transparent; border-bottom: 1px solid gray;">
                                                    <div style="display: flex;">
                                                        <div class="mx-2"
                                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            username</div>
                                                    </div>
                                                </div>
                                            </h2>
                                            <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates
                                                    fuga
                                                    provident tenetur numquam! Possimus, ducimus corporis quibusdam
                                                    reprehenderit, soluta est velit nobis modi veniam mollitia ipsum
                                                    amet rerum
                                                    quia voluptates?
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                        <h6 style="font-weight: bold; text-transform: uppercase;">coisa
                                                        </h6>
                                                        <span
                                                            style="font-size: 15px; color: gray; position: relative; top: -7px;">subcoisa</span>
                                                    </div>
                                                </div>
                                                <div style="display: flex; font-size: 15px; margin-top: 10px;">
                                                    <i class="mx-2 bi bi-circle-fill"
                                                        style="font-size: 12px;color:#32CD32; margin-top: 3px;"></i>
                                                    <div>
                                                        <h6 style="font-weight: bold; text-transform: uppercase;">coisa
                                                        </h6>
                                                        <span
                                                            style="font-size: 15px; color: gray; position: relative; top: -7px;">subcoisa</span>
                                                    </div>
                                                </div>
                                                <hr style="border-width: 0.01em; width: 100%; margin: 0px;">
                                            </div>
                                        </div>
                                    </h2>
                                    <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body" style="overflow: hidden; text-overflow: ellipsis;">
                                            <div>
                                                <div style="display:flex;">
                                                    <span>Item</span>
                                                    <a href=""
                                                        style="margin-left: auto; text-decoration: none; color: black;"
                                                        class="grandão"><i class="bi bi-gear-fill"></i></a>
                                                </div>
                                                <div style="display: flex; align-items: center; margin-top: 3px;">
                                                    <i class="bi bi-intersect"
                                                        style="margin-right: 10px; font-size: 25px;"></i>
                                                    <span>coisa item</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-width: 0.01em; width: 100%; margin: 0px;">
                                        <div class="accordion-body" style="overflow: hidden; text-overflow: ellipsis;">
                                            <div>
                                                <div style="display:flex;">
                                                    <span>Técnico</span>
                                                </div>
                                                <div style="display: flex; align-items: center; margin-top: 3px;">
                                                    <i class="bi bi-person-circle"
                                                        style="margin-right: 10px; font-size: 25px;"></i>
                                                    <span><?= !empty($ticket['user_atribuido']) ? $ticket['user_atribuido'] : 'Nenhum Técnico atribuído' ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-width: 0.01em; width: 100%; margin: 0px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</body>

</html>