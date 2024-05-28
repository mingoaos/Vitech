<?php

require './dbcon.php';
session_start();

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['username'])) 
{

    $nome = mysqli_real_escape_string($con,$_POST['nome']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $username = mysqli_real_escape_string($con,$_POST['username']);
    

    $check_query = "SELECT nome FROM user WHERE (email = '$email' OR username = '$username') AND id_user != {$_SESSION['user']['id_user']}";

    $check = mysqli_query($con,$check_query);

    if($check && mysqli_num_rows($check) >= 1)
    {
        $_SESSION['alert'] = "Já existe alguem com esse Username/Email";
        $_SESSION['alertClass'] = "warning";

        header('Location: .././');
        exit();


    }else{

        $query = "UPDATE SET nome = $nome, email = $email, username = $username  WHERE id_user = {$_SESSION['user']['id_user']}";

        $query_exec = mysqli_query($con,$query);

        if($query_exec)
        {
            $_SESSION['alert'] = "Erro ao atualizar o Utilizador";
            $_SESSION['alertClass'] = "success";
        
            header('Location: .././');
            exit(); 
        }

        
        
        
        
    }
    
}else{
    $_SESSION['alert'] = "Erro ao atualizar o Utilizador";
    $_SESSION['alertClass'] = "warning";

    header('Location: .././');
    exit();

}

if(isset($_POST['passAntiga']) && isset($_POST['passNova']))
{
    $passAntiga = sha1($_POST['passAntiga']);
    $passNova = sha1($_POST['passNova']);


}


?>