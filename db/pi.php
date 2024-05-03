<?php 
require "dbcon.php";
session_start();

function getCount($con, $query) {
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_row($result);
        return $row[0];
    } else {
        return 0;
    }
}

if (isset($_POST['filtro']) && isset($_POST['cardId'])) {
    $filter = $_POST['filtro'];
    $cardId = $_POST['cardId'];

    // Assuming you have established the database connection $con
   
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

    // Append additional conditions for 'Meus' filter
    if ($filter == "Meus") {
        // Assuming $_SESSION['user']['id'] is properly set
        $query .= " AND id_user_atribuido = {$_SESSION['user']['id_user']}";
    }

    // Get the count based on the query
    $count = getCount($con, $query);

    // Output the count
    if ($count !== false) {
        echo $count;
    } else {
        echo "Error retrieving count";
    }
}
   



?>