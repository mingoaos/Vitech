<?php




function getNoticia($con)
{

    $data_atual = date('Y-m-d h:i:s');

    $query = "SELECT id_noticia,
                DATE_FORMAT(Data_inicio, '%W, %e %M  %H:%i') AS formatted_Data_inicio,
                DATE_FORMAT(Data_fim, '%W, %e %M  %H:%i') AS formatted_Data_fim, Assunto, Noticia FROM `noticia` WHERE Data_inicio < NOW() AND Data_fim > NOW()";

    $query_exec = mysqli_query($con,$query);

    if ($query_exec && mysqli_num_rows($query_exec) > 0) {
        $result = array();
        while ($row = mysqli_fetch_assoc($query_exec)) {
            $result[] = $row;
        }

        return $result;
    } else {
        return null;
    }

}


if(isset($_POST['noticiaId']) && $_POST['type'] == 'deleteNoticia'){

    $noticiaId = mysqli_real_escape_string($con,$_POST['noticiaId']);

    $query = "DELETE FROM noticia WHERE id_noticia = $noticiaId";

    $query_exec = mysqli_query($con,$query);

    if($query_exec){

        $_SESSION['alert'] = 'Notícia apagada com sucesso';
        $_SESSION['alertClass'] = "success";

        exit();
    }else{

        $_SESSION['alert'] = 'Erro ao apagar a Notícia';
        $_SESSION['alertClass'] = "danger";
    }


}


?>