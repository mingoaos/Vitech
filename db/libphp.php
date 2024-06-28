<?php

function getCount($con, $query)
{
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_row($result);
        return $row[0];
    } else {
        return null;
    }
}

function verificarData($datainicio, $datafim)
{
    // Converter os valores das datas para timestamps
    $datainicio_timestamp = strtotime($datainicio);
    $datafim_timestamp = strtotime($datafim);


    // validar se existem valores
    if ($datainicio_timestamp !== false && $datafim_timestamp !== false) {
        // Comparar os timestamps
        if ($datafim_timestamp >= $datainicio_timestamp) {
            return true;
        }
    }
    return false;
}


function addAcoes($id_ticket, $acao, $status_change, $con)
{
    $id_user = $_SESSION['user']['id_user'];
    $acao = mysqli_real_escape_string($con, $acao);


    $query = "INSERT INTO acoes (id_ticket, id_user, status_change, acao) 
              VALUES ('$id_ticket', '$id_user', '$status_change', '$acao')";

    $result = mysqli_query($con, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function getUser($con, $id_criador = 0)
{
   (!empty($id_criador) ? $whereclause = "WHERE id_user != {$id_criador}" : $whereclause = "");
    
    $query = "SELECT id_user, nome, email, telefone
    FROM user {$whereclause} ";

    $query_run = mysqli_query($con, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $user = [];
        while ($row = mysqli_fetch_assoc($query_run)) {
            $user[] = $row;
        }
        return $user;
    } else {
        return false;
    }


}

function getDep($con)
{
    $query = "SELECT id_departamento, nome
    FROM departamento ";


    $query_run = mysqli_query($con, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $dep = [];
        while ($row = mysqli_fetch_assoc($query_run)) {
            $dep[] = $row;
        }
        return $dep;
    } else {
        return false;
    }


}


function getTicket($con, $idticket)
{
    $query = "
    SELECT 
        t.id_ticket,
        u1.nome AS user_criado,
        u1.id_user as id_criador,
        DATE_FORMAT(t.data  , '%W, %e de %M %Y, %H:%i ','pt_PT') AS data,
        t.tipo_ticket,
        t.assunto_local,
        t.mensagem_sintomas,
        d.nome AS nome_departamento,
        t.urgencia,
        t.status,
        u2.nome AS user_atribuido,
        u2.id_user AS id_user_atribuido,
        t.data_atribuido
    FROM
        ticket t
        LEFT JOIN user u1 ON t.id_user = u1.id_user
        LEFT JOIN user u2 ON t.id_user_atribuido = u2.id_user
        LEFT JOIN departamento d ON t.id_departamento_destino = d.id_departamento
    WHERE
        t.id_ticket = '$idticket'
";

    $query_exec = mysqli_query($con, $query);

    if ($query_exec && mysqli_num_rows($query_exec) == 1) {
        $row = mysqli_fetch_assoc($query_exec);

        switch ($row['status']) {
            case 'P':
                $row['statusText'] = 'Pendente';
                $row['statusColor'] = 'red';
                break;
            case 'A':
                $row['statusText'] = 'Aberto';
                $row['statusColor'] = '#FFD700';
                break;
            case 'F':
                $row['statusText'] = 'Fechado';
                $row['statusColor'] = '#32CD32';
                break;
            default:
                $row['statusText'] = 'Desconhecido';
                $row['statusColor'] = 'black';
                break;
        }

        // Fetch latest action date
        $queryacoes = "
        SELECT DATE_FORMAT(data_acao, '%W, %e de %M %Y, %H:%i ','pt_PT') AS data_acao
        FROM acoes 
        WHERE id_ticket = '$idticket' 
        ORDER BY data_acao DESC 
        LIMIT 1
    ";

        $queryacoes_exec = mysqli_query($con, $queryacoes);

        if ($queryacoes_exec && mysqli_num_rows($queryacoes_exec) == 1) {
            $data_acao = mysqli_fetch_assoc($queryacoes_exec);
            $row["data_acao"] = $data_acao["data_acao"];
        }

        return $row;
    }

    return null;
}


function atualizarRecentes($con, $status_change = false)
{
    $status_clause = "";
    if ($status_change) {
        $status_clause = " AND a.acao = 'Alterou o estado no ticket'";
    }

    // Assuming $db is your database connection object
    $query = "
        SELECT a.*, 
                DATE_FORMAT(a.data_acao, '%e %b %Y, %H:%i', 'pt_PT') AS data_formated, 
                t.tipo_ticket as tipo_ticket, 
                t.assunto_local AS assunto_local, 
                u.nome AS nome_user
        FROM acoes AS a
        INNER JOIN ticket AS t ON a.id_ticket = t.id_ticket
        INNER JOIN user AS u ON a.id_user = u.id_user
        INNER JOIN user_departamento_tipo AS udt ON u.id_user = udt.id_user
        WHERE 
            (
                (t.id_user = {$_SESSION['user']['id_user']} OR t.id_user_atribuido = {$_SESSION['user']['id_user']}) OR 
                (udt.id_tipo = 'G' AND udt.id_departamento = t.id_departamento_destino) OR 
                udt.id_tipo = 'A'
            ) {$status_clause}
        GROUP BY a.id_acao  
        ORDER BY MAX(a.data_acao) DESC
        LIMIT 5;
    ";


    $query_exec = mysqli_query($con, $query);

    if ($query_exec && mysqli_num_rows($query_exec) > 0) {
        $acoes = []; // Initialize empty array to store results
        while ($row = mysqli_fetch_assoc($query_exec)) {

            switch ($row['status_change']) {
                case 'P':
                    $color = 'danger';
                    $status = 'Pendente';
                    break;
                case 'A':
                    $color = 'warning';
                    $status = 'Aberto';
                    break;
                case 'F':
                    $color = 'success';
                    $status = 'Fechado';
                    break;
                default:
                    $color = 'dark';
            }

            $tempo_decorrido = tempoDecorrido($row['data_acao']);

            $row['color'] = $color;
            $row['status'] = $status;
            $row['tempo_decorrido'] = $tempo_decorrido;

            $acoes[] = $row; // Add current row to $acoes array
        }

        return $acoes; // Return all rows fetched
    }

    return null; // Return null if no rows were fetched or query failed



}

function tempoDecorrido($data_acao)
{
    $timezone = new DateTimeZone('Europe/Lisbon');
    $data_acao_datetime = new DateTime($data_acao, $timezone);
    $data_atual_datetime = new DateTime('now', $timezone);


    $diferenca = $data_atual_datetime->diff($data_acao_datetime);


    $dias = $diferenca->days;
    $horas = $diferenca->h;
    $minutos = $diferenca->i;
    $segundos = $diferenca->s;

    $tempo_decorrido = '';
    if ($dias > 0) {
        $tempo_decorrido = "$dias dias";
    } elseif ($horas > 0) {
        $tempo_decorrido = "$horas hrs";
    } elseif ($minutos > 0) {
        $tempo_decorrido = "$minutos mins";
    } else {
        $tempo_decorrido = "$segundos segs";
    }

    return $tempo_decorrido;
}




function getRespostas($con, $id_ticket)
{

    $id_ticket = mysqli_real_escape_string($con, $id_ticket);

    $query = "
        SELECT r.*,DATE_FORMAT(r.data, '%W, %e %M,  %H:%i','pt_PT') as data, u.nome, u.id_user
        FROM resposta AS r 
        INNER JOIN resposta_ticket AS rt ON rt.id_resposta = r.id_resposta 
        INNER JOIN user AS u ON u.id_user = r.id_user 
        WHERE rt.id_ticket = $id_ticket
        ORDER BY r.data DESC
    ";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $responses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $responses[] = $row;
        }
        return $responses;
    } else {
        return "Error: " . mysqli_error($con);
    }
}

function getDeps($con)
{
    $querydeps = "SELECT id_departamento,nome FROM departamento";

    $querydeps_exec = mysqli_query($con, $querydeps);


    if ($querydeps_exec && mysqli_num_rows($querydeps_exec) > 0) {
        while ($row = mysqli_fetch_assoc($querydeps_exec)) {
            $result[] = $row;

        }
    } else {
        return null;
    }
    return $result;

}
function getPerms($con)
{

    $queryperms = "SELECT id_tipo_user, nome FROM tipo_user";
    $queryperms_exec = mysqli_query($con, $queryperms);
    if ($queryperms_exec && mysqli_num_rows($queryperms_exec) > 0) {
        while ($row = mysqli_fetch_assoc($queryperms_exec)) {
            $result[] = $row;
        }
    } else {
        return null;
    }

    return $result;

}


?>