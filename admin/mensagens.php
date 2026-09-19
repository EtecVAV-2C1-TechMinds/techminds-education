<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - MENSAGENS DE CONTATO
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Contato.php';

$contatoModel = new Contato();
$mensagens = $contatoModel->listar();

$title = "Mensagens de Contato | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilos exclusivos do Dashboard e Fixação do Footer -->
<style>

    /* =========================================
       LAYOUT GLOBAL / FIXAR FOOTER EMBAIXO
    ========================================= */

    html {
        height: 100%;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
        color: #333333;
        margin: 0;
    }

    /* O main se expande para ocupar todo o espaço vago, empurrando o footer */
    .dashboard-content {
        flex: 1 0 auto;
        width: 100%;
        max-width: 1050px;
        margin: 0 auto;
        padding: 45px 20px;
    }


    /* =========================================
       PAGE TITLE / HERO
    ========================================= */

    .dashboard-hero {
        background-color: var(--green-main);
        padding: 45px 20px;
        text-align: center;
        flex-shrink: 0;
    }


    .dashboard-hero h1 {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }


    .dashboard-hero p {
        color: #ffffff;
        margin: 0;
        font-size: 0.95rem;
    }


    /* =========================================
       MESSAGE CARDS
    ========================================= */

    .message-card {
        background-color: #f2f2f2;
        border-radius: 20px;
        padding: 25px;
        border: none;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .message-card.unread {
        border-left: 6px solid #A77E34 !important;
        background-color: #f9f9f9;
    }

    .message-sender {
        color: #1A2601;
        font-size: 1.15rem;
        font-weight: 700;
    }

    .message-email {
        color: #666666;
        font-size: 0.85rem;
    }

    .message-subject {
        color: #1A2601;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 8px;
    }

    .message-body {
        color: #444444;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .badge-new {
        background-color: #A77E34;
        color: #ffffff;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 600;
    }

    /* =========================================
       BUTTONS
    ========================================= */

    .action-button {
        display: inline-block;
        padding: 7px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        transition: background-color 0.2s;
    }

    .read-button {
        background-color: #A77E34;
        color: #ffffff;
    }

    .read-button:hover {
        background-color: #8f692b;
        color: #ffffff;
    }

    .delete-button {
        background-color: #757B4B;
        color: #ffffff;
    }

    .delete-button:hover {
        background-color: #60643c;
        color: #ffffff;
    }

    /* =========================================
       EMPTY STATE & ALERTS
    ========================================= */

    .empty-card {
        background-color: #f2f2f2;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        color: #666666;
    }

    .dashboard-alert {
        max-width: 700px;
        margin: 0 auto 30px;
        border: none;
        border-radius: 15px;
        text-align: center;
    }

</style>


<!-- Script para garantir a atualização do título da aba no navegador -->
<script>
    document.title = "Mensagens de Contato | <?= addslashes(NOME_SISTEMA) ?>";
</script>


<!-- =========================================
     PAGE HERO
========================================= -->

<section class="dashboard-hero">

    <h1>
        Mensagens de Contato
    </h1>

    <p>
        Área do administrador
    </p>

</section>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="dashboard-content">

    <!-- =========================================
         SUCCESS MESSAGES
    ========================================= -->

    <?php if (isset($_GET['sucesso'])): ?>

        <div class="alert alert-success dashboard-alert">

            <?php

            switch ($_GET['sucesso']) {

                case 'lida':
                    echo 'Mensagem marcada como lida com sucesso.';
                    break;

                case 'excluida':
                    echo 'Mensagem excluída com sucesso.';
                    break;

                default:
                    echo 'Operação realizada com sucesso.';
            }

            ?>

        </div>

    <?php endif; ?>


    <!-- =========================================
         ERROR MESSAGES
    ========================================= -->

    <?php if (isset($_GET['erro'])): ?>

        <div class="alert alert-danger dashboard-alert">

            Não foi possível realizar a operação. Tente novamente mais tarde.

        </div>

    <?php endif; ?>


    <!-- =========================================
         MESSAGES LIST
    ========================================= -->

    <?php if (empty($mensagens)): ?>

        <div class="empty-card">

            <p class="mb-0">
                Nenhuma mensagem recebida ainda.
            </p>

        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($mensagens as $mensagem): ?>

                <div class="col-12">

                    <article class="message-card <?= (int) $mensagem['lida'] === 0 ? 'unread' : ''; ?>">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">

                            <div>

                                <h5 class="message-sender mb-1">

                                    <?= htmlspecialchars($mensagem['nome']); ?>

                                    <?php if ((int) $mensagem['lida'] === 0): ?>
                                        <span class="badge-new ms-2">Nova</span>
                                    <?php endif; ?>

                                </h5>

                                <p class="message-email mb-0">
                                    <?= htmlspecialchars($mensagem['email']); ?>
                                    &middot;
                                    <?= formatarData($mensagem['data_envio']); ?>
                                </p>

                            </div>

                            <div class="d-flex gap-2">

                                <?php if ((int) $mensagem['lida'] === 0): ?>

                                    <a
                                        href="../controllers/AdminController.php?acao=mensagem_lida&id=<?= (int) $mensagem['id']; ?>"
                                        class="action-button read-button"
                                    >
                                        Marcar como lida
                                    </a>

                                <?php endif; ?>

                                <a
                                    href="../controllers/AdminController.php?acao=mensagem_excluir&id=<?= (int) $mensagem['id']; ?>"
                                    class="action-button delete-button"
                                    onclick="return confirm('Excluir esta mensagem?');"
                                >
                                    Excluir
                                </a>

                            </div>

                        </div>

                        <?php if (!empty($mensagem['assunto'])): ?>
                            <p class="message-subject">
                                Assunto: <?= htmlspecialchars($mensagem['assunto']); ?>
                            </p>
                        <?php endif; ?>

                        <p class="message-body mb-0">
                            <?= nl2br(htmlspecialchars($mensagem['mensagem'])); ?>
                        </p>

                    </article>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>