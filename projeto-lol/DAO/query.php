<?php
include_once("baseDAO.php");

class Query
{


    function select($query, $array)
    {
    
        $conexao = (new Conect())->ConectDb();
       
        $result = $conexao->fetchRowMany($query,$array);

        return $result;

    }
}
