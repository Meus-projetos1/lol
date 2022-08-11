<?php
include_once('../DAO/cadastroDeDadosPartidas.php');

$puuid = $_POST['puuid'];
$fila = $_POST['fila'];

$result = (new SalvaInfosPartida())->dataPartidasLoop($puuid, $fila);


echo json_encode(['fila' => $fila]);