<?php

/* =========================================
   TECHMINDS EDUCATION
   QUESTIONS - ANSWER PAGE
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Conteudo.php';
require_once __DIR__ . '/../models/Questao.php';
require_once __DIR__ . '/../models/Progresso.php';
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

$questaoModel = new Questao();
$questoes = $questaoModel->listarPorConteudo($conteudoId);

/* =========================================
   PROCESS ANSWERS (CORREÇÃO + SALVAR)
========================================= */

$corrigido = false;
$respostasEnviadas = [];
$acertos = 0;

$usuarioId = (int) ($_SESSION[SESSION_USUARIO] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respostas'])) {
    $respostasEnviadas = $_POST['respostas'];
    $corrigido = true;

    $progressoModel = new Progresso();

    foreach ($questoes as $questao) {
        $letraEscolhida = $respostasEnviadas[$questao['id']] ?? null;

        if ($letraEscolhida === null) {
            continue;
        }

        $acertou = strtoupper($letraEscolhida) === strtoupper($questao['resposta_correta']);

        if ($acertou) {
            $acertos++;
        }

        if ($usuarioId > 0) {
            $progressoModel->salvarResposta(
                $usuarioId,
                (int) $questao['id'],
                strtoupper($letraEscolhida),
                $acertou
            );
        }
    }
}

/* =========================================
   PAGE TITLE
========================================= */

$title = "Exercícios | " . NOME_SISTEMA;

/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>
    .breadcrumb-item a {
        color: #6B783E !important;
    }

    .breadcrumb-item a:hover {
        color: #233703 !important;
        text-decoration: underline !important;
    }

    .questao-alternativa {
        display: block;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: 0.15s;
    }

    .questao-alternativa:hover {
        border-color: #6B783E;
        background-color: #f8f9fa;
    }

    .questao-alternativa input[type="radio"] {
        margin-right: 10px;
    }

    .questao-alternativa.correta {
        border-color: #2e7d32;
        background-color: #eaf5ea;
    }

    .questao-alternativa.incorreta {
        border-color: #b3261e;
        background-color: #fbeceb;
    }

    .resultado-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 14px;
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 10px;
    }

    .resultado-badge.acertou {
        background-color: #eaf5ea;
        color: #2e7d32;
    }

    .resultado-badge.errou {
        background-color: #fbeceb;
        color: #b3261e;
    }

    .resumo-final {
        background-color: #6B783E;
        color: white;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        margin-bottom: 30px;
    }

    .resumo-final h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .resumo-final p {
        margin: 0;
        opacity: 0.9;
    }
</style>

<!-- =========================================
     QUESTIONS PAGE
========================================= -->

<main class="py-5" style="background-color: #f1f1f1; min-height: 650px;">

    <div class="container">

        <!-- =========================================
             BREADCRUMB
        ========================================== -->

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../index.php" class="text-decoration-none fw-semibold">
                        Início
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="questoes.php" class="text-decoration-none fw-semibold">
                        Questões
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="questoes_materia.php?materia_id=<?= (int) $conteudo['materia_id']; ?>" class="text-decoration-none fw-semibold">
                        <?= htmlspecialchars($conteudo['materia']); ?>
                    </a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($conteudo['titulo']); ?>
                </li>
            </ol>
        </nav>

        <!-- =========================================
             HEADER
        ========================================== -->

        <section class="rounded-4 shadow-sm p-4 p-md-5 mb-5 text-white" style="background-color: #6B783E;">
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
             RESULT SUMMARY (SE JÁ CORRIGIDO)
        ========================================== -->

        <?php if ($corrigido): ?>
            <div class="resumo-final">
                <h2><?= $acertos; ?> de <?= count($questoes); ?></h2>
                <p>questões corretas</p>
            </div>
        <?php endif; ?>

        <!-- =========================================
             QUESTIONS
        ========================================== -->

        <?php if (!empty($questoes)): ?>

            <form method="POST">
                <div class="row justify-content-center">
                    <div class="col-lg-9">

                        <?php foreach ($questoes as $indice => $questao): ?>

                            <?php
                                $respostaAluno = $respostasEnviadas[$questao['id']] ?? null;
                                $acertouEssa = $corrigido && $respostaAluno !== null
                                    && strtoupper($respostaAluno) === strtoupper($questao['resposta_correta']);
                            ?>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4 p-md-5">

                                    <!-- QUESTION NUMBER -->
                                    <div class="mb-3 fw-bold" style="color: #6B783E;">
                                        Questão <?= $indice + 1; ?>
                                    </div>

                                    <!-- RESULT BADGE -->
                                    <?php if ($corrigido): ?>
                                        <div class="resultado-badge <?= $acertouEssa ? 'acertou' : 'errou'; ?>">
                                            <i class="fa-solid <?= $acertouEssa ? 'fa-check' : 'fa-xmark'; ?>"></i>
                                            <?= $acertouEssa ? 'Você acertou' : 'Você errou'; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- STATEMENT -->
                                    <p class="fw-semibold mb-4" style="color: #233703; font-size: 17px;">
                                        <?= nl2br(htmlspecialchars($questao['enunciado'])); ?>
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

                                            <?php if ($texto !== null && trim($texto) !== ''): ?>

                                                <?php
                                                    $classeExtra = '';

                                                    if ($corrigido) {
                                                        if (strtoupper($letra) === strtoupper($questao['resposta_correta'])) {
                                                            $classeExtra = 'correta';
                                                        } elseif ($letra === $respostaAluno) {
                                                            $classeExtra = 'incorreta';
                                                        }
                                                    }
                                                ?>

                                                <label class="questao-alternativa <?= $classeExtra; ?>">
                                                    <input
                                                        type="radio"
                                                        name="respostas[<?= (int) $questao['id']; ?>]"
                                                        value="<?= $letra; ?>"
                                                        <?= $letra === $respostaAluno ? 'checked' : ''; ?>
                                                        <?= $corrigido ? 'disabled' : ''; ?>
                                                    >

                                                    <strong class="me-2" style="color: #6B783E;">
                                                        <?= $letra ?>)
                                                    </strong>

                                                    <?= nl2br(htmlspecialchars($texto)); ?>
                                                </label>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </div>

                                </div>
                            </div>

                        <?php endforeach; ?>

                        <?php if (!$corrigido): ?>

                            <button
                                type="submit"
                                class="btn text-white w-100 py-3 fw-bold mb-5"
                                style="background-color: #6B783E; border-radius: 25px;"
                            >
                                Corrigir respostas
                            </button>

                        <?php else: ?>

                            <a
                                href="questoes_conteudo.php?conteudo_id=<?= (int) $conteudoId; ?>"
                                class="btn w-100 py-3 fw-bold mb-5"
                                style="background-color: #e0e0e0; color: #333; border-radius: 25px;"
                            >
                                Tentar novamente
                            </a>

                        <?php endif; ?>

                    </div>
                </div>
            </form>

        <?php else: ?>

            <!-- =========================================
                 EMPTY QUESTIONS
            ========================================== -->

            <div class="card border-0 shadow-sm text-center p-5">

                <div class="mb-3" style="font-size: 50px; color: #6B783E;">
                    <i class="fa-solid fa-circle-question"></i>
                </div>

                <h2 class="h4 fw-bold">
                    Nenhum exercício disponível
                </h2>

                <p class="text-secondary mb-4">
                    Ainda não existem questões cadastradas para este conteúdo.
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

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento do código
Finalidade: Auxílio na organização da estrutura CSS.
Validação: Código analisado, ajustado conforme preferência e testado pelas alunas.
*/
?>
