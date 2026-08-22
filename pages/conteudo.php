<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../models/Aula.php';
require_once __DIR__ . '/../includes/auth.php';

$title = "Conteúdo | TechMinds Education";

/* =========================================
   GET CONTENT ID
========================================= */

$conteudoId = (int) ($_GET['id'] ?? 0);


/* =========================================
   VALIDATE CONTENT ID
========================================= */

if ($conteudoId <= 0) {

    header('Location: materias.php');

    exit;
}


/* =========================================
   LOAD CONTENT
========================================= */

$conteudoModel = new Conteudo();

$conteudo = $conteudoModel->buscarPorId($conteudoId);


/* =========================================
   CHECK CONTENT
========================================= */

if (!$conteudo) {

    header('Location: materias.php');

    exit;
}


/* =========================================
   LOAD LESSONS
========================================= */

$aulaModel = new Aula();

$aulas = $aulaModel->listarPorConteudo($conteudoId);


/* =========================================
   PAGE TITLE
========================================= */

$title = htmlspecialchars(
    $conteudo['titulo']
) . " | TechMinds Education";


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>

<style>

/* =========================================
   CONTENT PAGE
========================================= */

.content-page {

    background-color: #f1f1f1;

    min-height: 70vh;

    padding: 45px 20px 70px;
}


/* =========================================
   CONTAINER
========================================= */

.content-container {

    max-width: 1000px;

    margin: 0 auto;
}


/* =========================================
   BACK BUTTON
========================================= */

.back-link {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: var(--green-dark);

    text-decoration: none;

    font-weight: 600;

    margin-bottom: 20px;

    transition: 0.2s;
}


.back-link:hover {

    color: var(--green-main);
}


/* =========================================
   CONTENT HEADER
========================================= */

.content-header {

    background-color: var(--green-main);

    color: white;

    padding: 35px 30px;

    border-radius: 18px;

    margin-bottom: 30px;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.08);
}


.content-header .subject-name {

    font-size: 14px;

    font-weight: 600;

    opacity: 0.85;

    margin-bottom: 8px;

    text-transform: uppercase;

    letter-spacing: 0.5px;
}


.content-header h1 {

    font-size: 32px;

    font-weight: 700;

    margin: 0 0 12px;
}


.content-header p {

    font-size: 15px;

    margin: 0;

    opacity: 0.95;

    line-height: 1.6;
}


/* =========================================
   LESSONS TITLE
========================================= */

.lessons-title {

    color: var(--green-dark);

    font-size: 24px;

    font-weight: 700;

    margin-bottom: 18px;
}


/* =========================================
   LESSON CARD
========================================= */

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

    justify-content: space-between;

    gap: 20px;

    color: white;

    text-decoration: none;
}


.lesson-info {

    display: flex;

    align-items: center;

    gap: 15px;
}


.lesson-icon {

    width: 45px;

    height: 45px;

    border-radius: 50%;

    background-color: rgba(255,255,255,0.20);

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;
}


.lesson-icon i {

    color: white;

    font-size: 18px;
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

    line-height: 1.5;
}


.lesson-arrow {

    color: white;

    font-size: 18px;

    flex-shrink: 0;
}


/* =========================================
   EMPTY LESSONS
========================================= */

.empty-lessons {

    background-color: white;

    border-radius: 15px;

    padding: 45px 25px;

    text-align: center;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.06);
}


.empty-lessons i {

    font-size: 38px;

    color: var(--green-main);

    margin-bottom: 15px;
}


.empty-lessons h3 {

    color: var(--green-dark);

    font-size: 20px;

    font-weight: 700;

    margin-bottom: 8px;
}


.empty-lessons p {

    color: #666;

    margin-bottom: 20px;
}


/* =========================================
   QUESTIONS BUTTON
========================================= */

.questions-button {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background-color: var(--green-main);

    color: white;

    text-decoration: none;

    padding: 10px 20px;

    border-radius: 25px;

    font-weight: 600;

    transition: 0.2s;
}


.questions-button:hover {

    background-color: var(--green-dark);

    color: white;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 767px) {

    .content-page {

        padding: 30px 15px 50px;
    }


    .content-header {

        padding: 30px 22px;
    }


    .content-header h1 {

        font-size: 26px;
    }


    .lesson-link {

        gap: 12px;
    }


    .lesson-info h3 {

        font-size: 16px;
    }


    .lesson-info p {

        font-size: 12px;
    }

}

</style>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="content-page">

    <div class="content-container">


        <!-- =========================================
             BACK
        ========================================== -->

        <a
            href="conteudos.php?materia_id=<?= (int) $conteudo['materia_id']; ?>"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Voltar para conteúdos

        </a>


        <!-- =========================================
             CONTENT HEADER
        ========================================== -->

        <section class="content-header">

            <div class="subject-name">

                <?= htmlspecialchars(
                    $conteudo['materia']
                ); ?>

            </div>


            <h1>

                <?= htmlspecialchars(
                    $conteudo['titulo']
                ); ?>

            </h1>


            <?php if (!empty($conteudo['descricao'])): ?>

                <p>

                    <?= htmlspecialchars(
                        $conteudo['descricao']
                    ); ?>

                </p>

            <?php else: ?>

                <p>

                    Acesse as aulas e materiais deste conteúdo.

                </p>

            <?php endif; ?>

        </section>


        <!-- =========================================
             LESSONS
        ========================================== -->

        <h2 class="lessons-title">

            Aulas

        </h2>


        <?php if (!empty($aulas)): ?>


            <?php foreach ($aulas as $aula): ?>


                <div class="lesson-card">

                    <a
                        href="aula.php?id=<?= (int) $aula['id']; ?>"
                        class="lesson-link"
                    >


                        <div class="lesson-info">


                            <div class="lesson-icon">

                                <i class="fa-solid fa-play"></i>

                            </div>


                            <div>

                                <h3>

                                    <?= htmlspecialchars(
                                        $aula['titulo']
                                    ); ?>

                                </h3>


                                <?php if (!empty($aula['descricao'])): ?>

                                    <p>

                                        <?= htmlspecialchars(
                                            $aula['descricao']
                                        ); ?>

                                    </p>

                                <?php else: ?>

                                    <p>

                                        Clique para acessar esta aula.

                                    </p>

                                <?php endif; ?>

                            </div>


                        </div>


                        <i
                            class="fa-solid fa-arrow-right lesson-arrow"
                        ></i>


                    </a>

                </div>


            <?php endforeach; ?>


        <?php else: ?>


            <!-- =========================================
                 NO LESSONS
            ========================================== -->

            <div class="empty-lessons">


                <i class="fa-solid fa-book-open"></i>


                <h3>

                    Aulas em preparação

                </h3>


                <p>

                    As aulas deste conteúdo serão disponibilizadas
                    em breve.

                </p>


                <a
                    href="questoes_conteudo.php?conteudo_id=<?= (int) $conteudoId; ?>"
                    class="questions-button"
                >

                    <i class="fa-solid fa-list-check"></i>

                    Ver questões

                </a>


            </div>


        <?php endif; ?>


    </div>

</main>


<?php

/* =========================================
   FOOTER
========================================= */

include(__DIR__ . '/../includes/footer.php');

?>
