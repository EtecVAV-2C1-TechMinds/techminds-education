<?php

/* =========================================
   TECHMINDS EDUCATION
   CONFIGURAÇÕES DA CONTA
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

$title = "Configurações | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>

    .config-page {
        background-color: #f1f1f1;
        min-height: 60vh;
        padding: 50px 20px 80px;
    }

    .config-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .config-card {
        background-color: #ffffff;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
    }

    .config-card h2 {
        color: var(--green-dark);
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .config-card p.subtitle {
        color: #777;
        font-size: 14px;
        margin-bottom: 25px;
    }

    .config-card label {
        font-weight: 600;
        font-size: 14px;
        color: #444;
        margin-bottom: 6px;
        display: block;
    }

    .config-card .form-control {
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .btn-salvar-config {
        background-color: var(--green-main);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 700;
        width: 100%;
    }

    .btn-salvar-config:hover {
        background-color: var(--green-dark);
        color: white;
    }

</style>

<main class="config-page">

    <div class="config-container">

        <div class="config-card">

            <h2>Alterar senha</h2>
            <p class="subtitle">Mantenha sua conta segura com uma senha forte.</p>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success">Senha alterada com sucesso!</div>
            <?php endif; ?>

            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger">
                    <?php
                    switch ($_GET['erro']) {
                        case 'preencha': echo 'Preencha todos os campos.'; break;
                        case 'senha_curta': echo 'A nova senha deve ter pelo menos 6 caracteres.'; break;
                        case 'senhas': echo 'As senhas não coincidem.'; break;
                        case 'senha_incorreta': echo 'A senha atual está incorreta.'; break;
                        default: echo 'Não foi possível atualizar sua senha.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= URL_SISTEMA ?>/controllers/ConfiguracoesController.php">

                <label>Senha atual</label>
                <input type="password" name="senha_atual" class="form-control" required>

                <label>Nova senha</label>
                <input type="password" name="nova_senha" class="form-control" minlength="6" required>

                <label>Confirmar nova senha</label>
                <input type="password" name="confirmar_senha" class="form-control" minlength="6" required>

                <button type="submit" class="btn-salvar-config">Salvar nova senha</button>

            </form>

        </div>

    </div>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>