<?php

session_start();
 
if (empty($_SESSION['id'])) {

	header('Location:/PAP2024/pag/login/login.php');
	exit();
}
?>
