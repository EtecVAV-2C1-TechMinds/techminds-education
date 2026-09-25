<?php

/* =========================================
   TECHMINDS EDUCATION
   PAINEL ADMINISTRATIVO (HUB)
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Contato.php';

$contatoModel = new Contato();
$mensagensNaoLidas = $contatoModel->contarNaoLidas();

$title = "Painel Administrativo | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>

    .admin-hub-page {
    background-color: #f1f1f1;
    flex: 1;
    padding: 50px 20px 70px;
    box-sizing: border-box;
}

    .admin-hub-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .admin-hub-header {
        background-color: var(--green-main);
        color: white;
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 30px;
    }

    .admin-hub-header h1 {
        margin: 0 0 8px;
        font-size: 26px;
        font-weight: 700;
    }

    .admin-hub-header p {
        margin: 0;
        color: rgba(255,255,255,0.88);
    }

    .admin-hub-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .admin-hub-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 18px;
        background-color: white;
        border-radius: 16px;
        padding: 25px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 5px 16px rgba(0, 0, 0, 0.07);
        transition: 0.2s;
    }

    .admin-hub-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.11);
        color: inherit;
    }

    .admin-hub-icon {
        width: 55px;
        height: 55px;
        min-width: 55px;
        border-radius: 14px;
        background-color: #eef1e7;
        color: var(--green-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .admin-hub-card h3 {
        margin: 0 0 5px;
        color: var(--green-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .admin-hub-card p {
        margin: 0;
        color: #777;
        font-size: 13px;
    }

    .admin-hub-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #b3261e;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 12px;
    }

    @media (max-width: 700px) {
        .admin-hub-grid {
            grid-template-columns: 1fr;
        }
    }

</style>

<main class="admin-hub-page">
    <div class="admin-hub-container">

        <div class="admin-hub-header">
            <h1>Painel Administrativo</h1>
            <p>Gerencie matérias, conteúdos, aulas, questões, simulados, alunos e mensagens da plataforma.</p>
        </div>

        <div class="admin-hub-grid">

            <a href="materias.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-book"></i></div>
                <div>
                    <h3>Cadastrar Matéria</h3>
                    <p>Adicione ou edite as matérias do cursinho.</p>
                </div>
            </a>

            <a href="dashboard.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div>
                    <h3>Cadastrar Conteúdo</h3>
                    <p>Gerencie os conteúdos de cada matéria.</p>
                </div>
            </a>

            <a href="../pages/cadastroaula.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-video"></i></div>
                <div>
                    <h3>Cadastrar Aula</h3>
                    <p>Adicione vídeoaulas e materiais de apoio.</p>
                </div>
            </a>

            <a href="aulas.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-list-check"></i></div>
                <div>
                    <h3>Gerenciar Aulas</h3>
                    <p>Consulte, edite ou exclua aulas cadastradas.</p>
                </div>
            </a>

            <a href="../pages/exercicios.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-circle-question"></i></div>
                <div>
                    <h3>Cadastrar Questões</h3>
                    <p>Adicione questões de fixação por conteúdo.</p>
                </div>
            </a>

            <a href="simuladosadmin.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-stopwatch"></i></div>
                <div>
                    <h3>Gerenciar Simulados</h3>
                    <p>Crie simulados e vincule questões a eles.</p>
                </div>
            </a>

            <a href="alunos.php" class="admin-hub-card">
                <div class="admin-hub-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <h3>Gerenciar Alunos</h3>
                    <p>Ative ou desative contas de alunos.</p>
                </div>
            </a>

            <a href="mensagens.php" class="admin-hub-card">

                <?php if ($mensagensNaoLidas > 0): ?>
                    <span class="admin-hub-badge"><?= $mensagensNaoLidas; ?></span>
                <?php endif; ?>

                <div class="admin-hub-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <h3>Mensagens de Contato</h3>
                    <p>Veja as mensagens enviadas pelo formulário de contato.</p>
                </div>
            </a>

        </div>

    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Suporte na verificação de $_SESSION em rotas protegidas (ex: painel administrativo). 
Validação: Lógica de bloqueio e liberação de páginas testada com usuários autenticados e deslogados, com validação pelas alunas. 
*/
?>
