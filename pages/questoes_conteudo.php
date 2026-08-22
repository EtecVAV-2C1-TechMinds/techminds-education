<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../models/Questao.php';
require_once __DIR__ . '/../includes/auth.php';
/* =========================================
   GET CONTENT ID
========================================= */

$conteudoId = (int) ($_GET['conteudo_id'] ?? 0);


if ($conteudoId <= 0) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   GET CONTENT
========================================= */

$conteudoModel = new Conteudo();

$conteudo = $conteudoModel->buscarPorId($conteudoId);


if (!$conteudo || (int) $conteudo['ativo'] !== 1) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   GET QUESTIONS
========================================= */

$questaoModel = new Questao($pdo);

$questoes = $questaoModel->listarPorConteudo($conteudoId);


/* =========================================
   PAGE TITLE
========================================= */

$title = "Exercícios | TechMinds Education";


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<!-- =========================================
     QUESTIONS PAGE
========================================= -->

<main
    class="py-5"
    style="
        background-color: #f1f1f1;
        min-height: 650px;
    "
>


    <div class="container">


        <!-- =========================================
             BREADCRUMB
        ========================================== -->

        <nav
            aria-label="breadcrumb"
            class="mb-4"
        >

            <ol class="breadcrumb">


                <li class="breadcrumb-item">

                    <a
                        href="../index.php"
                        class="text-decoration-none"
                    >

                        Início

                    </a>

                </li>


                <li class="breadcrumb-item">

                    <a
                        href="materias.php"
                        class="text-decoration-none"
                    >

                        Matérias

                    </a>

                </li>


                <li class="breadcrumb-item">

                    <a
                        href="conteudos.php?materia_id=<?= (int) $conteudo['materia_id']; ?>"
                        class="text-decoration-none"
                    >

                        <?= htmlspecialchars($conteudo['materia']); ?>

                    </a>

                </li>


                <li class="breadcrumb-item">

                    <a
                        href="conteudo.php?id=<?= (int) $conteudo['id']; ?>"
                        class="text-decoration-none"
                    >

                        <?= htmlspecialchars($conteudo['titulo']); ?>

                    </a>

                </li>


                <li
                    class="breadcrumb-item active"
                    aria-current="page"
                >

                    Exercícios

                </li>


            </ol>

        </nav>


        <!-- =========================================
             HEADER
        ========================================== -->

        <section
            class="rounded-4 shadow-sm p-4 p-md-5 mb-5 text-white"
            style="background-color: #6B783E;"
        >

            <span class="badge bg-light text-dark mb-3">

                <?= htmlspecialchars($conteudo['materia']); ?>

            </span>


            <h1 class="fw-bold mb-2">

                Exercícios

            </h1>


            <p class="mb-0">

                <?= htmlspecialchars($conteudo['titulo']); ?>

            </p>

        </section>


        <!-- =========================================
             QUESTIONS
        ========================================== -->

        <?php if (!empty($questoes)): ?>


            <div class="row justify-content-center">


                <div class="col-lg-9">


                    <?php foreach ($questoes as $indice => $questao): ?>


                        <div
                            class="card border-0 shadow-sm mb-4"
                        >

                            <div class="card-body p-4 p-md-5">


                                <!-- QUESTION NUMBER -->

                                <div
                                    class="mb-3 fw-bold"
                                    style="color: #6B783E;"
                                >

                                    Questão <?= $indice + 1; ?>

                                </div>


                                <!-- STATEMENT -->

                                <p
                                    class="fw-semibold mb-4"
                                    style="
                                        color: #233703;
                                        font-size: 17px;
                                    "
                                >

                                    <?= nl2br(
                                        htmlspecialchars(
                                            $questao['enunciado']
                                        )
                                    ); ?>

                                </p>


                                <!-- ALTERNATIVES -->

                                <div class="d-flex flex-column gap-2">


                                    <?php
                                    $alternativas = [
                                        'A' => $questao['alternativa_a'],
                                        'B' => $questao['alternativa_b'],
                                        'C' => $questao['alternativa_c'],
                                        'D' => $questao['alternativa_d'],
                                        'E' => $questao['alternativa_e']
                                    ];
                                    ?>


                                    <?php foreach ($alternativas as $letra => $texto): ?>


                                        <?php if (
                                            $texto !== null &&
                                            trim($texto) !== ''
                                        ): ?>


                                            <div
                                                class="border rounded-3 p-3"
                                                style="
                                                    background-color: #f8f9fa;
                                                "
                                            >

                                                <strong
                                                    class="me-2"
                                                    style="color: #6B783E;"
                                                >

                                                    <?= $letra ?>)

                                                </strong>


                                                <?= nl2br(
                                                    htmlspecialchars($texto)
                                                ); ?>

                                            </div>


                                        <?php endif; ?>


                                    <?php endforeach; ?>


                                </div>


                            </div>

                        </div>


                    <?php endforeach; ?>


                </div>


            </div>


        <?php else: ?>


            <!-- =========================================
                 EMPTY QUESTIONS
            ========================================== -->

            <div
                class="card border-0 shadow-sm text-center p-5"
            >


                <div
                    class="mb-3"
                    style="
                        font-size: 50px;
                        color: #6B783E;
                    "
                >

                    <i class="fa-solid fa-circle-question"></i>

                </div>


                <h2 class="h4 fw-bold">

                    Nenhum exercício disponível

                </h2>


                <p class="text-secondary mb-4">

                    Ainda não existem questões cadastradas
                    para este conteúdo.

                </p>


                <a
                    href="conteudo.php?id=<?= (int) $conteudo['id']; ?>"
                    class="btn text-white"
                    style="background-color: #6B783E;"
                >

                    <i class="fa-solid fa-arrow-left me-2"></i>

                    Voltar para o conteúdo

                </a>


            </div>


        <?php endif; ?>


    </div>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>
