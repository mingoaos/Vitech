<?php

require './dbcon.php';
session_start();

if(isset($_POST['assunto_local']) && isset($_POST['tipo_ticket']) && isset($_POST['mensagem_sintomas']) &&
    isset($_POST['id_departamento_destino']) && isset($_POST['urgencia']) )
{

    $assunto_local = mysqli_real_escape_string($con,$_POST['assunto_local']);
    $tipo_ticket = mysqli_real_escape_string($con,$_POST['tipo_ticket']);
    $mensagem_sintomas = mysqli_real_escape_string($con,$_POST['mensagem_sintomas']);
    $id_departamento_destino = mysqli_real_escape_string($con,$_POST['id_departamento_destino']);
    $urgencia = mysqli_real_escape_string($con,$_POST['urgencia']);

    $query = "INSERT INTO `ticket`(`id_user`, `tipo_ticket`, `assunto_local`, `mensagem_sintomas`, `id_departamento_destino`, `urgencia`, `status`) 
    VALUES ('{$_SESSION['user']['id_user']}','$tipo_ticket','$assunto_local','$mensagem_sintomas','$id_departamento_destino','$urgencia','P')";

    $query_exec = mysqli_query($con,$query);

    if($query_exec){

        $_SESSION['alert'] = "Sucesso ao criar o ticket";
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=1&x=1');
    }else{
        $_SESSION['alert'] = "Erro ao criar o ticket";
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=7');
    }
} else {
  
    $_SESSION['alert'] = "Por favor, preencha todos os campos.";
    $_SESSION['alertClass'] = "danger";
    header('Location: .././?op=7');
}



?>