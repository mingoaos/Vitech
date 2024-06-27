<?php
session_start();
require "./dbcon.php";
require "./libphp.php";

//Query para inserir respostas nos tickets
if (isset($_POST['resposta'], $_POST['id_ticket'])) {
    
    $resposta = mysqli_real_escape_string($con, $_POST['resposta']);
    $id_ticket = mysqli_real_escape_string($con, $_POST['id_ticket']);

    $query = "INSERT INTO resposta(`id_user`, `resposta`) VALUES ('{$_SESSION['user']['id_user']}', '$resposta')";
    $result = mysqli_query($con, $query);

    if ($result) {

        $id_resposta = mysqli_insert_id($con);


        $query_link = "INSERT INTO resposta_ticket(`id_resposta`, `id_ticket`) VALUES ('$id_resposta', '$id_ticket')";
        $result_link = mysqli_query($con, $query_link);

        if ($result_link) {
            $query = "SELECT status FROM ticket WHERE id_ticket = '$id_ticket'";
            $result_query = mysqli_query($con, $query);
            if ($result_query) {
                $status = mysqli_fetch_array($result_query);
                addAcoes($id_ticket, 'adicionou um comentário no ticket', $status['status'], $con);

                $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Resposta enviada com sucesso';
                $_SESSION['alertClass'] = 'success';

            } else {
                $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Erro ao associar a resposta ao ticket: ' . mysqli_error($con);
                $_SESSION['alertClass'] = 'danger';
            }



        } else {

            $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Erro ao associar a resposta ao ticket: ' . mysqli_error($con);
            $_SESSION['alertClass'] = 'danger';
        }
    } else {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Erro ao inserir a resposta: ' . mysqli_error($con);
        $_SESSION['alertClass'] = 'danger';
    }


    header("Location: .././?op=4&id=" . $id_ticket);
    exit();
}

if (isset($_POST["id_resposta"]) && $_POST["type"] == 'deleteResposta') {

    $id_resposta = mysqli_real_escape_string($con, $_POST['id_resposta']);
    
    $query = "DELETE FROM resposta WHERE id_resposta = $id_resposta";
    $result = mysqli_query($con, $query);

    $queryconect = "DELETE FROM resposta_ticket WHERE id_resposta = $id_resposta";
    $resultconect = mysqli_query($con, $queryconect);
    error_log($resultconect,$result);

    if ($result && $resultconect) {
        echo json_encode('success');

    } else {
        echo json_encode('error');
    }
}




?>