<?php

/* =========================================
   TECHMINDS EDUCATION
   QUESTIONS - CONTENTS OF A SUBJECT
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   GET SUBJECT ID
========================================= */

$materiaId = (int) ($_GET['materia_id'] ?? 0);

if ($materiaId <= 0) {
    header('Location: questoes.php');
    exit;
}


/* =========================================
   FIND SUBJECT
========================================= */

$sqlMateria = "
    SELECT
        id,
        nome,
        descricao
    FROM materias
    WHERE id = :id
    AND ativo = 1
    LIMIT 1
";

$stmtMateria = $pdo->prepare($sqlMateria);
$stmtMateria->execute([
    ':id' => $materiaId
]);

$materia = $stmtMateria->fetch(PDO::FETCH_ASSOC);

if (!$materia) {
    header('Location: questoes.php');
    exit;
}


/* =========================================
   LOAD CONTENTS
========================================= */

$conteudoModel = new Conteudo();
$conteudos = $conteudoModel->listarPorMateria($materiaId);


/* =========================================
   PAGE TITLE
========================================= */

$title = "Exercícios de " . htmlspecialchars($materia['nome']) . " | " . NOME_SISTEMA;


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Exercícios de " . $materia['nome'];
$bannerSubtitulo = "Escolha um conteúdo para praticar.";
include(__DIR__ . '/../includes/banner.php');

?>


<style>
    .questoes-conteudos-page {
        background-color: #f1f1f1;
        min-height: 60vh;
        padding: 45px 20px 80px;
    }

    .questoes-conteudos-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--green-dark);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .back-link:hover {
        color: var(--green-main);
    }

    .questoes-content-card {
        background-color: white;
        border-radius: 16px;
        padding: 22px 25px;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .questoes-content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.11);
    }

    .questoes-content-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        color: inherit;
        text-decoration: none;
    }

    .questoes-content-info {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }

    .questoes-content-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--green-main);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .questoes-content-info h2 {
        color: var(--green-dark);
        font-size: 19px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .questoes-content-info p {
        color: #666;
        font-size: 14px;
        margin: 0;
        line-height: 1.5;
    }

    .questoes-content-arrow {
        color: var(--green-main);
        font-size: 18px;
        flex-shrink: 0;
    }

    .empty-questoes-content {
        background-color: white;
        border-radius: 16px;
        padding: 50px 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
    }

    .empty-questoes-content i {
        color: var(--green-main);
        font-size: 40px;
        margin-bottom: 15px;
    }

    @media (max-width: 575px) {
        .questoes-conteudos-page {
            padding: 35px 15px 60px;
        }

        .questoes-content-card {
            padding: 18px;
        }
    }
</style>


<main class="questoes-conteudos-page">

    <div class="questoes-conteudos-container">

        <a href="questoes.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar para matérias
        </a>

        <?php if (!empty($conteudos)): ?>

            <?php foreach ($conteudos as $conteudo): ?>

                <article class="questoes-content-card">

                    <a href="questoes_conteudo.php?conteudo_id=<?= (int) $conteudo['id']; ?>" class="questoes-content-link">

                        <div class="questoes-content-info">

                            <div class="questoes-content-icon">
                                <i class="fa-solid fa-circle-question"></i>
                            </div>

                            <div>

                                <h2>
                                    <?= htmlspecialchars($conteudo['titulo']); ?>
                                </h2>

                                <?php if (!empty($conteudo['descricao'])): ?>
                                    <p>
                                        <?= htmlspecialchars($conteudo['descricao']); ?>
                                    </p>
                                <?php else: ?>
                                    <p>
                                        Pratique com exercícios deste conteúdo.
                                    </p>
                                <?php endif; ?>

                            </div>

                        </div>

                        <i class="fa-solid fa-arrow-right questoes-content-arrow"></i>

                    </a>

                </article>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-questoes-content">
                <i class="fa-solid fa-book-open"></i>
                <h2>Nenhum conteúdo disponível</h2>
                <p>Ainda não existem conteúdos cadastrados para esta matéria.</p>
            </div>

        <?php endif; ?>

    </div>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>