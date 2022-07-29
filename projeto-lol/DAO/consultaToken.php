<?php
include_once('../DAO/query.php');


class ConsultaToken
{
    function consulta()
    {
        $query = new Query();
        $sql = 'select * from "LOL".api_key ak';
        $array = array();
        return $query->select($sql, $array);
    }
}
