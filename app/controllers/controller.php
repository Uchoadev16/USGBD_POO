<?php

if (isset($_POST['nome_banco']) && isset($_POST['criar_banco'])) {

    $nome_banco = $_POST['nome_banco'];
    require_once('controller_usuario.php');
    //estanciando o objeto e chamando a função 
    $controller_usuario = new controller_usuario;
    $result = $controller_usuario->criar_banco($nome_banco);

    //redirecionando
    header('location:../views/criar_deletar_banco/criar_banco.php?result=' . $result);
} else if (isset($_POST['nome_banco']) && isset($_POST['deleta_banco'])) {

    $nome_banco = $_POST['nome_banco'];
    require_once('controller_usuario.php');
    //estanciando o objeto e chamando a função 
    $controller_usuario = new controller_usuario;
    $result = $controller_usuario->deletar_banco($nome_banco);

    //redirecionando
    header('location:../views/criar_deletar_banco/deletar_banco.php?result=' . $result);
} else if (isset($_POST['criar_tabela']) && !empty($_POST['nome_banco']) && !empty($_POST['nome_tabela']) && !empty($_POST['nome_coluna']) && !empty($_POST['tipo_coluna'])) {

    //criando as variaveis com o post passado
    $nome_banco = $_POST['nome_banco'];
    $nome_tabela = $_POST['nome_tabela'];
    $nome_coluna = $_POST['nome_coluna'];
    $tipo_coluna = $_POST['tipo_coluna'];
    $tamanho_coluna = $_POST['tamanho_coluna'];
    $nao_nulo_coluna = $_POST['nao_nulo_coluna'] ?? "";
    $auto_incre_coluna = $_POST['auto_incre_coluna'] ?? "";
    $primario_coluna = $_POST['primario_coluna'] ?? "";

    require_once('controller_usuario.php');
    $controller_usuario = new controller_usuario;
    //estanciando o objeto e chamando a função 
    $result = $controller_usuario->criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna);

    //redirecionando
    header('location:../views/criar_deletar_tabela/criar_tabela.php?result=' . $result);

} else if (isset($_POST['deletar_banco']) && !empty($_POST['nome_banco']) && !empty($_POST['nome_tabela'])) {

    $nome_banco = $_POST['nome_banco'];
    $nome_tabela = $_POST['nome_tabela'];

    require('controller_usuario.php');
    //estanciando o objeto e chamando a função 
    $controller_usuario = new controller_usuario;
    $result = $controller_usuario->deletar_tabela($nome_banco, $nome_tabela);

    //redirecionando
    header('location:../views/criar_deletar_tabela/deletar_tabela.php?result=' . $result);
} else {

    //redirecionando
    header('location:../../default.php');
}
