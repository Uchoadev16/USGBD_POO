<?php
require_once('../../controllers/controller_usuario.php');
$usuario = new controller_usuario;
$matriz_banco = $usuario->list_database();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USQL</title>
    <style>
        nav {
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

            <h1><a href="../../index.php">USGBD</a></h1>
            <p>Databases</p>
            <li><a href="criar_banco.php">Novo</a></li>

            <?php foreach ($matriz_banco as $banco) { ?>

                <li>
                    <details>
                        <summary><?= $banco['Database'] ?></summary>
                        <ul>
                            <li><a href="../criar_deletar_tabela/criar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Nova</a></li>

                            <?php
                            $matriz_tabela = $usuario->list_table($banco['Database']);
                            foreach ($matriz_tabela as $tabela) {
                            ?>
                                <li>
                                    <a href="../info_banco_tabela/info_tabela.php?nome_banco=<?= $banco['Database'] ?>&nome_tabela=<?= $tabela['Tables_in_' . $banco['Database']] ?>"><?= $tabela['Tables_in_' . $banco['Database']] ?></a>
                                </li>
                            <?php } ?>
                            <a href="../criar_deletar_tabela/deletar_tabela.php?nome_banco=<?= $banco['Database'] ?>">Deletar tabela</a>
                        </ul>
                    </details>
                </li>
            <?php } ?>
        </ul>

        <p><a href="deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>

        <form action="../../controllers/controller.php" method="post">
            <input type="text" name="nome_banco" id="criarbancojs" required pattern="\S+">
            <button type="submit" name="criar_banco">Criar Banco</button><br>
        </form><br>
        <?php

        // se existir o get"certo"

        if (isset($_GET['result'])) {

            switch ($result = $_GET['result']) {
                case 'certo':
                    echo "Banco criado com sucesso!";
                    break;

                case 'erro':
                    echo "Erro ao criar o banco!";
                    break;

                case 'ja_existe':
                    echo "Já existe um banco esse nome!";
                    break;
            }
        }
        ?>
    </section>

    <script>
        const input = document.getElementById('criarbancojs');

        input.addEventListener('input', function() {
            // Verifica se o primeiro caractere é um número
            if (/^\d/.test(this.value)) {
                // Remove o primeiro caractere se for um número
                this.value = this.value.slice(1);
            }
        });
        const espaco = document.getElementById('criarbancojs');
        input.addEventListener('keypress', function(event) {
            if (event.key === ' ') {
                event.preventDefault(); // Impede a inserção de espaços
            }
        });
    </script>
</body>

</html>