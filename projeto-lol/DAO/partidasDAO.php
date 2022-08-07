<?php
include_once('../DAO/query.php');
error_reporting(E_ERROR | E_PARSE);

class Partidas
{

    function salvaPartidaInfo($data)
    {
        $query = new Query();

        $sql = '"LOL"."dadospartidas"';

        return $query->insertInto($data, $sql);
    }

    function consultaPartidaInfo($idjogo){
        $query = new Query();
       
        $sql = 'SELECT * FROM "LOL"."dadospartidas" WHERE idjogo = :idjogo';
        $data = array('idjogo' => "$idjogo");
        
        return $query->select($sql, $data);

    }
    function consultaDataPartida($idjogo){
        $query = new Query();
       
        $sql = 'SELECT * FROM "LOL"."dadospartidas" WHERE idjogo = :idjogo';
        $data = array('idjogo' => "$idjogo");
        
        return $query->select($sql, $data);

    }
}
