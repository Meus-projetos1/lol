<?php
require_once("../vendor/autoload.php");


class Conect
{

    function ConectDb()
    {
        $config = array(
            // required credentials

            'host'       => "ec2-44-206-214-233.compute-1.amazonaws.com",
            'user'       => "rthoxqbrhqdrke",
            'password'   => 'a58f09553777944aa07956ef67b2916f9794aa11c9a36583fbbb565df892e97e',
            'database'   => "d1plmtrr7u4fv9",

            // optional

            'fetchMode'  => \PDO::FETCH_ASSOC,
            'charset'    => 'utf8',
            'port'       => 5432,
            'unixSocket' => null,
        );

        // standard setupPostgres
        $dbConn = new \Simplon\Postgres\Postgres(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']

        );

        return $dbConn;
    }

   
}