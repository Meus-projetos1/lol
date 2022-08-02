<?php
include_once('../DAO/invocador.php');



try {
    $nome = $_POST['nome'];
    $puuid = $_POST['puuid'];


    $resultInvocador = (new Invocador())->consultaInvocador($puuid);

    if ($resultInvocador) {

        echo json_encode(['result' => $resultInvocador]);
    } else {

        $resultSalva = (new Invocador())->Salvar($nome, $puuid);
        echo json_encode(["result" => $resultSalva]);
    }
} catch (Exception $e) {
    echo json_encode($e);
}
