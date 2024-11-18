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
        <?php

        //criando a variavel com o get passado
        $nome_banco = $_GET['nome_banco'] ?? 0;
        ?>
        <form action="criar_colunas.php?nome_banco=<?= $nome_banco ?>" method="post">
            <label for="nome">Nome tabela:</label>
            <input type="text" name="nome_tabela" id="criartabelajs" required placeholder="Nome"><br>
            <label for="numero">Número de colunas:</label>
            <input type="number" name="numero_coluna" id="numero" required placeholder="Número"><br>
            <button type="submit" name="nome_numero_tabela">Continuar</button><br>
        </form>
        <?php

        if (isset($_GET['result'])) {

            $result = $_GET['result'];
            switch ($result) {

                case 'ja_existe':
                    echo "A tabela já existe!";
                    break;

                case 'certo':
                    echo "Tabela criada com sucesso!";
                    break;

                case 'erro':
                    echo "Erro ao criar a tabela!";
                    break;
            }
        }
        ?>
    </section>
    <script>
        const input = document.getElementById('criartabelajs');

        input.addEventListener('input', function() {
            // Verifica se o primeiro caractere é um número
            if (/^\d/.test(this.value)) {
                // Remove o primeiro caractere se for um número
                this.value = this.value.slice(1);
            }
        });

        const espaco = document.getElementById('criartabelajs');
        input.addEventListener('keypress', function(event) {
            if (event.key === ' ') {
                event.preventDefault(); // Impede a inserção de espaços
            }
        });
    </script>

</body>

</html>