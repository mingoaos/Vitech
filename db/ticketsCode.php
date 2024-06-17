<?php
require './libphp.php';
require './dbcon.php';
session_start();

//Criar um ticket
if (
    isset($_POST['assunto_local'], $_POST['tipo_ticket'], $_POST['mensagem_sintomas'], $_POST['id_departamento_destino'], $_POST['urgencia'])
) {

    $assunto_local = mysqli_real_escape_string($con, $_POST['assunto_local']);
    $tipo_ticket = mysqli_real_escape_string($con, $_POST['tipo_ticket']);
    $mensagem_sintomas = mysqli_real_escape_string($con, $_POST['mensagem_sintomas']);
    $id_departamento_destino = mysqli_real_escape_string($con, $_POST['id_departamento_destino']);
    $urgencia = mysqli_real_escape_string($con, $_POST['urgencia']);

    $query = "INSERT INTO `ticket`(`id_user`, `tipo_ticket`, `assunto_local`, `mensagem_sintomas`, `id_departamento_destino`, `urgencia`, `status`) 
        VALUES ('{$_SESSION['user']['id_user']}','$tipo_ticket','$assunto_local','$mensagem_sintomas','$id_departamento_destino','$urgencia','P')";

    $query_exec = mysqli_query($con, $query);

    if ($query_exec) {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao criar o ticket';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=1&x=1');
    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> Erro ao criar o ticket';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=7');
    }
} else {

    $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> Por favor, preencha todos os campos.';
    $_SESSION['alertClass'] = "danger";
    header('Location: .././?op=7');
}




//Alterar os status de um ticket
if (isset($_POST['id_status'], $_POST['id_ticket']) && $_POST['type'] == 'setStatus') {
    $id_status = mysqli_real_escape_string($con, $_POST['id_status']);
    $id_ticket = mysqli_real_escape_string($con, $_POST['id_ticket']);

    $query = "UPDATE ticket SET status = '$id_status' WHERE id_ticket = $id_ticket";
    $query_exec = mysqli_query($con, $query);

    if ($query_exec) {
        if (addAcoes($id_ticket, 'Alterou o estado no ticket', $id_status, $con)) {
            echo "success";
        } else {
            echo "error adding action log";
        }
    } else {
        echo "error updating ticket status: " . mysqli_error($con); // Check for MySQL errors
    }
} else {
    echo "invalid request"; // Handle invalid requests
}



?>