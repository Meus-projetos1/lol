<?php
require_once("../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Conect
{

    function ConectDb()
    {
       
        
        $SENHA_BANCO = $_ENV['SENHA_BANCO'];
        

        $config = array(
            // required credentials
            

            'host'       => $_ENV['HOST_BANCO'],
            'user'       => $_ENV['USUARIO_BANCO'],
            'password'   => "a58f09553777944aa07956ef67b2916f9794aa11c9a36583fbbb565df892e97e",
            'database'   => $_ENV['NOME_BANCO'],

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