<?php

require './dbcon.php';
session_start();

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['passAntiga'])) {

    $passAntiga = sha1($_POST['passAntiga']);

    // Corrigindo a consulta para adicionar aspas na senha
    $pass_query = "SELECT nome FROM user WHERE password = '$passAntiga' AND id_user = {$_SESSION['user']['id_user']}";
    $pass_check = mysqli_query($con, $pass_query);


    if ($pass_check && mysqli_num_rows($pass_check) == 1) {
        $nome = mysqli_real_escape_string($con, $_POST['nome']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $username = mysqli_real_escape_string($con, $_POST['username']);


        $check_query = "SELECT nome FROM user WHERE (email = '$email' OR username = '$username') AND id_user != {$_SESSION['user']['id_user']}";
        $check = mysqli_query($con, $check_query);

        if ($check && mysqli_num_rows($check) >= 1) {

            $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> Já existe alguém com esse Username/Email';
            $_SESSION['alertClass'] = "warning";
            header('Location: .././?op=6');
            exit();

        } else {
            $update_parts = [];

            if (!empty($_POST['passNova'])) {
                $passNova = sha1(mysqli_real_escape_string($con, $_POST['passNova']));
                $update_parts[] = "password = '$passNova'";
            }

            if (!empty($_POST['telemovel'])) {
                $telemovel = mysqli_real_escape_string($con, $_POST['telemovel']);
                $update_parts[] = "telemovel = '$telemovel'";
            }

            $update_query = "UPDATE user SET nome = '$nome', email = '$email', username = '$username'";
            if (!empty($update_parts)) {
                $update_query .= ", " . implode(", ", $update_parts);
            }
            $update_query .= " WHERE id_user = {$_SESSION['user']['id_user']}";

            $query_exec = mysqli_query($con, $update_query);

            if ($query_exec) {

                $query_dados = "SELECT * FROM user WHERE id_user = {$_SESSION['user']['id_user']}";
                $exec_dados = mysqli_query($con, $query_dados);

                if ($exec_dados && mysqli_num_rows($exec_dados) == 1) {
                    unset($_SESSION['user']);
                    $_SESSION['user'] = mysqli_fetch_assoc($exec_dados);
                }


                $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao atualizar os detalhes';
                $_SESSION['alertClass'] = "success";
                header('Location: .././?op=6');
                exit();
            } else {
                $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao atualizar os detalhes';
                $_SESSION['alertClass'] = "danger";
                header('Location: .././?op=6');
                exit();
            }
        }
    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Palavra-passe errada';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=6');
        exit();
    }
}


if (isset($_POST['id_user'], $_POST['type']) && $_POST['type'] == 'verMais') {
    $id_user = mysqli_real_escape_string($con, $_POST['id_user']);

$query = "SELECT nome, username, email, telefone FROM user WHERE id_user = $id_user";

$query_result = mysqli_query($con, $query);
if ($query_result && mysqli_num_rows($query_result) > 0) {
     
    $row = mysqli_fetch_assoc($query_result);
    
    $row['DepPerms'] = getDepUser($con,$id_user);

} else {
    $row = null; 
}

echo json_encode($row);

}





function getDepUser($con, $id_user){

    $queryPerms = "SELECT d.id_departamento, d.nome as departamento, t.id_tipo_user, t.nome as permissoes FROM user_departamento_tipo as udt
        INNER JOIN departamento as d ON udt.id_departamento = d.id_departamento
        INNER JOIN tipo_user as t ON udt.id_tipo = t.id_tipo_user
        WHERE id_user = $id_user";

    $queryPerms_result = mysqli_query($con, $queryPerms);

    if ($queryPerms_result && mysqli_num_rows($queryPerms_result) > 0) {
        $DepPerms = [];
        while ($perms_row = mysqli_fetch_assoc($queryPerms_result)) { 
            $id_departamento = $perms_row['id_departamento'];
            $id_permissoes = $perms_row['id_tipo_user'];
            $departamento = $perms_row['departamento'];
            $permissoes = $perms_row['permissoes'];

            $DepPerms[] = [
                'id_departamento' => $id_departamento,
                'departamento' => $departamento,
                'id_permissao'=> $permissoes,
                'permissoes' => $permissoes
            ];
        }
        return $DepPerms; 
    } else {
        return null; 
    }

}

?>