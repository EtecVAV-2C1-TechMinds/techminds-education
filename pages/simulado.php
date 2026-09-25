<?php

/* =========================================
   TECHMINDS EDUCATION
   SIMULADO - REALIZAÇÃO
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Simulado.php';
require_once __DIR__ . '/../models/Progresso.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   GET SIMULADO ID
========================================= */

$simuladoId = (int) ($_GET['id'] ?? 0);

if ($simuladoId <= 0) {
    redirecionar('pages/simulados.php');
}


/* =========================================
   LOAD SIMULADO
========================================= */

$simuladoModel = new Simulado();

$simulado = $simuladoModel->buscarPorId($simuladoId);

if (!$simulado || (int) $simulado['ativo'] !== 1) {
    redirecionar('pages/simulados.php');
}

$questoes = $simuladoModel->listarQuestoes($simuladoId);


/* =========================================
   PROCESS ANSWERS (CORREÇÃO + SALVAR)
========================================= */

$corrigido = false;
$respostasEnviadas = [];
$acertos = 0;

$usuarioId = usuarioLogadoId();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respostas'])) {

    $respostasEnviadas = $_POST['respostas'];
    $corrigido = true;

    foreach ($questoes as $questao) {

        $letraEscolhida = $respostasEnviadas[$questao['id']] ?? null;

        if (
            $letraEscolhida !== null &&
            strtoupper($letraEscolhida) === strtoupper($questao['resposta_correta'])
        ) {
            $acertos++;
        }

    }

    if ($usuarioId > 0) {

        $progressoModel = new Progresso();

        $progressoModel->salvarResultadoSimulado(
            $usuarioId,
            $simuladoId,
            count($questoes),
            $acertos
        );

    }

}


/* =========================================
   PAGE TITLE
========================================= */

$title = htmlspecialchars($simulado['titulo']) . " | " . NOME_SISTEMA;


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>


<style>

    .simulado-page {
        background-color: #f1f1f1;
        min-height: 650px;
        padding: 45px 20px 70px;
    }

    .simulado-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .simulado-header {
        background-color: var(--green-main);
        color: white;
        border-radius: 18px;
        padding: 30px 35px;
        margin-bottom: 25px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .simulado-header h1 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .timer-box {
        background-color: rgba(255,255,255,0.18);
        border-radius: 12px;
        padding: 10px 20px;
        text-align: center;
        min-width: 100px;
    }

    .timer-box .timer-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.85;
    }

    .timer-box .timer-value {
        font-size: 22px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    .timer-box.tempo-critico {
        background-color: rgba(179, 38, 30, 0.85);
    }

    .resumo-final {
        background-color: white;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
    }

    .resumo-final h2 {
        color: var(--green-dark);
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .resumo-final p {
        color: #666;
        margin: 0;
    }

    .questao-card {
        background-color: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
    }

    .questao-numero {
        color: var(--green-main);
        font-weight: 700;
        margin-bottom: 12px;
    }

    .questao-enunciado {
        color: var(--green-dark);
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        line-height: 1.6;
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
        border-color: var(--green-main);
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
        font-size: 13px;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .resultado-badge.acertou {
        background-color: #eaf5ea;
        color: #2e7d32;
    }

    .resultado-badge.errou {
        background-color: #fbeceb;
        color: #b3261e;
    }

    .btn-corrigir,
    .btn-refazer {
        display: block;
        width: 100%;
        text-align: center;
        padding: 15px;
        border-radius: 25px;
        font-weight: 700;
        border: none;
        text-decoration: none;
        margin-bottom: 40px;
        cursor: pointer;
    }

    .btn-corrigir {
        background-color: var(--green-main);
        color: white;
    }

    .btn-refazer {
        background-color: #e0e0e0;
        color: #333;
    }

    @media (max-width: 575px) {

        .simulado-page {
            padding: 30px 15px 50px;
        }

        .simulado-header {
            flex-direction: column;
            text-align: center;
        }

        .questao-card {
            padding: 22px;
        }

    }

</style>


<main class="simulado-page">

    <div class="simulado-container">

        <div class="simulado-header">

            <h1>
                <?= htmlspecialchars($simulado['titulo']); ?>
            </h1>

            <?php if (!$corrigido && !empty($simulado['tempo_minutos'])): ?>

                <div class="timer-box" id="timerBox">
                    <div class="timer-label">Tempo restante</div>
                    <div class="timer-value" id="timerValue">--:--</div>
                </div>

            <?php endif; ?>

        </div>


        <?php if ($corrigido): ?>

            <div class="resumo-final">

                <h2><?= $acertos; ?> de <?= count($questoes); ?></h2>

                <p>
                    questões corretas
                    (<?= calcularPercentual($acertos, count($questoes)); ?>% de aproveitamento)
                </p>

            </div>

        <?php endif; ?>


        <?php if (!empty($questoes)): ?>


            <form method="POST" id="formSimulado">

                <?php foreach ($questoes as $indice => $questao): ?>

                    <?php
                        $respostaAluno = $respostasEnviadas[$questao['id']] ?? null;
                        $acertouEssa = $corrigido && $respostaAluno !== null
                            && strtoupper($respostaAluno) === strtoupper($questao['resposta_correta']);
                    ?>

                    <div class="questao-card">

                        <div class="questao-numero">
                            Questão <?= $indice + 1; ?> de <?= count($questoes); ?>
                        </div>

                        <?php if ($corrigido): ?>

                            <div class="resultado-badge <?= $acertouEssa ? 'acertou' : 'errou'; ?>">
                                <i class="fa-solid <?= $acertouEssa ? 'fa-check' : 'fa-xmark'; ?>"></i>
                                <?= $acertouEssa ? 'Você acertou' : 'Você errou'; ?>
                            </div>

                        <?php endif; ?>

                        <p class="questao-enunciado">
                            <?= nl2br(htmlspecialchars($questao['enunciado'])); ?>
                        </p>

                        <div>

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

                                        <strong><?= $letra; ?>)</strong>
                                        <?= nl2br(htmlspecialchars($texto)); ?>

                                    </label>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endforeach; ?>


                <?php if (!$corrigido): ?>

                    <button type="submit" class="btn-corrigir">
                        Finalizar simulado
                    </button>

                <?php else: ?>

                    <a href="simulados.php" class="btn-refazer">
                        Voltar para simulados
                    </a>

                <?php endif; ?>

            </form>


        <?php else: ?>


            <div class="questao-card" style="text-align: center;">

                <p style="color: #666; margin: 0;">
                    Este simulado ainda não possui questões cadastradas.
                </p>

            </div>


        <?php endif; ?>


    </div>

</main>


<?php if (!$corrigido && !empty($simulado['tempo_minutos'])): ?>

<script>

    (function () {

        var tempoTotalSegundos = <?= (int) $simulado['tempo_minutos'] * 60; ?>;
        var timerValue = document.getElementById('timerValue');
        var timerBox = document.getElementById('timerBox');
        var form = document.getElementById('formSimulado');

        function atualizarTimer() {

            var minutos = Math.floor(tempoTotalSegundos / 60);
            var segundos = tempoTotalSegundos % 60;

            timerValue.textContent =
                String(minutos).padStart(2, '0') + ':' +
                String(segundos).padStart(2, '0');

            if (tempoTotalSegundos <= 60) {
                timerBox.classList.add('tempo-critico');
            }

            if (tempoTotalSegundos <= 0) {
                clearInterval(intervalo);

                if (form) {
                    form.submit();
                }

                return;
            }

            tempoTotalSegundos--;

        }

        atualizarTimer();

        var intervalo = setInterval(atualizarTimer, 1000);

    })();

</script>

<?php endif; ?>


<?php include(__DIR__ . '/../includes/footer.php'); ?>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento do código
Finalidade: Otimização da lógica de scripts e apoio na estruturação das tags. 
Validação: Script revisado linha a linha, corrigido manualmente e validado quanto ao funcionamento final.
*/
?>
