<?php

//criando constantes para com as informas do banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');

//criando class para fazer a conexão
class connect{

    //criando atributo para a conexão
    protected $connect;

    //criando o construtor para assim que a class sejá estanciada, chame a função de conexão
    function __construct()
    {
        $this->connect_database();
    }

    //criando a função para a conexão
    function connect_database(){

        //testando a conexão
        try{

            $this->connect = new PDO('mysql:host='.HOST.';dbname='. '', USER, PASSWORD);

        }catch(PDOException $e){

            //em caso de erro
            echo "Erro ao se cadastrar com o banco de dados ".$e->getMessage();
            die();
        }
    }
}
?>