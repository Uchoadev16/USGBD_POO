<?php
require_once('controllers/controller_usuario.php');
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
            <li><a href="views/criar_deletar_banco/criar_banco.php">Novo</a></li>

            <?php foreach ($matriz_banco as $banco) { ?>


                <li>
                    <details>
                        <summary><?= $banco['Database'] ?></summary>
                        <ul>
                            <li><a href="views/criar_deletar_tabela/criar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Nova</a></li>

                            <?php
                            $matriz_tabela = $usuario->list_table($banco['Database']);
                            foreach ($matriz_tabela as $tabela) {
                            ?>
                                <li>
                                    <a href="views/info_banco_tabela/info_tabela.php?nome_banco=<?= $banco['Database'] ?>&nome_tabela=<?= $tabela['Tables_in_' . $banco['Database']] ?>"><?= $tabela['Tables_in_' . $banco['Database']] ?></a>
                                </li>
                            <?php } ?>
                            <a href="views/criar_deletar_tabela/deletar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Deletar tabela</a>
                        </ul>
                    </details>
                </li>
            <?php } ?>
        </ul>

        <p><a href="views/criar_deletar_banco/deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>
        <h1>Bem vindo ao <b>USGBD</b></h1>
    </section>
</body>

</html>