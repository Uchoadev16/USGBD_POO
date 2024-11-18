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

        //se existir "nome_numero_tabela" e existir "nome_banco" e nao estiver vazio a variavel "nome_tabela" e nao estiver vazio a variavel "numero_coluna"
        if (isset($_POST['nome_numero_tabela']) && isset($_GET['nome_banco']) && !empty($_POST['nome_tabela']) && !empty($_POST['numero_coluna'])) {

            //criando as variaveis com os valores passados
            $nome_tabela = $_POST['nome_tabela'];
            $numero_coluna = $_POST['numero_coluna'];
            $nome_banco = $_GET['nome_banco'];
        ?>
 
            <form action="../../controllers/controller.php" method="post">

                <p>Nome da tabela: <?= $nome_tabela ?></p>
                <p>Número de tabelas: <?= $numero_coluna ?></p>

                <input type="hidden" name="nome_tabela" value="<?= $nome_tabela ?>">
                <input type="hidden" name="nome_banco" value="<?= $nome_banco ?>">
                <table>
                    <tr>
                        <td>Nome</td>
                        <td>Tipo</td>
                        <td>Tamanho</td>
                        <td>Não nulo</td>
                        <td>Auto-incrementavel</td>
                        <td>Primaria</td>
                    </tr>

                    <?php
                    //em quanto o numero de colunas for menor ou igual a $i
                    $i = $numero_coluna;
                    while ($i >= 1) {
                    ?>

                        <tr>
                            <td><input type="text" name="nome_coluna" id="criartabelajs" required></td>
                            <td>
                                <select name="tipo_coluna" required>
                                    <option value="INT">INT</option>
                                    <option value="VARCHAR">VARCHAR</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="TIME">TIME</option>
                                    <option value="DATE">DATE</option>
                                </select>
                            </td>
                            <td><input type="number" name="tamanho_coluna"></td>
                            <td><input type="checkbox" name="nao_nulo_coluna" value="NOT NULL"></td>
                            <td><input type="checkbox" name="auto_incre_coluna" value="PRIMARY KEY"></td>
                            <td><input type="radio" name="primario_coluna" value="AUTO_INCREMENT"></td>
                        </tr>
                    <?php
                        $i--;
                    }
                    ?>
                </table>
                <button type="submit" name="criar_tabela">Criar tabela</button>
            </form>
        <?php } else {

            header('location:../../index.php');
        } ?>

        <script>
            //criando a constante input 
            const input = document.getElementById('criartabelajs');

            //criando a função para inpedir que o usuario coloque valores comecando com um numero 
            input.addEventListener('input', function() {
                // Verifica se o primeiro caractere é um número
                if (/^\d/.test(this.value)) {
                    // Remove o primeiro caractere se for um número
                    this.value = this.value.slice(1);
                }
            });
            //criando a constante espaco
            const espaco = document.getElementById('criartabelajs');

            //criando a função para inpedir que o usuario coloque espaços
            input.addEventListener('keypress', function(event) {
                if (event.key === ' ') {
                    event.preventDefault(); // Impede a inserção de espaços
                }
            });
        </script>
    </section>
</body>

</html>