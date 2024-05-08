<?php
require "./dbcon.php";
session_start();




$meses = array();

for ($mes = 1; $mes <= 12; $mes++) {
    $nomeMes = ucfirst(strftime('%B', mktime(0, 0, 0, $mes, 1)));
    $meses[$mes] = $nomeMes;
}

$date=date_create(date("Y-m-d"));
date_sub($date,date_interval_create_from_date_string("11 month"));
$data_inic = date_format($date,"Y-m-01");


$query = "SELECT MONTH(data) AS mes, COUNT(*) AS total FROM ticket
        WHERE data >= '$data_inic'
        GROUP BY MONTH(data)
        ORDER BY data DESC
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






?>