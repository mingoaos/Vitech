<?php
require './libphp.php';
require './dbcon.php';
session_start();

if (isset($_POST['id_user'], $_POST['id_ticket'], $_POST['type']) && $_POST['type'] == 'mudarAtribuido') {
    $id_user = mysqli_real_escape_string($con, $_POST['id_user']);
    $id_ticket = mysqli_real_escape_string($con, $_POST['id_ticket']);

    $query = "UPDATE ticket SET id_user_atribuido = '$id_user', data_atribuido = CURDATE() WHERE id_ticket = $id_ticket";
    $query_exec = mysqli_query($con, $query);





    $data = [];
    if ($query_exec) {



        if (!empty($_POST["id_user"])) {
            $query = "SELECT u.nome, t.status 
            FROM ticket t 
            INNER JOIN user u ON u.id_user = t.id_user_atribuido 
            WHERE id_ticket = '$id_ticket'";
        } else {
            $query = "SELECT status FROM ticket 
            WHERE id_ticket = '$id_ticket'";
        }

        $result_query = mysqli_query($con, $query);

        if ($result_query) {

            $row = mysqli_fetch_array($result_query);
            $nome = isset($row['nome']) ? $row['nome'] : "Nenhum Técnico atribuído";

            if (addAcoes($id_ticket, 'alterou o Técnico atribuído no ticket', $row['status'], $con)) {

                $data[] = [
                    'action' => 'success',
                    'nome' => $nome
                ];

                echo json_encode($data);
                exit; // Ensure no further output after sending JSON
            } else {
                echo "error adding action log";
                exit; // Ensure no further output after error message
            }
        } else {
            echo "error updating ticket status: " . mysqli_error($con); // Check for MySQL errors
            exit; // Ensure no further output after error message
        }
    } else {
        echo "invalid request"; // Handle invalid requests
        exit;  // Handle invalid requests
    }
}

?>