<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTATO
========================================= */

require_once __DIR__ . '/../config/config.php';

$title = "Contato | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Fale Conosco";
$bannerSubtitulo = "Tire suas dúvidas ou envie sua mensagem para a nossa equipe.";
include(__DIR__ . '/../includes/banner.php');

?>

<style>

html,
body {
    min-height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

footer,
.footer {
    position: static !important;
    bottom: auto !important;
    left: auto !important;
    right: auto !important;
    top: auto !important;
    width: 100%;
    flex-shrink: 0;
}

    .contato-page {
        background-color: #f1f1f1;
        min-height: 60vh;
        padding: 50px 20px 80px;
    }

    .contato-container {
        max-width: 900px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 25px;
    }

    .contato-info-card,
    .contato-form-card {
        background-color: #ffffff;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
    }

    .contato-info-card h3 {
        color: var(--green-dark);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contato-info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
    }

    .contato-info-item i {
        color: var(--green-main);
        font-size: 18px;
        margin-top: 3px;
    }

    .contato-info-item span {
        color: #555;
        font-size: 14px;
        line-height: 1.5;
    }

    .contato-form-card label {
        font-weight: 600;
        font-size: 14px;
        color: #444;
        margin-bottom: 6px;
        display: block;
    }

    .contato-form-card .form-control {
        border-radius: 10px;
        margin-bottom: 16px;
    }

    .btn-enviar-contato {
        background-color: var(--green-main);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 700;
    }

    .btn-enviar-contato:hover {
        background-color: var(--green-dark);
        color: white;
    }

    @media (max-width: 767px) {

        .contato-container {
            grid-template-columns: 1fr;
        }

    }

</style>

<main class="contato-page">

    <div class="contato-container">

        <div class="contato-info-card">

            <h3>Informações de contato</h3>

            <div class="contato-info-item">
                <i class="fa-solid fa-envelope"></i>
                <span>techminds.vav@gmail.com.br</span>
            </div>

            <div class="contato-info-item">
                <i class="fa-solid fa-phone"></i>
                <span>(11) 957787950</span>
            </div>

            <div class="contato-info-item">
                <i class="fa-solid fa-clock"></i>
                <span>Atendimento de segunda a sexta, das 8h às 18h</span>
            </div>

            <div class="contato-info-item">
                <i class="fa-solid fa-location-dot"></i>
                <span>Plataforma 100% online</span>
            </div>

        </div>

        <div class="contato-form-card">

            <h3 style="color: var(--green-dark); font-size: 18px; font-weight: 700; margin-bottom: 20px;">
                Envie sua mensagem
            </h3>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success">Mensagem enviada com sucesso! Retornaremos em breve.</div>
            <?php endif; ?>

            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger">
                    <?php
                    switch ($_GET['erro']) {
                        case 'preencha': echo 'Preencha todos os campos obrigatórios.'; break;
                        case 'email': echo 'Digite um e-mail válido.'; break;
                        default: echo 'Não foi possível enviar sua mensagem. Tente novamente.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= URL_SISTEMA ?>/controllers/ContatoController.php">

                <label>Nome</label>
                <input type="text" name="nome" class="form-control" placeholder="Seu nome completo" required>

                <label>E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="Seu e-mail" required>

                <label>Assunto</label>
                <input type="text" name="assunto" class="form-control" placeholder="Sobre o que você quer falar?">

                <label>Mensagem</label>
                <textarea name="mensagem" class="form-control" rows="5" placeholder="Escreva sua mensagem aqui..." required></textarea>

                <button type="submit" class="btn-enviar-contato">Enviar mensagem</button>

            </form>

        </div>

    </div>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>