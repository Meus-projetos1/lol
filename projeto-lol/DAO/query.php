<?php
include_once("baseDAO.php");

class Query
{


    function select($query, $array)
    {

        $conexao = (new Conect())->ConectDb();

        $result = $conexao->fetchRowMany($query, $array);

        return $result;
    }


    function insertInto($data, $sql)
    {
        $conexao = (new Conect())->ConectDb();

        $id = $conexao->insert($sql, $data);

        return $id;
    }
}
