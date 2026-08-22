<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../includes/auth.php';

$title = "Conteúdos | TechMinds Education";

$materiaId = (int) ($_GET['materia_id'] ?? 0);


if ($materiaId <= 0) {

    header('Location: materias.php');

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


$materia = $stmtMateria->fetch(
    PDO::FETCH_ASSOC
);


/* =========================================
   SUBJECT NOT FOUND
========================================= */

if (!$materia) {

    header('Location: materias.php');

    exit;
}


/* =========================================
   LOAD CONTENTS
========================================= */

$conteudoModel = new Conteudo();


$conteudos =
    $conteudoModel->listarPorMateria(
        $materiaId
    );


/* =========================================
   PAGE CONFIGURATION
========================================= */

$title =
    $materia['nome']
    . " | Conteúdos | TechMinds Education";


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');


/* =========================================
   BANNER
========================================= */

$bannerTitulo =
    $materia['nome'];


$bannerSubtitulo =
    "Conteúdos disponíveis para esta matéria.";


include(__DIR__ . '/../includes/banner.php');

?>


<style>

    /* =========================================
       PAGE
    ========================================== */

    .contents-page {

        background-color: #f1f1f1;

        min-height: 70vh;

        padding: 45px 20px 80px;

    }


    .contents-container {

        max-width: 1000px;

        margin: 0 auto;

    }


    /* =========================================
       BACK LINK
    ========================================== */

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


    /* =========================================
       INTRODUCTION
    ========================================== */

    .contents-intro {

        margin-bottom: 30px;

    }


    .contents-intro h1 {

        color: var(--green-dark);

        font-size: 28px;

        font-weight: 700;

        margin-bottom: 8px;

    }


    .contents-intro p {

        color: #666;

        margin: 0;

        line-height: 1.6;

    }


    /* =========================================
       CONTENT CARD
    ========================================== */

    .content-card {

        background-color: white;

        border-radius: 16px;

        padding: 22px 25px;

        margin-bottom: 15px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.07);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;

    }


    .content-card:hover {

        transform: translateY(-2px);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.11);

    }


    .content-link {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        color: inherit;

        text-decoration: none;

    }


    .content-info {

        display: flex;

        align-items: center;

        gap: 15px;

        min-width: 0;

    }


    /* =========================================
       ICON
    ========================================== */

    .content-icon {

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


    .content-icon i {

        font-size: 18px;

    }


    /* =========================================
       TEXT
    ========================================== */

    .content-info h2 {

        color: var(--green-dark);

        font-size: 19px;

        font-weight: 700;

        margin: 0 0 5px;

    }


    .content-info p {

        color: #666;

        font-size: 14px;

        margin: 0;

        line-height: 1.5;

    }


    /* =========================================
       ARROW
    ========================================== */

    .content-arrow {

        color: var(--green-main);

        font-size: 18px;

        flex-shrink: 0;

    }


    /* =========================================
       EMPTY STATE
    ========================================== */

    .empty-contents {

        background-color: white;

        border-radius: 16px;

        padding: 50px 25px;

        text-align: center;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.06);

    }


    .empty-contents i {

        color: var(--green-main);

        font-size: 40px;

        margin-bottom: 15px;

    }


    .empty-contents h2 {

        color: var(--green-dark);

        font-size: 21px;

        font-weight: 700;

        margin-bottom: 8px;

    }


    .empty-contents p {

        color: #666;

        margin: 0;

    }


    /* =========================================
       MOBILE
    ========================================== */

    @media (max-width: 575px) {

        .contents-page {

            padding:
                35px 15px 60px;

        }


        .contents-intro h1 {

            font-size: 24px;

        }


        .content-card {

            padding: 18px;

        }


        .content-link {

            gap: 10px;

        }


        .content-info {

            gap: 10px;

        }


        .content-icon {

            width: 42px;

            height: 42px;

        }


        .content-info h2 {

            font-size: 17px;

        }


        .content-info p {

            font-size: 13px;

        }

    }

</style>


<main class="contents-page">

    <div class="contents-container">


        <!-- =========================================
             BACK
        ========================================== -->

        <a
            href="materias.php"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Voltar para matérias

        </a>


        <!-- =========================================
             PAGE INTRO
        ========================================== -->

        <div class="contents-intro">

            <h1>

                Conteúdos de
                <?= htmlspecialchars(
                    $materia['nome']
                ); ?>

            </h1>


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

                    Escolha um conteúdo para
                    continuar seus estudos.

                </p>

            <?php endif; ?>

        </div>


        <!-- =========================================
             CONTENTS LIST
        ========================================== -->

        <?php if (!empty($conteudos)): ?>


            <?php foreach (
                $conteudos as $conteudo
            ): ?>


                <article class="content-card">


                    <a
                        href="conteudo.php?id=<?= (int) $conteudo['id']; ?>"
                        class="content-link"
                    >


                        <div class="content-info">


                            <div class="content-icon">

                                <i
                                    class="fa-solid fa-book-open"
                                ></i>

                            </div>


                            <div>


                                <h2>

                                    <?= htmlspecialchars(
                                        $conteudo['titulo']
                                    ); ?>

                                </h2>


                                <?php if (
                                    !empty(
                                        $conteudo['descricao']
                                    )
                                ): ?>

                                    <p>

                                        <?= htmlspecialchars(
                                            $conteudo['descricao']
                                        ); ?>

                                    </p>

                                <?php else: ?>

                                    <p>

                                        Acesse este conteúdo
                                        para visualizar as aulas.

                                    </p>

                                <?php endif; ?>


                            </div>


                        </div>


                        <i
                            class="
                                fa-solid
                                fa-arrow-right
                                content-arrow
                            "
                        ></i>


                    </a>


                </article>


            <?php endforeach; ?>


        <?php else: ?>


            <!-- =========================================
                 EMPTY STATE
            ========================================== -->

            <div class="empty-contents">


                <i
                    class="fa-solid fa-book-open"
                ></i>


                <h2>

                    Nenhum conteúdo disponível

                </h2>


                <p>

                    Ainda não existem conteúdos
                    cadastrados para esta matéria.

                </p>


            </div>


        <?php endif; ?>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>
