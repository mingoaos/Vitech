<?php 
require "./dbcon.php";
require "./libphp.php";

session_start();



if (isset($_POST['filtro']) && isset($_POST['cardId'])) {
    $filter = $_POST['filtro'];
    $cardId = $_POST['cardId'];

    
   
    switch ($cardId) {
        case 1:
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'A'";
            break;
        case 2:
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'P'";
            break;
        default:
            echo "Invalid card type";
            exit;
    }

  
    if ($filter == "Meus") {
       
        $query .= " AND id_user_atribuido = {$_SESSION['user']['id_user']}";
    }

    
    $count = getCount($con, $query);

    
    if ($count !== false) {
        echo $count;
    } else {
        echo "Error retrieving count";
    }
}
   



?>