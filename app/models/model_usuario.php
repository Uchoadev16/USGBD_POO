<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/projetos php/SGBD 2.0/app/config/connect.php');

class model_usuario extends connect
{
    private $tables;

    function __construct()
    {
        parent::__construct();
        $this->tables = '';
    }

    function list_database()
    {
        $list_database = $this->connect->prepare("SHOW DATABASES");
        $list_database->execute();

        $banco = $list_database->fetchAll(PDO::FETCH_ASSOC);
        return $banco;
    }
    function list_table($banco)
    {
        $use = $this->connect->prepare("USE $banco");
        $use->execute();
        $list_table = $this->connect->prepare("SHOW TABLES");
        $list_table->execute();

        $fetch_assoc = $list_table->fetchAll(PDO::FETCH_ASSOC);
        return $fetch_assoc;
    }
    function criar_banco($nome_banco)
    {
        $check_banco = $this->connect->prepare("SHOW DATABASES");
        $check_banco->execute();

        $databases = $check_banco->fetchAll(PDO::FETCH_ASSOC);
        foreach ($databases as $value) {

            if ($value['Database'] == $nome_banco) {

                return "ja_existe";
            }
        }
        $criar_banco = $this->connect->prepare("CREATE DATABASE " . $nome_banco);
        $criar_banco->execute();

        if ($criar_banco) {

            return 'certo';
        } else {

            return "erro";
        }
    }

    function deletar_banco($nome_banco)
    {
        $deletar_banco = $this->connect->prepare("DROP DATABASE " . $nome_banco);
        $deletar_banco->execute();

        if ($deletar_banco) {

            return 'certo';
        } else {

            return "erro";
        }
    }

    function criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna)
    {

        $entrar_banco = $this->connect->prepare("USE " . $nome_banco);
        $entrar_banco->execute();

        $check_tabela = $this->connect->prepare("SHOW TABLES");
        $check_tabela->execute();

        $tabelas = $check_tabela->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tabelas as $value) {

            //se matriz_tabela com o parametro passado for igual ao nome tabela
            if ($value['Tables_in_' . $nome_banco] == $nome_tabela) {

                //redirecionando para a tabela controller_criar_tabela.php
                header('location:../views/criar_deletar_tabela/criar_tabela.php?result=ja_existe');
            }
        }

        //se a variavel tipo_coluna for igual a DATE
        if ($tipo_coluna == "DATE") {

            $tamanho_coluna = "";
            $nao_nulo_coluna = "";
            $primario_coluna = "";
            $auto_incre_coluna = "";
            //criando a variavel para criar uma tabela
            $sql_criar_tabela = "CREATE TABLE $nome_tabela (

            $nome_coluna $tipo_coluna $primario_coluna $nao_nulo_coluna $auto_incre_coluna
            )";
            //executando o codigo
            $criar_tabela = $this->connect->prepare($sql_criar_tabela);
            $criar_tabela->execute();

            //se criar_tabela for verdadeiro
            if ($criar_tabela) {

                return 'certo';
            } else {

                return 'erro';
            }
        } else if ($nao_nulo_coluna == "") {
            $nao_nulo_coluna = "NOT NULL";
            //se nao, fazendo mesmo que o codigo anterior
            $sql_criar_tabela = "CREATE TABLE $nome_tabela (
    
        $nome_coluna $tipo_coluna($tamanho_coluna) $primario_coluna $nao_nulo_coluna $auto_incre_coluna
        );";

            $criar_tabela = $this->connect->prepare($sql_criar_tabela);
            $criar_tabela->execute();

            if ($criar_tabela) {

                return 'certo';
            } else {

                return 'erro';
            }
        } else { //se nao, fazendo mesmo que o codigo anterior
            $sql_criar_tabela = "CREATE TABLE $nome_tabela (
    
        $nome_coluna $tipo_coluna($tamanho_coluna) $primario_coluna $nao_nulo_coluna $auto_incre_coluna
        );";

            $criar_tabela = $this->connect->prepare($sql_criar_tabela);
            $criar_tabela->execute();

            if ($criar_tabela) {

                return 'certo';
            } else {

                return 'erro';
            }
        }
    }

    function deletar_tabela($nome_banco, $nome_tabela)
    {

        $use_banco = $this->connect->prepare("USE " . $nome_banco);
        $use_banco->execute();

        $delete_tabela = $this->connect->prepare("DROP TABLE " . $nome_tabela);
        $delete_tabela->execute();

        if ($delete_tabela) {

            return 'certo';
        } else {

            return 'erro';
        }
    }
    function desc_table($nome_banco, $nome_tabela)
    {
        $use_banco = $this->connect->prepare("USE " . $nome_banco);
        $use_banco->execute();

        $desc_table = $this->connect->prepare("DESC " . $nome_tabela);
        $desc_table->execute();

        $result = $desc_table->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    function select_table($nome_banco, $nome_tabela){

        $use_banco = $this->connect->prepare("USE " . $nome_banco);
        $use_banco->execute();

        $select_table = $this->connect->prepare("SELECT * FROM ".$nome_tabela);
        $select_table->execute();

        $result = $select_table->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
