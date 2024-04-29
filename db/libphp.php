<?php 

require 'dbcon.php';

function getTicket($idticket)
{
    $query = "SELECT * FROM ticket where id_ticket = '$idticket'";

    $query_exec = mysqli_query($con,$query);

    if($query_exec && mysqli_num_rows($query_exec) == 1)
    {

       return $row = mysqli_fetch_assoc($query_exec);
    }

    return null;
}

if (isset($_POST['filter']) && isset($_POST['cardType'])) {
    $filter = $_POST['filter'];
    $cardType = $_POST['cardType'];

    
    switch ($cardType) {
        case 'abertos':
            
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'A'";
            break;
        case 'pendentes':
            
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'P'";
            break;
        case 'naoatribuidos':
            
            $query = "SELECT COUNT(*) FROM ticket WHERE id_user_atribuido = null";
            break;
        default:
            
            echo "Invalid card type";
            exit;
    }

    if($filter == "Meus")
    {
        $query = $query." AND id_user_atribuido = {$_SESSION['user']['id']} "
        echo $query
    }

    $count = getNumRows($con, $query);

    
    if ($count !== false) {
       
        echo $count;
    } else {
       
        echo "Error retrieving count";
    }
} else {
    
    echo "Filter or cardType not provided";
}


?>