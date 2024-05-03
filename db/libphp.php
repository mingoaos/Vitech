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
            WHERE t.tipo_ticket = 'A'
            ORDER BY a.data_acao ASC
            LIMIT 5";

    $query_exec = mysqli_query($con,$query);

    if($query_exec && mysqli_num_rows($query_exec) > 0)
    {
        while ($row = mysqli_fetch_assoc($query_exec)){

            switch ($row['ticket_status']) {
                case 'P':
                    $badge_status = 'badge bg-danger';
                    $status = 'Pendente';
                    break;
                case 'A':
                    $badge_status = 'badge bg-warning';
                    $status = 'Aberto';
                    break;
                case 'F':
                    $badge_status = 'badge bg-success';
                    $status = 'Fechado';
                    break;
                default:
                    $badge_status = 'badge bg-dark';
            }
            
            $row['badge_status'] = $badge_status;
            $row['status'] = $status;
            $acoes[] = $row;
        }
    }

    return $acoes;

}

?>