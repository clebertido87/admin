<?php
include('../../../config/conexao.php');
include_once('../../../config/tabs.php');

$collector_id = $_REQUEST['id'];

// $collector_id = '67222731509'; // Substitua '67222731509' pelo valor desejado

// Adicione esta linha para ver o valor de $collector_id
echo 'Valor de $collector_id: ' . $collector_id;

// Adicione esta linha para ver o valor de $access_token
echo 'Valor de $access_token: ' . $access_token;

$curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$collector_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'content-type: application/json',
        'Authorization: Bearer '.$access_token
    ),
    ));
    $response = curl_exec($curl);
    $resultado = json_decode($response);
    
curl_close($curl);


if($resultado->status == 'approved'){
    $update = "UPDATE vendas SET
        status		= '2'
    WHERE codigo_venda_mp='$collector_id'";
    mysqli_query($conexao, $update);
}




?>