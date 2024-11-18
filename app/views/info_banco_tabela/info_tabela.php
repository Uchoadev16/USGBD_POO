<?php
//requerindo o arquivo para estanciar a class controller e chmar a função
require_once('../../controllers/controller_usuario.php');
$usuario = new controller_usuario;
$matriz_banco = $usuario->list_database();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USGBD</title>
    <style>
        table {
            border: 1px solid black;
        }

        tr {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
            padding: 3px 3px 3px 3px;
        }

        nav {
            padding: 0px;
            border: 2px solid black;
            height: 675px;
            width: 200px;
        }

        section {
            border: 2px solid black;
            margin-left: 202px;
            margin-top: -678px;
            height: 675px;
            width: 1300px;
        }
    </style>

</head>

<body>
    <nav>
        <ul>

            <h1><a href="index.php">USGBD</a></h1>
            <p>Databases</p>
            <li><a href="../criar_deletar_banco/criar_banco.php">Novo</a></li>

            <!--transformando a matriz em um array-->
            <?php foreach ($matriz_banco as $banco) { ?>
                <li>
                    <details>
                        <summary><?= $banco['Database'] ?></summary>
                        <ul>
                            <li><a href="../criar_deletar_tabela/criar_tabela.php">Nova</a></li>

                            <?php
                            //chamando a função para lista as tabelas em cada banco
                            $matriz_tabela = $usuario->list_table($banco['Database']);
                            //transformando a matriz em array
                            foreach ($matriz_tabela as $tabela) {
                            ?>
                                <li>
                                    <!--passando por via GET o nome do banco de o nome da tabela-->
                                    <a href="info_tabela.php?nome_banco=<?= $banco['Database'] ?>&nome_tabela=<?= $tabela['Tables_in_' . $banco['Database']] ?>"><?= $tabela['Tables_in_' . $banco['Database']] ?></a>
                                </li>
                            <?php } ?>
                            <a href="../criar_deletar_tabela/deletar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Deletar tabela</a>
                        </ul>
                    </details>
                </li>
            <?php } ?>
        </ul>

        <p><a href="../criar_deletar_banco/deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>

        <?php

        //se existir um get"nome_banco" e existir um get"nome_tabela" e não estiver vazio o nome_banco e nao estiver vazio o nome_tabela
        if (isset($_GET['nome_banco']) && isset($_GET['nome_tabela']) && !empty($_GET['nome_banco']) && !empty($_GET['nome_tabela'])) {

            //criando as variaveis via get
            $nome_banco = $_GET['nome_banco'];
            $nome_tabela = $_GET['nome_tabela'];
        ?>
            <p>Descrição da tabela:</p><br>
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Tipo</td>
                    <td>Não nulo</td>
                    <td>Chave</td>
                    <td>Default</td>
                    <td>Extra</td>
                </tr>


                <?php
                //chamando a função para descrever a tabela
                $desc_table = $usuario->desc_table($nome_banco, $nome_tabela);
                //transformando a matriz em array
                foreach ($desc_table as $value) {
                ?>
                    <tr>
                        <td><?= $value['Field'] ?></td>
                        <td><?= $value['Type'] ?></td>
                        <td><?= $value['Null'] ?></td>
                        <td><?= $value['Key'] ?></td>
                        <td><?= $value['Default'] ?></td>
                        <td><?= $value['Extra'] ?></td>
                    </tr>
                <?php } ?>

            </table><br>

            <p>Dados da tabela:</p>

            <table>
                <tr>
                    <?php
                    //chamando a função para descrever a tabela
                    $desc_table = $usuario->desc_table($nome_banco, $nome_tabela);
                    //transformando a matriz em array
                    foreach ($desc_table as $value) { ?>

                        <td><?= $value['Field'] ?></td>
                    <?php } ?>
                </tr>


                <?php
                //chamando a função para mostrar os dados que tem na tabela
                $select_table = $usuario->select_table($nome_banco, $nome_tabela);
                //transformando a matriz em array
                foreach ($select_table as $dados) {
                ?>
                    <tr>
                        <?php
                        //chamando a função para descrever a tabela
                        $desc_table = $usuario->desc_table($nome_banco, $nome_tabela);
                        //transformando a matriz em array
                        foreach ($desc_table as $value) {
                        ?>
                            <td><?= $dados[$value['Field']] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>

            </table>
        <?php } ?>
    </section>

</body>

</html>