<?php
include_once('../DAO/query.php');
error_reporting(E_ERROR | E_PARSE);

class Invocador
{
    function Salvar($nome, $puuid)
    {
        $query = new Query();

        $sql = '"LOL"."invocadores"';

        $data = array(
            'nome' => $nome,
            'puuid' => $puuid,

        );

        return $query->insertInto($data, $sql);
    }

    function consultaInvocador($puuid){
        $query = new Query();
       
        $sql = 'SELECT * FROM "LOL"."invocadores" WHERE puuid = :puuid';
        $data = array('puuid' => "$puuid");
        
        return $query->select($sql, $data);

    }
}
