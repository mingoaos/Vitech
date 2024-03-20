<?php

session_start();

require '../../db/dbcon.php';

if (isset($_POST['username']) && isset($_POST['password']))
{
    
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $pass = sha1($_POST['password']);

    $query = "SELECT id_user,nome,id_departamento,tipo_user FROM user WHERE username = '$username' and password = '$pass'";

    $login = mysqli_query($con,$query);


	if ($login && mysqli_num_rows($login) == 1) {
        $row = mysqli_fetch_assoc($login);

		$_SESSION['id'] = $row['id_user'];
		$_SESSION['nome'] = $row['nome'];
        $_SESSION['tipo'] = $row['tipo_user'];
        $_SESSION['departamento'] =$row['id_departamento'];
     

        
		header('Location: ../../index.php?op=1');
        exit(); 

	} else {
        
        $_SESSION['error'] = 'credenciais';
		header('Location: login.php');
        exit(); 
        

    }


}
?>