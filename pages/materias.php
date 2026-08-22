<?php

/* =========================================
   TECHMINDS EDUCATION
   SUBJECTS PAGE
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   LOAD DATA
========================================= */

$conteudoModel = new Conteudo();

$materias = $conteudoModel->listarMaterias();


/* =========================================
   PAGE CONFIGURATION
========================================= */

$title = "Matérias | TechMinds Education";


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');


/* =========================================
   BANNER
========================================= */

$bannerTitulo = "Matérias";

$bannerSubtitulo =
    "Escolha uma matéria para acessar seus conteúdos.";

include(__DIR__ . '/../includes/banner.php');

?>


<style>

    .subjects-page {

        background-color: #f1f1f1;

        min-height: 70vh;

        padding: 50px 20px 80px;

    }


    .subjects-container {

        max-width: 1100px;

        margin: 0 auto;

    }


    /* =========================================
       PAGE TITLE
    ========================================== */

    .subjects-title {

        color: var(--green-dark);

        font-size: 28px;

        font-weight: 700;

        margin-bottom: 10px;

    }


    .subjects-description {

        color: #666;

        margin-bottom: 30px;

    }


    /* =========================================
       GRID
    ========================================== */

    .subjects-grid {

        display: grid;

        grid-template-columns:
            repeat(3, 1fr);

        gap: 25px;

    }


    /* =========================================
       SUBJECT CARD
    ========================================== */

    .subject-card {

        background-color: white;

        border-radius: 18px;

        padding: 30px;

        min-height: 220px;

        display: flex;

        flex-direction: column;

        justify-content: space-between;

        box-shadow:
            0 5px 18px rgba(0, 0, 0, 0.08);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;

    }


    .subject-card:hover {

        transform: translateY(-4px);

        box-shadow:
            0 9px 22px rgba(0, 0, 0, 0.12);

    }


    .subject-icon {

        width: 50px;

        height: 50px;

        border-radius: 50%;

        background-color: var(--green-main);

        color: white;

        display: flex;

        align-items: center;

        justify-content: center;

        margin-bottom: 18px;

    }


    .subject-icon i {

        font-size: 21px;

    }


    .subject-card h2 {

        color: var(--green-dark);

        font-size: 22px;

        font-weight: 700;

        margin-bottom: 8px;

    }


    .subject-card p {

        color: #666;

        font-size: 14px;

        line-height: 1.6;

        margin-bottom: 25px;

    }


    /* =========================================
       BUTTON
    ========================================== */

    .subject-button {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        width: 100%;

        padding: 11px 18px;

        border-radius: 25px;

        background-color: var(--green-main);

        color: white;

        text-decoration: none;

        font-weight: 600;

        transition: 0.2s ease;

    }


    .subject-button:hover {

        background-color: var(--green-dark);

        color: white;

    }


    /* =========================================
       EMPTY STATE
    ========================================== */

    .empty-subjects {

        background-color: white;

        border-radius: 18px;

        padding: 50px 25px;

        text-align: center;

        box-shadow:
            0 5px 18px rgba(0, 0, 0, 0.06);

    }


    .empty-subjects i {

        color: var(--green-main);

        font-size: 40px;

        margin-bottom: 15px;

    }


    .empty-subjects h2 {

        color: var(--green-dark);

        font-size: 22px;

        font-weight: 700;

    }


    .empty-subjects p {

        color: #666;

        margin: 0;

    }


    /* =========================================
       RESPONSIVE
    ========================================== */

    @media (max-width: 991px) {

        .subjects-grid {

            grid-template-columns:
                repeat(2, 1fr);

        }

    }


    @media (max-width: 575px) {

        .subjects-page {

            padding:
                35px 15px 60px;

        }


        .subjects-grid {

            grid-template-columns: 1fr;

        }


        .subjects-title {

            font-size: 24px;

        }

    }

</style>


<main class="subjects-page">

    <div class="subjects-container">


        <!-- =========================================
             PAGE INTRODUCTION
        ========================================== -->

        <div class="mb-4">

            <h1 class="subjects-title">

                Escolha uma matéria

            </h1>

            <p class="subjects-description">

                Selecione uma matéria para visualizar
                os conteúdos disponíveis e continuar seus estudos.

            </p>

        </div>


        <!-- =========================================
             SUBJECTS
        ========================================== -->

        <?php if (!empty($materias)): ?>


            <div class="subjects-grid">


                <?php foreach ($materias as $materia): ?>


                    <article class="subject-card">


                        <div>

                            <div class="subject-icon">

                                <i class="fa-solid fa-book"></i>

                            </div>


                            <h2>

                                <?= htmlspecialchars(
                                    $materia['nome']
                                ); ?>

                            </h2>


                            <?php if (
                                !empty($materia['descricao'])
                            ): ?>

                                <p>

                                    <?= htmlspecialchars(
                                        $materia['descricao']
                                    ); ?>

                                </p>

                            <?php else: ?>

                                <p>

                                    Acesse os conteúdos
                                    disponíveis para esta matéria.

                                </p>

                            <?php endif; ?>

                        </div>


                        <a
                            href="conteudos.php?materia_id=<?= (int) $materia['id']; ?>"
                            class="subject-button"
                        >

                            Ver conteúdos

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- =========================================
                 EMPTY STATE
            ========================================== -->

            <div class="empty-subjects">

                <i class="fa-solid fa-book-open"></i>

                <h2>

                    Nenhuma matéria disponível

                </h2>

                <p>

                    As matérias serão disponibilizadas
                    em breve.

                </p>

            </div>


        <?php endif; ?>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>
