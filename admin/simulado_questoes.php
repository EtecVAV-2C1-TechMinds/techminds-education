<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - QUESTÕES DE UM SIMULADO
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';
require_once __DIR__ . '/../models/Questao.php';

$simuladoId = (int) ($_GET['id'] ?? 0);

if ($simuladoId <= 0) {
    redirecionar('admin/simulados.php');
}

$simuladoModel = new Simulado();
$simulado = $simuladoModel->buscarPorId($simuladoId);

if (!$simulado) {
    redirecionar('admin/simulados.php');
}

$questoesNoSimulado = $simuladoModel->listarQuestoes($simuladoId);

$questaoModel = new Questao();
$todasQuestoes = $questaoModel->listar();

/* Ids já usados, pra não oferecer de novo no dropdown */
$idsUsados = array_column($questoesNoSimulado, 'id');

$title = "Questões do Simulado | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilo para fixar o footer no rodapé -->
<style>
    html {
        height: 100%;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        margin: 0;
    }

    /* O main se expande para ocupar o espaço vago e empurrar o footer */
    main.main-content {
        flex: 1 0 auto;
    }
</style>

<section class="py-5" style="background-color: var(--green-main); color: white;">
    <div class="container text-center">
        <h1 class="fw-bold"><?= htmlspecialchars($simulado['titulo']); ?></h1>
        <p class="mb-0">Gerenciar questões do simulado</p>
    </div>
</section>

<main class="container py-5 main-content">

    <a href="simulados.php" class="btn btn-outline-secondary mb-4">
        <i class="fa-solid fa-arrow-left me-2"></i> Voltar para simulados
    </a>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['sucesso']) {
                case 'adicionada': echo 'Questão adicionada ao simulado.'; break;
                case 'removida': echo 'Questão removida do simulado.'; break;
                default: echo 'Operação realizada com sucesso.';
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger">
            <?php
            switch ($_GET['erro']) {
                case 'duplicada': echo 'Essa questão já está neste simulado.'; break;
                case 'preencha': echo 'Selecione uma questão para adicionar.'; break;
                default: echo 'Não foi possível realizar a operação.';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">

            <h2 class="fw-bold mb-3">Adicionar questão</h2>

            <form method="POST" action="../controllers/SimuladoController.php?acao=adicionar_questao" class="d-flex gap-2 flex-wrap">

                <input type="hidden" name="simulado_id" value="<?= (int) $simuladoId; ?>">

                <select name="questao_id" class="form-select" style="max-width: 500px;" required>
                    <option value="">Selecione uma questão</option>

                    <?php foreach ($todasQuestoes as $questao): ?>

                        <?php if (!in_array($questao['id'], $idsUsados)): ?>

                            <option value="<?= (int) $questao['id']; ?>">
                                #<?= $questao['id']; ?> —
                                <?= htmlspecialchars(resumirTexto($questao['enunciado'], 70)); ?>
                            </option>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>

                <button type="submit" class="btn btn-tech">Adicionar</button>

            </form>

        </div>
    </div>

    <h2 class="fw-bold mb-4">
        Questões neste simulado
        (<?= count($questoesNoSimulado); ?>)
    </h2>

    <?php if (!empty($questoesNoSimulado)): ?>

        <div class="row g-3">

            <?php foreach ($questoesNoSimulado as $indice => $questao): ?>

                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center gap-3">

                            <div>
                                <strong>Questão <?= $indice + 1; ?></strong> —
                                <?= htmlspecialchars(resumirTexto($questao['enunciado'], 100)); ?>
                            </div>

                            <a
                                href="../controllers/SimuladoController.php?acao=remover_questao&simulado_id=<?= (int) $simuladoId; ?>&questao_id=<?= (int) $questao['id']; ?>"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Remover esta questão do simulado?');"
                            >
                                Remover
                            </a>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="card border-0 shadow-sm text-center p-5">
            <p class="text-muted mb-0">Nenhuma questão adicionada a este simulado ainda.</p>
        </div>

    <?php endif; ?>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>