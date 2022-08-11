<?php
include_once('../DAO/invocador.php');

$puuid = $_POST['puuid'];


$result = (new Invocador())->retornaData($puuid);


echo json_encode(['result' => $result]);