<?php
include_once('../DAO/consultaApiRiot.php');
include_once('../DAO/consultaToken.php');
error_reporting(E_ERROR | E_PARSE);
$token = (new ConsultaToken())->consulta();
$nome = str_replace(" ","%20",$_POST['nome']);

if (!empty($token[0]['token'])) {

    $invocador = (new ConsultaApiRiot())->ConsultaApiInvocador($nome, $token[0]['token']);

    $idInvocador =  json_decode($invocador)->{'id'};
    $statusMsg = json_decode($invocador)->status->message;
    

    $maestria = (new ConsultaApiRiot())->ConsultaApiMaestriaPorInvocador($idInvocador, $token[0]['token']);

    $ranqueada = (new ConsultaApiRiot())->ConsultaApiRaqueada($idInvocador, $token[0]['token']);

    $campeoes = (new ConsultaApiRiot())->ConsultaApiCampeoes($idInvocador, $token[0]['token']);


    $obj = new stdClass();
    $obj->maestria = json_decode($maestria);
    $obj->invocador = json_decode($invocador);
    $obj->campeoes = json_decode($campeoes);
    $obj->ranqueada = json_decode($ranqueada);
    $obj->statusMsg = $statusMsg;

    echo json_encode($obj);
}
