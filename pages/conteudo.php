<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTENT PAGE
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../models/Aula.php';


/* =========================================
   GET CONTENT ID
========================================= */

$conteudoId = (int) ($_GET['id'] ?? 0);


if ($conteudoId <= 0) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   LOAD CONTENT
========================================= */

$conteudoModel = new Conteudo();

$conteudo = $conteudoModel->buscarPorId($conteudoId);


if (!$conteudo) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   LOAD CLASSES
========================================= */

$aulaModel = new Aula();

$aulas = $aulaModel->listarPorConteudo($conteudoId);

// Define o título da página dinamicamente para o header.php
$title = htmlspecialchars($conteudo['titulo']) . ' | TechMinds Education';

// Includes de Header e Navbar padrão do site
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>

    /* =========================================
       CONTENT PAGE
    ========================================= */

    .content-page {

        background-color: #f1f1f1;

        min-height: 600px;

        padding: 40px 20px 70px;

    }


    .content-header {

        background-color: var(--green-main);

        color: white;

        padding: 35px 25px;

        border-radius: 18px;

        margin-bottom: 30px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.08);

    }


    .content-header h1 {

        margin: 0 0 8px;

        font-size: 30px;

        font-weight: 700;

    }


    .content-header p {

        margin: 0;

        font-size: 15px;

        opacity: 0.95;

    }


    .content-description {

        background-color: white;

        border-radius: 15px;

        padding: 25px;

        margin-bottom: 30px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.06);

    }


    .content-description h2 {

        color: var(--green-dark);

        font-size: 21px;

        font-weight: 700;

        margin-bottom: 10px;

    }


    .content-description p {

        color: #555;

        margin: 0;

        line-height: 1.6;

    }



    /* =========================================
   QUESTIONS
========================================= */

.questions-section {

    margin-bottom: 35px;

}


.questions-button {

    background-color: var(--green-main);

    color: white;

    text-decoration: none;

    border-radius: 15px;

    padding: 20px 22px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.08);

    transition: 0.2s;

}


.questions-button:hover {

    transform: translateY(-2px);

    color: white;

    box-shadow:
        0 8px 18px rgba(0, 0, 0, 0.12);

}


.questions-button span {

    display: flex;

    align-items: center;

    gap: 12px;

    font-weight: 700;

}


.questions-button span i {

    font-size: 20px;

}


.questions-button > i {

    font-size: 18px;

}

    /* =========================================
       LESSONS
    ========================================= */

    .lessons-title {

        color: var(--green-dark);

        font-size: 24px;

        font-weight: 700;

        margin-bottom: 18px;

    }


    .lesson-card {

        background-color: #b0b29a;

        border-radius: 15px;

        padding: 20px 22px;

        margin-bottom: 15px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.08);

        transition: 0.2s;

    }


    .lesson-card:hover {

        transform: translateY(-2px);

        box-shadow:
            0 8px 18px rgba(0, 0, 0, 0.12);

    }


    .lesson-link {

        display: flex;

        align-items: center;

        gap: 15px;

        color: white;

        text-decoration: none;

    }


    .lesson-icon {

        width: 45px;

        height: 45px;

        border-radius: 50%;

        background-color: rgba(255,255,255,0.2);

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

    }


    .lesson-icon i {

        font-size: 18px;

        color: white;

    }


    .lesson-info h3 {

        margin: 0 0 4px;

        font-size: 18px;

        font-weight: 700;

        color: white;

    }


    .lesson-info p {

        margin: 0;

        font-size: 13px;

        color: rgba(255,255,255,0.85);

    }


    /* =========================================
       EMPTY LESSONS
    ========================================= */

    .empty-lessons {

        background-color: white;

        border-radius: 15px;

        padding: 40px 25px;

        text-align: center;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.06);

    }


    .empty-lessons i {

        font-size: 35px;

        color: var(--green-main);

        margin-bottom: 15px;

    }


    .empty-lessons h3 {

        color: var(--green-dark);

        font-size: 20px;

        font-weight: 700;

    }


    .empty-lessons p {

        color: #666;

        margin: 0;

    }


    /* =========================================
       DESKTOP
    ========================================= */

    @media (min-width: 768px) {

        .content-page {

            padding: 55px 30px 80px;

        }


        .content-container {

            max-width: 900px;

            margin: 0 auto;

        }


        .content-header {

            padding: 45px 40px;

        }


        .content-header h1 {

            font-size: 38px;

        }


        .content-description {

            padding: 30px 35px;

        }


        .lesson-card {

            padding: 22px 25px;

        }

    }


    @media (min-width: 1200px) {

        .content-container {

            max-width: 1000px;

        }

    }

</style>


<!-- Script para reforçar o título dinâmico na aba do navegador -->
<script>
    document.title = "<?= addslashes($conteudo['titulo']); ?> | TechMinds Education";
</script>


<!-- =========================================
     PAGE CONTENT
========================================= -->

<main class="content-page">

    <div class="content-container">


        <!-- =========================================
             CONTENT HEADER
        ========================================== -->

        <section class="content-header">

            <h1>

                <?= htmlspecialchars(
                    $conteudo['titulo']
                ); ?>

            </h1>


            <p>

                <?= htmlspecialchars(
                    $conteudo['materia']
                ); ?>

            </p>

        </section>


        <!-- =========================================
             DESCRIPTION
        ========================================== -->

        <?php if (!empty($conteudo['descricao'])): ?>

            <section class="content-description">

                <h2>
                    Sobre este conteúdo
                </h2>

                <p>

                    <?= nl2br(
                        htmlspecialchars(
                            $conteudo['descricao']
                        )
                    ); ?>

                </p>

            </section>

        <?php endif; ?>
<!-- =========================================
     QUESTIONS
========================================= -->

<section class="questions-section">

    <h2 class="lessons-title">
        Questões
    </h2>

    <a
        href="questoes_conteudo.php?conteudo_id=<?= (int) $conteudo['id']; ?>"
        class="questions-button"
    >

        <span>
            <i class="fa-solid fa-circle-question"></i>
            Acessar questões deste conteúdo
        </span>

        <i class="fa-solid fa-arrow-right"></i>

    </a>

</section>



        <!-- =========================================
             LESSONS
        ========================================== -->

        <section>

            <h2 class="lessons-title">
                Aulas
            </h2>


            <?php if (!empty($aulas)): ?>


                <?php foreach ($aulas as$aula): ?>

                    <div class="lesson-card">

                        <a
                            href="aula.php?id=<?= (int) $aula['id']; ?>"
                            class="lesson-link"
                        >


                            <!-- Icon -->

                            <div class="lesson-icon">

                                <i
                                    class="fa-solid fa-play"
                                ></i>

                            </div>


                            <!-- Information -->

                            <div class="lesson-info">

                                <h3>

                                    <?= htmlspecialchars(
                                        $aula['titulo']
                                    ); ?>

                                </h3>


                                <?php if (
                                    !empty(
                                        $aula['descricao']
                                    )
                                ): ?>

                                    <p>

                                        <?= htmlspecialchars(
                                            $aula['descricao']
                                        ); ?>

                                    </p>

                                <?php else: ?>

                                    <p>
                                        Clique para acessar a aula.
                                    </p>

                                <?php endif; ?>

                            </div>


                        </a>

                    </div>

                <?php endforeach; ?>


            <?php else: ?>


                <!-- =========================================
                     EMPTY STATE
                ========================================== -->

                <div class="empty-lessons">

                    <i
                        class="fa-solid fa-book-open"
                    ></i>


                    <h3>
                        Nenhuma aula disponível
                    </h3>


                    <p>
                        As aulas deste conteúdo serão
                        disponibilizadas em breve.
                    </p>

                </div>


            <?php endif; ?>


        </section>


    </div>

</main>


<!-- =========================================
     FOOTER REUTILIZÁVEL DO SITE
========================================= -->

<?php include(__DIR__ . '/../includes/footer.php'); ?>
