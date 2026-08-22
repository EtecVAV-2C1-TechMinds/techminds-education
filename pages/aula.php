
<?php

/* =========================================
   TECHMINDS EDUCATION
   LESSON PAGE
========================================= */

session_start();

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Aula.php';


/* =========================================
   GET LESSON ID
========================================= */

$aulaId = (int) ($_GET['id'] ?? 0);

if ($aulaId <= 0) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   LOAD LESSON
========================================= */

$aulaModel = new Aula();

$aula = $aulaModel->buscarPorId($aulaId);

if (!$aula) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   LOAD OTHER LESSONS
========================================= */

$aulas = $aulaModel->listarPorConteudo(
    (int) $aula['conteudo_id']
);


/* =========================================
   PAGE TITLE
========================================= */

$title = htmlspecialchars(
    $aula['titulo']
) . " | TechMinds Education";


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<style>

/* =========================================
   FIX FOOTER
   O footer deve ficar depois do conteúdo,
   nunca sobre a página.
========================================= */

html,
body {
    min-height: 100%;
}

body {
    overflow-x: hidden;
}


/* =========================================
   LESSON PAGE
========================================= */

.lesson-page {

    background-color: #f1f1f1;

    width: 100%;

    padding: 45px 20px 80px;

}

/* =========================================
   CONTAINER
========================================= */

.lesson-container {

    max-width: 1000px;

    margin: 0 auto;

}


/* =========================================
   BACK LINK
========================================= */

.back-link {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: var(--green-dark);

    text-decoration: none;

    font-weight: 600;

    margin-bottom: 20px;

}

.back-link:hover {

    color: var(--green-main);

}


/* =========================================
   LESSON CARD
========================================= */

.lesson-content {

    background-color: white;

    border-radius: 18px;

    padding: 35px;

    box-shadow:
        0 5px 18px rgba(0,0,0,0.08);

}


/* =========================================
   SUBJECT
========================================= */

.lesson-subject {

    color: var(--green-main);

    font-size: 14px;

    font-weight: 700;

    margin-bottom: 5px;

}


/* =========================================
   CONTENT NAME
========================================= */

.lesson-content-name {

    color: #666;

    font-size: 14px;

    margin-bottom: 20px;

}


/* =========================================
   TITLE
========================================= */

.lesson-content h1 {

    color: var(--green-dark);

    font-size: 34px;

    font-weight: 700;

    margin-bottom: 20px;

}


/* =========================================
   DESCRIPTION
========================================= */

.lesson-description {

    color: #555;

    line-height: 1.7;

    margin-bottom: 30px;

}


/* =========================================
   VIDEO
========================================= */

.video-container {

    width: 100%;

    aspect-ratio: 16 / 9;

    background-color: #1c1c1c;

    border-radius: 15px;

    overflow: hidden;

    margin-bottom: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

}


.video-container video {

    width: 100%;

    height: 100%;

    object-fit: contain;

}


/* =========================================
   VIDEO PLACEHOLDER
========================================= */

.video-placeholder {

    text-align: center;

    color: white;

    padding: 30px;

}


.video-placeholder i {

    font-size: 45px;

    margin-bottom: 15px;

    opacity: 0.8;

}


.video-placeholder h3 {

    font-size: 20px;

    margin-bottom: 8px;

}


.video-placeholder p {

    margin: 0;

    opacity: 0.7;

    font-size: 14px;

}


/* =========================================
   MATERIAL
========================================= */

.material-box {

    background-color: #f5f5f5;

    border-radius: 12px;

    padding: 20px;

    margin-top: 25px;

}


.material-box h3 {

    color: var(--green-dark);

    font-size: 18px;

    font-weight: 700;

    margin-bottom: 10px;

}


.material-button {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background-color: var(--green-main);

    color: white;

    text-decoration: none;

    padding: 10px 18px;

    border-radius: 8px;

    font-weight: 600;

}


.material-button:hover {

    color: white;

    opacity: 0.9;

}


/* =========================================
   LESSON NAVIGATION
========================================= */

.lesson-navigation {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-top: 30px;

    padding-top: 25px;

    border-top: 1px solid #e5e5e5;

}


.lesson-navigation a {

    text-decoration: none;

    color: var(--green-dark);

    font-weight: 600;

}


.lesson-navigation a:hover {

    color: var(--green-main);

}


/* =========================================
   FOOTER FIX
========================================= */

/*
   Caso o CSS global esteja deixando o footer
   fixo/absoluto, esta página força o footer
   a voltar para o fluxo normal.
*/

footer {

    position: static !important;

    bottom: auto !important;

    left: auto !important;

    right: auto !important;

    width: 100% !important;

}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 575px) {

    .lesson-page {

        padding: 30px 15px 60px;

    }


    .lesson-content {

        padding: 25px 20px;

    }


    .lesson-content h1 {

        font-size: 27px;

    }


    .lesson-navigation {

        flex-direction: column;

        align-items: stretch;

    }


    .lesson-navigation a {

        display: flex;

        justify-content: center;

        padding: 10px;

        background-color: #f5f5f5;

        border-radius: 8px;

    }

}

</style>


<!-- =========================================
     LESSON PAGE
========================================= -->

<main class="lesson-page">

    <div class="lesson-container">


        <!-- =========================================
             BACK
        ========================================== -->

        <a
            href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Voltar para aulas

        </a>


        <!-- =========================================
             LESSON
        ========================================== -->

        <article class="lesson-content">


            <!-- SUBJECT -->

            <div class="lesson-subject">

                <?= htmlspecialchars(
                    $aula['conteudo']
                ); ?>

            </div>


            <!-- TITLE -->

            <h1>

                <?= htmlspecialchars(
                    $aula['titulo']
                ); ?>

            </h1>


            <!-- DESCRIPTION -->

            <?php if (!empty($aula['descricao'])): ?>

                <div class="lesson-description">

                    <?= nl2br(
                        htmlspecialchars(
                            $aula['descricao']
                        )
                    ); ?>

                </div>

            <?php endif; ?>


            <!-- =========================================
                 VIDEO
            ========================================== -->

            <div class="video-container">


                <?php if (!empty($aula['video'])): ?>

                    <video
                        controls
                        preload="metadata"
                    >

                        <source
                            src="<?= htmlspecialchars($aula['video']); ?>"
                        >

                        Seu navegador não suporta
                        reprodução de vídeo.

                    </video>


                <?php else: ?>


                    <div class="video-placeholder">

                        <i class="fa-solid fa-circle-play"></i>

                        <h3>

                            Vídeo da aula

                        </h3>

                        <p>

                            O vídeo desta aula será
                            disponibilizado em breve.

                        </p>

                    </div>


                <?php endif; ?>


            </div>


            <!-- =========================================
                 MATERIAL
            ========================================== -->

            <?php if (!empty($aula['material'])): ?>

                <div class="material-box">

                    <h3>

                        Material da aula

                    </h3>


                    <a
                        href="<?= htmlspecialchars($aula['material']); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="material-button"
                    >

                        <i class="fa-solid fa-file-arrow-down"></i>

                        Acessar material

                    </a>

                </div>

            <?php endif; ?>


            <!-- =========================================
                 LESSON NAVIGATION
            ========================================== -->

            <?php

            $indiceAtual = null;

            foreach ($aulas as $indice => $item) {

                if (
                    (int) $item['id']
                    === (int) $aula['id']
                ) {

                    $indiceAtual = $indice;

                    break;

                }

            }

            ?>


            <div class="lesson-navigation">


                <!-- PREVIOUS -->

                <?php if (
                    $indiceAtual !== null
                    && $indiceAtual > 0
                ): ?>

                    <?php
                    $anterior =
                        $aulas[$indiceAtual - 1];
                    ?>

                    <a
                        href="aula.php?id=<?= (int) $anterior['id']; ?>"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Aula anterior

                    </a>

                <?php else: ?>

                    <span></span>

                <?php endif; ?>


                <!-- NEXT -->

                <?php if (
                    $indiceAtual !== null
                    && $indiceAtual < count($aulas) - 1
                ): ?>

                    <?php
                    $proxima =
                        $aulas[$indiceAtual + 1];
                    ?>

                    <a
                        href="aula.php?id=<?= (int) $proxima['id']; ?>"
                    >

                        Próxima aula

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                <?php endif; ?>


            </div>


        </article>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>
