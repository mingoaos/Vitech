<?php




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require "./dbcon.php";
    require "./libphp.php";
    
    if (isset($_POST['noticiaId']) && $_POST['type'] == 'deleteNoticia') {
        $noticiaId = mysqli_real_escape_string($con, $_POST['noticiaId']);
        $query = "DELETE FROM noticia WHERE id_noticia = $noticiaId";
        $query_exec = mysqli_query($con, $query);

        if ($query_exec) {
           
            echo json_encode(array("status" => "success"));
        } else {
           
            echo json_encode(array("status" => "error"));
        }
    }

    if (isset($_POST['dataIni']) && isset($_POST['dataFim']) && isset($_POST['assunto']) && isset($_POST['noticia'])) {
        $dataini = mysqli_real_escape_string($con, $_POST['dataIni']);
        $datafim = mysqli_real_escape_string($con, $_POST['dataFim']);
        $assunto = mysqli_real_escape_string($con, $_POST['assunto']);
        $noticia = mysqli_real_escape_string($con, $_POST['noticia']);

        if (verificarData($dataini, $datafim)) {
            if (!empty($dataini) && !empty($datafim) && !empty($assunto) && !empty($noticia)) {
                $query = "INSERT INTO `noticia`(`Data_inicio`, `Data_fim`, `Assunto`, `Noticia`, `Status`) VALUES ('$dataini','$datafim','$assunto','$noticia','A');";
                $query_exec = mysqli_query($con, $query);

                if ($query_exec) {
                    $_SESSION['alert'] = '<i class="bi bi-check-circle-fill"></i> Notícia criada com sucesso';
                    $_SESSION['alertClass'] = "success";
                } else {
                    $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i>Erro: ' . mysqli_error($con);
                    $_SESSION['alertClass'] = "danger";
                }

                header("Location: " . $_SESSION['current_page']);
                exit();
            } else {
                $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> Insira todos os detalhes';
                $_SESSION['alertClass'] = "warning";
                header("Location: " . $_SESSION['current_page']);
                exit();
            }
        } else {
            $_SESSION['alert'] = '<i class="bi bi-exclamation-triangle-fill"></i> A data de fim tem que ser depois da data de início';
            $_SESSION['alertClass'] = "warning";
            header("Location: " . $_SESSION['current_page']);
            exit();
        }
    }
}





function getNoticia($con)
{

    $data_atual = date('Y-m-d h:i:s');

    $query = "SELECT id_noticia,
                DATE_FORMAT(Data_inicio, '%W, %e %M %H:%i','pt_PT') AS formatted_Data_inicio,
                DATE_FORMAT(Data_fim, '%W, %e %M  %H:%i','pt_PT') AS formatted_Data_fim, Assunto, Noticia FROM `noticia` WHERE Data_inicio < NOW() AND Data_fim > NOW()";

    $query_exec = mysqli_query($con, $query);

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




?>