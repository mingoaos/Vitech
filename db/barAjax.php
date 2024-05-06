<?php
require " dbcon.php";
session_start();



$meses = array();

for ($mes = 1; $mes <= 12; $mes++) {
    $nomeMes = strftime('%B', mktime(0, 0, 0, $mes, 1));
    $meses[$mes] = $nomeMes;
}


$query = "SELECT MONTH(data) AS mes, COUNT(*) AS total FROM ticket GROUP BY MONTH(data)";
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

    header('Content-Type: application/json');

    $x = json_encode($dados);

    
} else {
    $erro = array('erro' => 'Falha ao buscar dados do banco de dados');
    echo json_encode($erro);
}




?>