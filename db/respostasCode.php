<?php
session_start();
require "./dbcon.php";


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

            $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Resposta enviada com sucesso';
            $_SESSION['alertClass'] = 'success';
        } else {

            $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Erro ao associar a resposta ao ticket: ' . mysqli_error($con);
            $_SESSION['alertClass'] = 'danger';
        }
    } else {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Erro ao inserir a resposta: ' . mysqli_error($con);
        $_SESSION['alertClass'] = 'danger';
    }


    header("Location: .././?op=4&id=".$id_ticket);
    exit();
}




?>