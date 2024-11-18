<?php
//requerindo o arquivo para estanciar a class controller e chmar a função
require_once('../../controllers/controller_usuario.php');
$usuario = new controller_usuario;
$matriz_banco = $usuario->list_database();
?>

<!DOCTYPE html>
<html lang="en">

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
    <script>
        //função para pergunta ao usuario ele realmente deseja apagar esta tabela
        function confirmar_delete(event) {

            if (!confirm("Você deseja realmente apagar esta tabela?")) {
                event.preventDefault();
                alert("Banco não apagado!");
            }
        }
    </script>


</head>

<body>
    <nav>
        <ul>

            <h1><a href="../../index.php">USGBD</a></h1>
            <p>Databases</p>
            <li><a href="../criar_deletar_banco/criar_banco.php">Novo</a></li>

            <!--transformando a matriz em um array-->
            <?php foreach ($matriz_banco as $banco) { ?>
                <li>
                    <details>
                        <summary><?= $banco['Database'] ?></summary>
                        <ul>
                            <li><a href="criar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Nova</a></li>

                            <?php
                            //chamando a função para lista as tabelas em cada banco
                            $matriz_tabela = $usuario->list_table($banco['Database']);
                            //transformando a matriz em array
                            foreach ($matriz_tabela as $tabela) {
                            ?>
                                <li>
                                    <!--passando por via GET o nome do banco de o nome da tabela-->
                                    <a href="../info_banco_tabela/info_tabela.php?nome_banco=<?= $banco['Database'] ?>&nome_tabela=<?= $tabela['Tables_in_' . $banco['Database']] ?>"><?= $tabela['Tables_in_' . $banco['Database']] ?></a>
                                </li>
                            <?php } ?>
                            <a href="deletar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Deletar tabela</a>
                        </ul>
                    </details>
                </li>
            <?php } ?>
        </ul>

        <p><a href="../criar_deletar_banco/deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>
        <h1>Deletar tabela</h1>

        <?php
        //se existir o get"nome_banco"
        if (isset($_GET['nome_banco'])) {

            //criando a variavel nome_banco com o get passado
            $banco = $_GET['nome_banco'];

            $matriz_tabela = $usuario->list_table($banco);

            //transformando a matriz em um array
            foreach ($matriz_tabela as $tabela) { ?>

                <form action="../../controllers/controller.php" method="post">
                    <ul>
                        <li>
                            <?= $tabela['Tables_in_' . $banco] ?>
                            <input type="hidden" name="nome_banco" value="<?= $banco ?>">
                            <input type="hidden" name="nome_tabela" value="<?= $tabela['Tables_in_' . $banco] ?>">
                            <button type="submit" name="deletar_banco" onclick="confirmar_delete(event)">Deletar banco</button>
                        </li>
                    </ul>
                </form>

            <?php } ?>
        <?php } ?>

        <?php

        if (isset($_GET['result'])) {

            switch ($result = $_GET['result']) {

                case 'certo':
                    echo "Tabela deletada com sucesso!";
                    break;

                case 'erro':
                    echo "Erro ao deletar a tabela!";
                    break;
            }
        }
        ?>
    </section>

</body>

</html>