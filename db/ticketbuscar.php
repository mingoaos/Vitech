<?php 



function getTicket($con,$idticket)
{
    $query = "SELECT * FROM ticket where id_ticket = '$idticket'";

    $query_exec = mysqli_query($con,$query);

    if($query_exec && mysqli_num_rows($query_exec) == 1)
    {

       return $row = mysqli_fetch_assoc($query_exec);
    }

    return null;
}

?>