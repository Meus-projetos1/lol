<?php
include_once('../DAO/consultaApiRiot.php');
include_once('../DAO/consultaToken.php');

$nome =  $_POST['nome'];
$token = (new ConsultaToken())->consulta();


if (!empty($token[0]['token'])) {

    $invocador = (new ConsultaApiRiot())->ConsultaApiInvocador($nome, $token[0]['token']);

    $idInvocador =  json_decode($invocador)->{'id'};

    $maestria = (new ConsultaApiRiot())->ConsultaApiMaestriaPorInvocador($idInvocador, $token[0]['token']);

    $ranqueada = (new ConsultaApiRiot())->ConsultaApiRaqueada($idInvocador, $token[0]['token']);

    $campeoes = (new ConsultaApiRiot())->ConsultaApiCampeoes($idInvocador, $token[0]['token']);


    $obj = new stdClass();
    $obj->maestria = json_decode($maestria);
    $obj->invocador = json_decode($invocador);
    $obj->campeoes = json_decode($campeoes);
    $obj->ranqueada = json_decode($ranqueada);

    echo json_encode($obj);
}
