<?php

/* =========================================
   TECHMINDS EDUCATION
   QUESTIONS PAGE
========================================= */

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../models/Questao.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   PAGE TITLE
========================================= */

$title = "Questões | TechMinds Education";


/* =========================================
   LOAD CONTENT MODEL
========================================= */

$conteudoModel = new Conteudo();


/* =========================================
   LOAD SUBJECTS
========================================= */

$materias = $conteudoModel->listarMaterias();


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');


/* =========================================
   BANNER
========================================= */

$bannerTitulo = "Questões";

$bannerSubtitulo = "Questões de fixação por conteúdo";

include(__DIR__ . '/../includes/banner.php');

?>


<style>

    /* =========================================
       PAGE
    ========================================= */

    .questions-page {

        background-color: #ebebeb;

        min-height: 70vh;

        padding: 50px 20px 70px;

    }


    .questions-container {

        width: 100%;

        max-width: 1100px;

        margin: 0 auto;

    }


    /* =========================================
       TITLE
    ========================================= */

    .questions-title {

        color: #233703;

        font-size: 24px;

        font-weight: 700;

        margin-bottom: 25px;

    }


    .questions-subtitle {

        color: #666;

        margin-bottom: 35px;

    }


    /* =========================================
       SUBJECT GRID
    ========================================= */

    .questions-grid {

        display: grid;

        grid-template-columns:
            repeat(3, 1fr);

        gap: 25px;

    }


    /* =========================================
       SUBJECT CARD
    ========================================= */

    .question-subject-card {

        background-color: #ffffff;

        border-radius: 18px;

        padding: 28px;

        min-height: 210px;

        display: flex;

        flex-direction: column;

        justify-content: space-between;

        box-shadow:
            0 6px 18px rgba(0, 0, 0, 0.08);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;

    }


    .question-subject-card:hover {

        transform: translateY(-4px);

        box-shadow:
            0 10px 25px rgba(0, 0, 0, 0.12);

    }


    /* =========================================
       SUBJECT TITLE
    ========================================= */

    .question-subject-card h3 {

        color: #233703;

        font-size: 21px;

        font-weight: 700;

        margin-bottom: 10px;

    }


    /* =========================================
       DESCRIPTION
    ========================================= */

    .question-subject-card p {

        color: #666;

        font-size: 14px;

        line-height: 1.6;

        margin-bottom: 20px;

    }


    /* =========================================
       BUTTON
    ========================================= */

    .question-subject-button {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        width: 100%;

        padding: 11px 18px;

        background-color: #6b783e;

        color: #ffffff;

        text-decoration: none;

        border-radius: 25px;

        font-size: 14px;

        font-weight: 700;

        transition:
            background-color 0.2s ease,
            transform 0.2s ease;

    }


    .question-subject-button:hover {

        background-color: #576332;

        color: #ffffff;

        transform: translateY(-1px);

    }


    /* =========================================
       EMPTY STATE
    ========================================= */

    .questions-empty {

        background-color: #ffffff;

        border-radius: 18px;

        padding: 50px 25px;

        text-align: center;

        box-shadow:
            0 6px 18px rgba(0, 0, 0, 0.08);

    }


    .questions-empty i {

        color: #6b783e;

        font-size: 45px;

        margin-bottom: 18px;

    }


    .questions-empty h3 {

        color: #233703;

        font-size: 20px;

        font-weight: 700;

        margin-bottom: 10px;

    }


    .questions-empty p {

        color: #666;

        margin: 0;

    }


    /* =========================================
       TABLET
    ========================================= */

    @media (max-width: 991px) {

        .questions-grid {

            grid-template-columns:
                repeat(2, 1fr);

        }

    }


    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 575px) {

        .questions-page {

            padding:
                35px 15px 50px;

        }


        .questions-grid {

            grid-template-columns: 1fr;

            gap: 18px;

        }


        .question-subject-card {

            min-height: 190px;

            padding: 24px;

        }


        .questions-title {

            font-size: 21px;

        }

    }

</style>


<main class="questions-page">

    <div class="questions-container">


        <h2 class="questions-title">

            Escolha uma matéria

        </h2>


        <p class="questions-subtitle">

            Selecione uma matéria para acessar os conteúdos
            e realizar exercícios de fixação.

        </p>


        <?php if (!empty($materias)): ?>


            <div class="questions-grid">


                <?php foreach ($materias as $materia): ?>


                    <article class="question-subject-card">


                        <div>

                            <h3>

                                <?= htmlspecialchars(
                                    $materia['nome']
                                ); ?>

                            </h3>


                            <?php if (!empty($materia['descricao'])): ?>

                                <p>

                                    <?= htmlspecialchars(
                                        $materia['descricao']
                                    ); ?>

                                </p>

                            <?php else: ?>

                                <p>

                                    Acesse os conteúdos desta
                                    matéria e pratique seus conhecimentos.

                                </p>

                            <?php endif; ?>

                        </div>


                        <a
                            href="conteudos.php?materia_id=<?= (int) $materia['id']; ?>"
                            class="question-subject-button"
                        >

                            Ver conteúdos

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div class="questions-empty">


                <i class="fa-solid fa-circle-question"></i>


                <h3>

                    Nenhuma matéria disponível

                </h3>


                <p>

                    Ainda não existem matérias cadastradas
                    para realizar exercícios.

                </p>


            </div>


        <?php endif; ?>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>
