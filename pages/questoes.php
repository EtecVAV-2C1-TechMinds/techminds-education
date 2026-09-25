<?php

/* =========================================
   TECHMINDS EDUCATION
   QUESTIONS - SUBJECTS PAGE
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Conteudo.php';

$title = "Questões | " . NOME_SISTEMA;

$conteudoModel = new Conteudo();
$materias = $conteudoModel->listarMaterias();

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Questões";
$bannerSubtitulo = "Questões de fixação por conteúdo";
include(__DIR__ . '/../includes/banner.php');

?>

<style>
    :root {
        --questoes-green-dark: #233703;
        --questoes-green-banner: #5e7037;
        --questoes-green-btn: #6B783E;
        --questoes-green-btn-hover: #576332;
        --questoes-bg-light: #EBEBEB;
    }

    .questoes-page-wrapper {
    background-color: #EBEBEB;
    flex: 1;
}

    .materias-page {
        padding: 50px 70px;
        max-width: 1200px;
        margin: auto;
    }

    .materias-title {
        color: var(--questoes-green-dark);
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .materias-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .materia-card {
        background-color: #ffffff;
        border-radius: 20px;
        padding: 30px;
        min-height: 200px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .materia-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12);
    }

    .materia-card h3 {
        color: var(--questoes-green-dark);
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .materia-card p {
        color: #666;
        font-size: 13px;
        margin: 0 0 20px 0;
        line-height: 1.6;
    }

    .btn-materia {
        background-color: var(--questoes-green-btn);
        color: #ffffff !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .btn-materia:hover {
        background-color: var(--questoes-green-btn-hover);
        color: #ffffff !important;
    }

    .btn-materia i {
        font-size: 13px;
        transition: transform 0.2s ease;
    }

    .btn-materia:hover i {
        transform: translateX(4px);
    }

    @media (max-width: 991px) {
        .materias-page {
            padding: 40px 30px;
        }

        .materias-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 575px) {
        .materias-page {
            padding: 30px 15px;
        }

        .materias-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="questoes-page-wrapper">
    <div class="materias-page">
        <h2 class="materias-title">Escolha uma matéria</h2>

        <div class="materias-grid">
            <?php foreach ($materias as $materia): ?>
                <div class="materia-card">
                    <div>
                        <h3><?= htmlspecialchars($materia['nome']); ?></h3>
                        <p><?= htmlspecialchars($materia['descricao']); ?></p>
                    </div>

                    <a href="questoes_materia.php?materia_id=<?= (int) $materia['id']; ?>" class="btn-materia">
                        Ver questões
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento de Layout.
Finalidade: Sugestão de sintaxe e estruturas condicionais em JavaScript para manipular elementos da página.
Validação: Scripts auditados linha por linha, ajustados manualmente para evitar conflitos e validados nos eventos da página.
*/
?>
