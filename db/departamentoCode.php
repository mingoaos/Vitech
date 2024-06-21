<?php
require './libphp.php';
require './dbcon.php';
session_start();

if(isset($_POST['id_departamento'], $_POST['type']) && $_POST['type'] == 'verMais'){

   
        $id_departamento = mysqli_real_escape_string($con, $_POST['id_departamento']);
    
        $query = "SELECT nome FROM departamento WHERE id_departamento = $id_departamento";
    
        $query_result = mysqli_query($con, $query);
        if ($query_result && mysqli_num_rows($query_result) > 0) {
    
            $row = mysqli_fetch_assoc($query_result);
    
          
    
        } else {
            $row = null;
        }
    
        echo json_encode($row);
    
}

if(isset($_POST['id_departamento'], $_POST['departamento'],$_POST['typeForm']) && $_POST['typeForm'] == 'editar'){

    $departamento = mysqli_real_escape_string($con, $_POST['departamento']);
    $id_departamento = mysqli_real_escape_string($con, $_POST['id_departamento']);

    $query = "UPDATE departamento SET nome = '$departamento' WHERE id_departamento = $id_departamento";

    $query_result = mysqli_query($con, $query);
    if ($query_result) {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao atualizar os detalhes';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=8');
        exit();

      

    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao atualizar os detalhes';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=8');
        exit();
    }


}

if(isset($_POST['departamento'], $_POST['typeForm']) && $_POST['typeForm'] == 'add'){

    $departamento = mysqli_real_escape_string($con, $_POST['departamento']);
    

    $query = "INSERT INTO departamento (nome) VALUES('$departamento')";

    $query_result = mysqli_query($con, $query);
    if ($query_result) {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao adicionar ';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=8');
        exit();

      

    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao adicionar';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=8');
        exit();
    }


}

if (isset($_POST['id_departamento']) && $_POST['type'] == 'delete') {

    $id_departamento = mysqli_real_escape_string($con, $_POST['id_departamento']);

    $query = "DELETE FROM departamento WHERE id_departamento = '$id_departamento'";

    $queryUser_exec = mysqli_query($con, $query);

    if ($queryUser_exec) {

        $query = "DELETE FROM user_departamento_tipo WHERE id_departamento = '$id_departamento'";
        $queryDeps_exec = mysqli_query($con, $query);

        if ($queryDeps_exec) {
            echo json_encode(array("status" => "success"));
            exit();
        }
    } else {

        echo json_encode(array("status" => "error"));
        exit();
    }


}





?>