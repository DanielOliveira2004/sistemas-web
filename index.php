<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Projeto PHP</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            if (form) {
                form.reset();
                form.addEventListener("input", function(event) {
                    const target = event.target;
                    const errorMessage = target.parentNode.querySelector(".erroMessage");

                    if (errorMessage) {
                        if (target.value.trim() !== "") {
                            errorMessage.remove();
                        }
                    }
                });
            }
        });
    </script>
</head>

<body>
    <div class="form-content">
        <h1>Formulário de Usuário</h1>

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $nome = $idade = $email = $genero = $pais = $descricao = "";
        $errors = [];
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["nome"])) {
                $errors[] = "Nome é obrigatório.";
            } else {
                $nome = htmlspecialchars(trim($_POST["nome"]));
            }

            if (empty($_POST["idade"])) {
                $errors[] = "Idade é obrigatório.";
            } else {
                $idade = (int)$_POST["idade"];
            }

            if (empty($_POST["email"])) {
                $errors[] = "E-mail é obrigatório.";
            } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Formato de e-mail inválido.";
            } else {
                $email = htmlspecialchars(trim($_POST["email"]));
            }

            if (empty($_POST["genero"])) {
                $errors[] = "Gênero é obrigatório.";
            } else {
                $genero = htmlspecialchars($_POST["genero"]);
            }

            if (empty($_POST["pais"])) {
                $errors[] = "País de Residência é obrigatório.";
            } else {
                $pais = htmlspecialchars($_POST["pais"]);
            }

            if (empty($_POST["descricao"])) {
                $errors[] = "Descrição é obrigatória.";
            } else {
                $descricao = htmlspecialchars(trim($_POST["descricao"]));
            }

            if (empty($errors)) {
                include 'db.php';

                if ($conn->connect_error) {
                    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, idade, genero, pais, descricao, data_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                if (!$stmt) {
                    die("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param("ssisss", $nome, $email, $idade, $genero, $pais, $descricao);

                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();
                    $nome = $idade = $email = $genero = $pais = $descricao = ""; // Resetar variáveis
                    $success = "Dados salvos com sucesso!";
                } else {
                    $errors[] = "Erro ao salvar os dados!";
                    $stmt->close();
                    $conn->close();
                }
            }
        }
        ?>

        <form method="post">
            <div class="duo-line-big">
                <div class="area-name">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
                    <?php
                    if (in_array("Nome é obrigatório.", $errors)) {
                        echo "<p class='erroMessage'>Nome é obrigatório.</p>";
                    }
                    ?>
                </div>

                <div class="area-age">
                    <label for="idade">Idade</label>
                    <input type="number" id="idade" name="idade" value="<?php echo htmlspecialchars($idade); ?>">
                    <?php
                    if (in_array("Idade é obrigatório.", $errors)) {
                        echo "<p class='erroMessage'>Idade é obrigatório.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="area-input">
                <label for="email">E-mail</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <?php
                if (in_array("E-mail é obrigatório.", $errors)) {
                    echo "<p class='erroMessage'>E-mail é obrigatório.</p>";
                } elseif (in_array("Formato de e-mail inválido.", $errors)) {
                    echo "<p class='erroMessage'>Formato de e-mail inválido.</p>";
                }
                ?>
            </div>

            <div class="duo-line-big">
                <div class="area-genero">
                    <label for="genero">Gênero</label>
                    <select id="genero" name="genero">
                        <option value=""></option>
                        <option value="Masculino" <?php if ($genero == "Masculino") echo "selected"; ?>>Masculino</option>
                        <option value="Feminino" <?php if ($genero == "Feminino") echo "selected"; ?>>Feminino</option>
                        <option value="Outro" <?php if ($genero == "Outro") echo "selected"; ?>>Outro</option>
                    </select>
                    <?php
                    if (in_array("Gênero é obrigatório.", $errors)) {
                        echo "<p class='erroMessage'>Gênero é obrigatório.</p>";
                    }
                    ?>
                </div>

                <div class="area-country">
                    <label for="pais">País de Residência</label>
                    <select id="pais" name="pais">
                        <option value=""></option>
                        <option value="Brasil" <?php if ($pais == "Brasil") echo "selected"; ?>>Brasil</option>
                        <option value="Portugal" <?php if ($pais == "Portugal") echo "selected"; ?>>Portugal</option>
                        <option value="EUA" <?php if ($pais == "EUA") echo "selected"; ?>>EUA</option>
                        <option value="Outro" <?php if ($pais == "Outro") echo "selected"; ?>>Outro</option>
                    </select>
                    <?php
                    if (in_array("País de Residência é obrigatório.", $errors)) {
                        echo "<p class='erroMessage'>País de Residência é obrigatório.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="area-input">
                <label for="descricao">Breve Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" cols="50"><?php echo htmlspecialchars($descricao); ?></textarea>
                <?php
                if (in_array("Descrição é obrigatória.", $errors)) {
                    echo "<p class='erroMessage'>Descrição é obrigatória.</p>";
                }
                ?>
            </div>

            <input class="button" type="submit" value="Enviar">

            <?php
            if (!empty($success)) {
                echo "<p class='sucessMessage'>$success</p>";
            } elseif (in_array("Erro ao salvar os dados!", $errors)) {
                echo "<p class='erroMessage'>Erro ao salvar os dados!</p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
