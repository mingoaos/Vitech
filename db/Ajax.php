<?php 
require "./dbcon.php";
require "./libphp.php";

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        $query .= " AND (id_user_atribuido = {$_SESSION['user']['id_user']} OR id_user = {$_SESSION['user']['id_user']})";
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
        $nomeMes = ucfirst(date('F', mktime(0, 0, 0, $mes, 1)));
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
        $erro = array('erro' => 'Falha ao buscar na base de dados');
        echo json_encode($erro);
    }
}



if ($_POST['type'] == 'ticketTablesAjax') {

    $tipoTicket = mysqli_real_escape_string($con, $_POST['tipoTicket']);
    $filtros = json_decode($_POST['filtro'], true);

    $whereClause = " WHERE 1 ";


    switch ($tipoTicket) {
        case 'Enviados':
            $whereClause .= " AND t.id_user = {$_SESSION['user']['id_user']}";
            break;
        case 'Recebidos':
            $whereClause .= " AND t.id_user_atribuido = {$_SESSION['user']['id_user']}";
            break;
        case 'Não atribuidos':
            $whereClause .= " AND t.id_user_atribuido IS NULL";
            break;
        default:
            break;
    }
    if($tipoTicket != "Não atribuidos"){
        $statusCondicao = []; 
        if (isset($filtros["1"]) && $filtros["1"]) {
            $statusCondicao[] = "t.status = 'P'";
        }
    
        if (isset($filtros["2"]) && $filtros["2"]) {
            $statusCondicao[] = "t.status = 'A'";
        }
    
        if (isset($filtros["3"]) && $filtros["3"]) {
            $statusCondicao[] = "t.status = 'F'";
        }
    
        
        if (!empty($statusCondicao)) {
            $whereClause .= " AND (" . implode(" OR ", $statusCondicao) . ") ";
        } else{
            echo json_encode("Sem dados");
        }
    }
  

    $query = "SELECT t.*, DATE_FORMAT(t.data, '%e %b %Y, %H:%i', 'pt_PT') as data,
                u_reportador.nome AS nome_reportador,
                u_atribuido.nome AS nome_user_atribuido
            FROM ticket t
            JOIN user u_reportador ON t.id_user = u_reportador.id_user
            LEFT JOIN user u_atribuido ON t.id_user_atribuido = u_atribuido.id_user
            {$whereClause}";


    $query_exec = mysqli_query($con, $query);

    if ($query_exec) {
        $result = array();
        while ($row = mysqli_fetch_assoc($query_exec)) {
            // Add color to the result if needed
            switch ($row['status']) {
                case 'P':
                    $row['color'] = 'danger';
                    break;
                case 'A':
                    $row['color'] = 'warning';
                    break;
                case 'F':
                    $row['color'] = 'success';
                    break;
                default:
                    $row['color'] = 'dark';
                    break;
            }
            $result[] = $row;
        }
        echo json_encode($result);
    } else {
        // Handle SQL error
        echo json_encode(['error' => mysqli_error($con)]);
    }
}













?>