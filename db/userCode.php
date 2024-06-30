<?php

require './dbcon.php';
session_start();

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['passAntiga'])) {

    $passAntiga = sha1($_POST['passAntiga']);


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
                $update_parts[] = "telefone = '$telemovel'";
            }

            $update_query = "UPDATE user SET nome = '$nome', email = '$email', username = '$username'";
            if (!empty($update_parts)) {
                $update_query .= ", " . implode(", ", $update_parts);
            }
            $update_query .= " WHERE id_user = {$_SESSION['user']['id_user']}";

            $query_exec = mysqli_query($con, $update_query);

            if ($query_exec) {


                $query = "SELECT id_user,nome,email,username,telefone FROM user WHERE id_user = {$_SESSION['user']['id_user']}";

                $login = mysqli_query($con, $query);
                $user = mysqli_fetch_assoc($login);

                $query = "SELECT d.id_departamento as departamento FROM departamento d
                    INNER JOIN user_departamento_tipo udt ON d.id_departamento = udt.id_departamento
                    INNER JOIN user u ON u.id_user = udt.id_user
                    INNER JOIN tipo_user tu ON udt.id_tipo = tu.id_tipo_user
                    WHERE u.id_user = {$_SESSION['user']['id_user']}";

                $getdeps = mysqli_query($con, $query);

                $deps = array();


                while ($row = mysqli_fetch_assoc($getdeps)) {
                    $deps[] = $row["departamento"];
                }

                unset($_SESSION['user']);
                $_SESSION['user'] = $user;
                $_SESSION['user']['departamento'] = $deps;
                
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

        $row['DepPerms'] = getDepUser($con, $id_user);

    } else {
        $row = null;
    }

    echo json_encode($row);

}


if (isset($_POST['nome'], $_POST['username'], $_POST['email']) && $_POST['typeForm'] == 'Editar') {




    $id_user = mysqli_real_escape_string($con, $_POST['id_user']);
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);


    $query = "DELETE FROM user_departamento_tipo WHERE id_user = $id_user";
    $queryDel_result = mysqli_query($con, $query);
    if (!$queryDel_result) {
        exit();
    }

    for ($i = 0; $i <= 5; $i++) {

        if (isset($_POST["departamento{$i}"], $_POST["permissoes{$i}"])) {
            $departamento = mysqli_real_escape_string($con, $_POST["departamento{$i}"]);
            $permissoes = mysqli_real_escape_string($con, $_POST["permissoes{$i}"]);

            $query = "INSERT INTO user_departamento_tipo(id_user,id_departamento,id_tipo) VALUES ('$id_user','$departamento','$permissoes')";

            $queryInsert_result = mysqli_query($con, $query);
            if (!$queryInsert_result) {
                exit();
            }
        }
    }

    if (!empty($_POST['telefone'])) {
        $telemovel = mysqli_real_escape_string($con, $_POST['telefone']);
        $update_parts[] = "telefone = $telemovel";
    }

    $update_query = "UPDATE user SET nome = '$nome', email = '$email', username = '$username'";
    if (!empty($update_parts)) {
        $update_query .= ", " . implode(", ", $update_parts);
    }
    $update_query .= " WHERE id_user = $id_user";


    $queryUpd_exec = mysqli_query($con, $update_query);

    if ($queryUpd_exec) {

        $query = "SELECT id_user,nome,email,username,telefone FROM user WHERE id_user = $id_user";

        $login = mysqli_query($con, $query);
        $user = mysqli_fetch_assoc($login);

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

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao atualizar os detalhes';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=5');
        exit();
    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao atualizar os detalhes';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=5');
        exit();
    }


}



if (isset($_POST['nome'], $_POST['username'], $_POST['email'], $_POST['password']) && $_POST['typeForm'] == 'Add') {

    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = sha1($_POST['password']);



    $check_query = "SELECT nome FROM user WHERE (email = '$email' OR username = '$username')";
    $check = mysqli_query($con, $check_query);

    if ($check && mysqli_num_rows($check) >= 1) {

        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> Já existe alguém com esse Username/Email';
        $_SESSION['alertClass'] = "warning";
        header('Location: .././?op=5');
        exit();
    }


    $telefone = 'null';
    if (!empty($_POST['telefone'])) {
        $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    }

    $insert_query = "INSERT INTO user(nome,username,password,email,telefone) VALUES ('$nome','$username', '$pass','$email', $telefone)";


    $queryinsert_exec = mysqli_query($con, $insert_query);

    if ($queryinsert_exec) {


        $id_user = mysqli_insert_id($con);

        $seenDepartamentos = array();
        for ($i = 0; $i <= 5; $i++) {

            if (isset($_POST["departamento{$i}"], $_POST["permissoes{$i}"])) {
                $departamento = mysqli_real_escape_string($con, $_POST["departamento{$i}"]);
                $permissoes = mysqli_real_escape_string($con, $_POST["permissoes{$i}"]);

                if (in_array($departamento, $seenDepartamentos)) {
                    continue;
                }


                $seenDepartamentos[] = $departamento;

                $query = "INSERT INTO user_departamento_tipo(id_user,id_departamento,id_tipo) VALUES ('$id_user','$departamento','$permissoes')";

                $queryInsert_result = mysqli_query($con, $query);
                if (!$queryInsert_result) {
                    exit();
                }
            }
        }

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao criar o utilizador';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=5');
        exit();
    } else {
        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao criar o utilizador';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=5');
        exit();
    }


}


if (isset($_POST['id_user']) && $_POST['type'] == 'delete') {

    $id_user = mysqli_real_escape_string($con, $_POST['id_user']);

    $query = "DELETE FROM user WHERE id_user = '$id_user'";

    $queryUser_exec = mysqli_query($con, $query);

    if ($queryUser_exec) {

        $query = "DELETE FROM user_departamento_tipo WHERE id_user = '$id_user'";
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


if (isset($_POST['id_user'], $_POST['password']) && $_POST['typeForm'] == 'password') {

    $id_user = mysqli_real_escape_string($con, $_POST['id_user']);
    $password = sha1($_POST['password']);

    $query = "UPDATE user SET password = '$password' WHERE id_user = '$id_user'";

    $queryUser_exec = mysqli_query($con, $query);

    if ($queryUser_exec) {

        $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Sucesso ao alterar a password';
        $_SESSION['alertClass'] = "success";
        header('Location: .././?op=5');
        exit();

    } else {

        $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro ao alterar a passwro';
        $_SESSION['alertClass'] = "danger";
        header('Location: .././?op=5');
        exit();
    }


}


function getDepUser($con, $id_user)
{

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
                'id_permissao' => $id_permissoes,
                'permissoes' => $permissoes
            ];
        }
        return $DepPerms;
    } else {
        return null;
    }

}

?>