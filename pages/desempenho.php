<?php

/* =========================================
   TECHMINDS EDUCATION
   MEU DESEMPENHO
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Progresso.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   DADOS DO ALUNO
========================================= */

$usuarioId = usuarioLogadoId();

$progressoModel = new Progresso();

$resumoGeral = $progressoModel->resumoGeral($usuarioId);

$resumoPorMateria = $progressoModel->resumoPorMateria($usuarioId);

$aulasConcluidas = $progressoModel->totalAulasConcluidas($usuarioId);

$aulasDisponiveis = $progressoModel->totalAulasDisponiveis();

$ultimasRespostas = $progressoModel->ultimasRespostas($usuarioId, 5);

$percentualGeral = calcularPercentual(
    $resumoGeral['total_corretas'],
    $resumoGeral['total_respondidas']
);

$percentualAulas = calcularPercentual(
    $aulasConcluidas,
    $aulasDisponiveis
);


/* =========================================
   PAGE TITLE
========================================= */

$title = "Meu Desempenho | " . NOME_SISTEMA;


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<style>

/* =========================================
   PÁGINA
========================================= */

.performance-page {

    background-color: #f1f1f1;

    min-height: 70vh;

    padding: 50px 20px 70px;

}


.performance-container {

    width: 100%;

    max-width: 1100px;

    margin: 0 auto;

}


/* =========================================
   BOAS-VINDAS
========================================= */

.performance-welcome {

    background-color: var(--green-main);

    color: #ffffff;

    border-radius: 20px;

    padding: 35px 40px;

    margin-bottom: 30px;

    box-shadow:
        0 7px 20px rgba(0, 0, 0, 0.10);

}


.performance-welcome small {

    display: block;

    color: #dce5c3;

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 7px;

}


.performance-welcome h1 {

    margin: 0 0 10px;

    color: #ffffff;

    font-size: 28px;

    font-weight: 700;

}


.performance-welcome p {

    margin: 0;

    color: rgba(255,255,255,0.88);

    font-size: 15px;

    line-height: 1.6;

}


/* =========================================
   CARDS DE RESUMO (TOPO)
========================================= */

.summary-grid {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;

    margin-bottom: 35px;

}


.summary-card {

    background-color: #ffffff;

    border-radius: 18px;

    padding: 25px;

    box-shadow:
        0 5px 16px rgba(0, 0, 0, 0.07);

    text-align: center;

}


.summary-card .icon {

    width: 50px;

    height: 50px;

    border-radius: 14px;

    background-color: #eef1e7;

    color: var(--green-main);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

    margin: 0 auto 15px;

}


.summary-card .value {

    color: var(--green-dark);

    font-size: 30px;

    font-weight: 700;

    line-height: 1.2;

}


.summary-card .label {

    color: #777;

    font-size: 13px;

    margin-top: 5px;

}


/* =========================================
   BARRA DE PROGRESSO
========================================= */

.progress-track {

    width: 100%;

    height: 10px;

    background-color: #eeeeee;

    border-radius: 10px;

    overflow: hidden;

    margin-top: 10px;

}


.progress-fill {

    height: 100%;

    background-color: var(--green-main);

    border-radius: 10px;

    transition: width 0.3s ease;

}


/* =========================================
   SEÇÃO
========================================= */

.performance-section-title {

    color: var(--green-dark);

    font-size: 21px;

    font-weight: 700;

    margin: 0 0 18px;

}


/* =========================================
   DESEMPENHO POR MATÉRIA
========================================= */

.subject-performance-card {

    background-color: #ffffff;

    border-radius: 16px;

    padding: 22px 25px;

    margin-bottom: 15px;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.07);

}


.subject-performance-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 10px;

}


.subject-performance-header h3 {

    color: var(--green-dark);

    font-size: 17px;

    font-weight: 700;

    margin: 0;

}


.subject-performance-header .percent {

    color: var(--green-main);

    font-weight: 700;

    font-size: 16px;

}


.subject-performance-meta {

    color: #777;

    font-size: 13px;

    margin-top: 8px;

}


/* =========================================
   EMPTY STATE
========================================= */

.empty-performance {

    background-color: #ffffff;

    border-radius: 16px;

    padding: 45px 25px;

    text-align: center;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.06);

    margin-bottom: 35px;

}


.empty-performance i {

    color: var(--green-main);

    font-size: 38px;

    margin-bottom: 15px;

}


.empty-performance h3 {

    color: var(--green-dark);

    font-size: 18px;

    font-weight: 700;

    margin-bottom: 8px;

}


.empty-performance p {

    color: #666;

    margin: 0;

}


/* =========================================
   HISTÓRICO
========================================= */

.history-list {

    background-color: #ffffff;

    border-radius: 16px;

    padding: 10px 25px;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.07);

}


.history-item {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 16px 0;

}


.history-item + .history-item {

    border-top: 1px solid #eeeeee;

}


.history-item-info {

    min-width: 0;

}


.history-item-subject {

    color: var(--green-main);

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.5px;

    margin-bottom: 4px;

}


.history-item-text {

    color: #444;

    font-size: 14px;

    line-height: 1.5;

    overflow: hidden;

    text-overflow: ellipsis;

    display: -webkit-box;

    -webkit-line-clamp: 1;

    -webkit-box-orient: vertical;

}


.history-badge {

    flex-shrink: 0;

    display: inline-flex;

    align-items: center;

    gap: 6px;

    font-size: 12px;

    font-weight: 700;

    padding: 5px 12px;

    border-radius: 20px;

}


.history-badge.acertou {

    background-color: #eaf5ea;

    color: #2e7d32;

}


.history-badge.errou {

    background-color: #fbeceb;

    color: #b3261e;

}


/* =========================================
   RESPONSIVIDADE
========================================= */

@media (max-width: 767px) {

    .performance-page {

        padding: 35px 15px 50px;

    }


    .performance-welcome {

        padding: 28px 24px;

    }


    .performance-welcome h1 {

        font-size: 23px;

    }


    .summary-grid {

        grid-template-columns: 1fr;

    }


    .subject-performance-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 5px;

    }


    .history-item {

        flex-direction: column;

        align-items: flex-start;

        gap: 8px;

    }

}

</style>


<!-- =========================================
     PÁGINA
========================================= -->

<main class="performance-page">

    <div class="performance-container">


        <!-- =====================================
             BOAS-VINDAS
        ====================================== -->

        <section class="performance-welcome">

            <small>
                MEU DESEMPENHO
            </small>

            <h1>
                Acompanhe sua evolução
            </h1>

            <p>
                Veja como você está indo nos exercícios e nas aulas
                da plataforma.
            </p>

        </section>


        <!-- =====================================
             RESUMO GERAL
        ====================================== -->

        <div class="summary-grid">

            <div class="summary-card">

                <div class="icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>

                <div class="value">
                    <?= $resumoGeral['total_respondidas']; ?>
                </div>

                <div class="label">
                    Questões respondidas
                </div>

            </div>


            <div class="summary-card">

                <div class="icon">
                    <i class="fa-solid fa-percent"></i>
                </div>

                <div class="value">
                    <?= $percentualGeral; ?>%
                </div>

                <div class="label">
                    Taxa de acerto geral
                </div>

            </div>


            <div class="summary-card">

                <div class="icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>

                <div class="value">
                    <?= $aulasConcluidas; ?>/<?= $aulasDisponiveis; ?>
                </div>

                <div class="label">
                    Aulas concluídas
                </div>

                <div class="progress-track">
                    <div
                        class="progress-fill"
                        style="width: <?= $percentualAulas; ?>%;"
                    ></div>
                </div>

            </div>

        </div>


        <!-- =====================================
             DESEMPENHO POR MATÉRIA
        ====================================== -->

        <h2 class="performance-section-title">
            Desempenho por matéria
        </h2>


        <?php if (!empty($resumoPorMateria)): ?>


            <?php foreach ($resumoPorMateria as $materia): ?>

                <?php
                    $percentualMateria = calcularPercentual(
                        (int) $materia['total_corretas'],
                        (int) $materia['total_respondidas']
                    );
                ?>

                <div class="subject-performance-card">

                    <div class="subject-performance-header">

                        <h3>
                            <?= htmlspecialchars($materia['nome']); ?>
                        </h3>

                        <span class="percent">
                            <?= $percentualMateria; ?>%
                        </span>

                    </div>

                    <div class="progress-track">
                        <div
                            class="progress-fill"
                            style="width: <?= $percentualMateria; ?>%;"
                        ></div>
                    </div>

                    <div class="subject-performance-meta">

                        <?= (int) $materia['total_corretas']; ?> de
                        <?= (int) $materia['total_respondidas']; ?> questões corretas

                    </div>

                </div>


            <?php endforeach; ?>


        <?php else: ?>


            <div class="empty-performance">

                <i class="fa-solid fa-chart-line"></i>

                <h3>
                    Você ainda não respondeu nenhum exercício
                </h3>

                <p>
                    Acesse a área de matérias e responda alguns exercícios
                    para ver seu desempenho aqui.
                </p>

            </div>


        <?php endif; ?>


        <!-- =====================================
             HISTÓRICO RECENTE
        ====================================== -->

        <h2 class="performance-section-title" style="margin-top: 35px;">
            Atividade recente
        </h2>


        <?php if (!empty($ultimasRespostas)): ?>


            <div class="history-list">

                <?php foreach ($ultimasRespostas as $resposta): ?>

                    <div class="history-item">

                        <div class="history-item-info">

                            <div class="history-item-subject">
                                <?= htmlspecialchars($resposta['materia']); ?>
                            </div>

                            <div class="history-item-text">
                                <?= htmlspecialchars(resumirTexto($resposta['enunciado'], 90)); ?>
                            </div>

                        </div>

                        <span class="history-badge <?= $resposta['correta'] ? 'acertou' : 'errou'; ?>">

                            <i class="fa-solid <?= $resposta['correta'] ? 'fa-check' : 'fa-xmark'; ?>"></i>

                            <?= $resposta['correta'] ? 'Acertou' : 'Errou'; ?>

                        </span>

                    </div>

                <?php endforeach; ?>

            </div>


        <?php else: ?>


            <div class="empty-performance">

                <i class="fa-solid fa-clock-rotate-left"></i>

                <h3>
                    Nenhuma atividade ainda
                </h3>

                <p>
                    Seu histórico de exercícios respondidos vai aparecer aqui.
                </p>

            </div>


        <?php endif; ?>


    </div>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>