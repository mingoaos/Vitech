<?php

require './dbcon.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass = sha1($_POST['password']);

    $query = "SELECT id_user,nome,email,username,telefone FROM user WHERE username = '$username' and password = '$pass'";

    $login = mysqli_query($con, $query);



    if ($login && mysqli_num_rows($login) == 1) {
        $user = mysqli_fetch_assoc($login);
        $id_user = $user['id_user'];
    
        
        $query = "SELECT d.id_departamento as departamento FROM departamento d
                  INNER JOIN user_departamento_tipo udt ON d.id_departamento = udt.id_departamento
                  INNER JOIN user u ON u.id_user = udt.id_user
                  INNER JOIN tipo_user tu ON udt.id_tipo = tu.id_tipo_user
                  WHERE u.id_user = $id_user";
    
        $getdeps = mysqli_query($con, $query);
    
        $deps = array();
    
       
        while ($row = mysqli_fetch_assoc($getdeps)) {
            $deps[] = $row["departamento"];
        }
    
       
        $_SESSION['user'] = $user;
        $_SESSION['user']['departamento'] = $deps;
    
        header('Location: ../'); 
        exit();
    } else {
        $_SESSION['error'] = 'Credenciais Erradas!';
    }
    header('Location:../');
    exit();
}


?>