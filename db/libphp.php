<?php 



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


function atualizarRecentes($con)
{

    $query = "SELECT a.*, t.status AS ticket_status, t.assunto_local AS assunto_local, u.nome AS nome_user
            FROM acoes AS a
            INNER JOIN ticket AS t ON a.id_ticket = t.id_ticket
            INNER JOIN user AS u ON a.id_user = u.id_user
            WHERE t.tipo_ticket = 'A' AND (a.id_user = {$_SESSION['user']['id_user']} OR t.id_user_atribuido = {$_SESSION['user']['id_user']})
            ORDER BY a.data_acao ASC
            LIMIT 5";
            
    $query_exec = mysqli_query($con,$query);

    if($query_exec && mysqli_num_rows($query_exec) > 0)
    {
        while ($row = mysqli_fetch_assoc($query_exec)){

            switch ($row['ticket_status']) {
                case 'P':
                    $badge_status = 'danger';
                    $status = 'Pendente';
                    break;
                case 'A':
                    $badge_status = 'warning';
                    $status = 'Aberto';
                    break;
                case 'F':
                    $badge_status = 'success';
                    $status = 'Fechado';
                    break;
                default:
                    $badge_status = 'dark';
            }

            $tempo_decorrido = tempoDecorrido($row['data_acao']);

            $row['badge_status'] = $badge_status;
            $row['status'] = $status;
            $row['tempo_decorrido'] = $tempo_decorrido;

            $acoes[] = $row;
        }
    }

    return $acoes;

}

function tempoDecorrido($data_acao)
{
    $data_acao_timestamp = strtotime($data_acao);
    $data_atual_timestamp = time();
    $diferenca_tempo = $data_atual_timestamp - $data_acao_timestamp;
    
    $dias = floor($diferenca_tempo / (60 * 60 * 24));
    $horas = floor(($diferenca_tempo % (60 * 60 * 24)) / (60 * 60));
    $minutos = floor(($diferenca_tempo % (60 * 60)) / 60);
    $segundos = $diferenca_tempo % 60;

    
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

?>