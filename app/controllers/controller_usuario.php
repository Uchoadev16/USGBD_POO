<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/projetos php/SGBD 2.0/app/models/model_usuario.php');

class controller_usuario
{

    private $model;

    function __construct()
    {
        $this->model = new model_usuario;
    }

    function list_database()
    {
        $banco = $this->model->list_database();
        return $banco;
    }
    function list_table($banco)
    {
        $list_table = $this->model->list_table($banco);
        return $list_table;
    }
    function criar_banco($nome_banco)
    {
        $result = $this->model->criar_banco($nome_banco);
        return $result;
    }
    function deletar_banco($nome_banco)
    {
        $result = $this->model->deletar_banco($nome_banco);
        return $result;
    }
    function criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna){

        $result = $this->model->criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna);

        return $result;
    }
    function deletar_tabela($nome_banco, $nome_tabela){

        $result = $this->model->deletar_tabela($nome_banco, $nome_tabela);

        return $result;
    }
    function desc_table($nome_banco, $nome_tabela){

        $result = $this->model->desc_table($nome_banco, $nome_tabela);

        return $result;
    }
    function select_table($nome_banco, $nome_tabela){

        $result = $this->model->select_table($nome_banco, $nome_tabela);

        return $result;
    }
}