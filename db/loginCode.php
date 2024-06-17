<?php

require './dbcon.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass = sha1($_POST['password']);

    $query = "SELECT * FROM user WHERE username = '$username' and password = '$pass'";

    $login = mysqli_query($con, $query);

    if ($login && mysqli_num_rows($login) == 1) {
        $_SESSION['user'] = mysqli_fetch_assoc($login);
    } else {
        $_SESSION['error'] = 'Credenciais Erradas!';
    }
    header('Location:../');
    exit();
}


?>