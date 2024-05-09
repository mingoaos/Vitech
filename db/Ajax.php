<?php 
require "./dbcon.php";
require "./libphp.php";

session_start();



if (isset($_POST['filtro']) && isset($_POST['cardId']) && $_POST['type'] == 'cardsAjax') {
    $filter = $_POST['filtro'];
    $cardId = $_POST['cardId'];

    
   
    switch ($cardId) {
        case 1:
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'A'";
            break;
        case 2:
            $query = "SELECT COUNT(*) FROM ticket WHERE status = 'P'";
            break;
        default:
            echo "Invalid card type";
            exit;
    }

  
    if ($filter == "Meus") {
       
        $query .= " AND id_user_atribuido = {$_SESSION['user']['id_user']}";
    }

    
    $count = getCount($con, $query);

    
    if ($count !== false) {
        echo $count;
    } else {
        echo "Error retrieving count";
    }
}




if ($_POST['type'] == 'barAjax') {

    $resultadosReais = array(); 

    $meses = array();

    for ($mes = 1; $mes <= 12; $mes++) {
        $nomeMes = ucfirst(strftime('%B', mktime(0, 0, 0, $mes, 1)));
        $meses[$mes] = $nomeMes;
    }

    $date=date_create(date("Y-m-d"));
    date_sub($date,date_interval_create_from_date_string("5 month"));
    $data_inic = date_format($date,"Y-m-01");


    $query = "SELECT MONTH(data) AS mes, COUNT(*) AS total FROM ticket
            WHERE data >= '$data_inic'
            GROUP BY MONTH(data)
            ORDER BY data ASC
            LIMIT 6
            ";

    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        $dados = array();

        while ($linha = mysqli_fetch_assoc($resultado)) {
            $dados[] = array(
                "mes" => $meses[$linha['mes']],
                "total" => $linha['total']
            );
        }
   

        mysqli_free_result($resultado);

        echo json_encode($dados);
        
    } else {
        $erro = array('erro' => 'Falha ao buscar dados do banco de dados');
        echo json_encode($erro);
    }
}

if(isset($_POST['noticiaID']) && $_POST['type'] == 'deleteNoticia'){

    $noticiaID = mysqli_real_escape_string($con,$_POST['noticiaID']);

    $query = "DELETE FROM `noticia` WHERE id_noticia = '$noticiaID'";

    $query_exe = mysqli_query($con,$query);

    if($query_exe){
        
    }

}

?>