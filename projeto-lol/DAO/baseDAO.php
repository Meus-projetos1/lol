<?php
require_once("../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Conect
{

    function ConectDb()
    {
       
        
        
        

        $config = array(
            // required credentials
            

            'host'       => $_ENV['HOST_BANCO'],
            'user'       => $_ENV['USUARIO_BANCO'],
            'password'   => $_ENV['SENHA_BANCO'],
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