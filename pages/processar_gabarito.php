<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';

$title = "Resultado do Simulado | " . NOME_SISTEMA;

$simuladoModel = new Simulado();

$usuarioId = (int) ($_SESSION[SESSION_USUARIO] ?? 0);

$simuladoId = (int) ($_POST['simulado_id'] ?? 0);

$chaveInicio = 'simulado_inicio_' . $simuladoId;

$respostas = $_POST['resposta'] ?? [];

if (
    $usuarioId <= 0 ||
    $simuladoId <= 0 ||
    !is_array($respostas)
) {
    header('Location: simulados.php?erro=envio');
    exit;
}

/* =========================================
   BUSCAR SIMULADO
========================================= */

$simulado = $simuladoModel->buscarPorId($simuladoId);

if (!$simulado || empty($simulado['ativo'])) {
    header('Location: simulados.php?erro=nao_encontrado');
    exit;
}

/* =========================================
   BUSCAR GABARITO
========================================= */

$gabarito = $simuladoModel->buscarGabarito($simuladoId);

if (count($gabarito) !== 45) {
    header('Location: simulados.php?erro=gabarito');
    exit;
}

/* =========================================
   CORRIGIR RESPOSTAS
========================================= */
/* =========================================
   CORRIGIR RESPOSTAS
========================================= */

$totalQuestoes = 45;
$acertos = 0;
$respondidas = 0;
$correcao = [];

for ($i = 1; $i <= $totalQuestoes; $i++) {

    $respostaAluno = strtoupper(
        trim($respostas[$i] ?? '')
    );

    $respostaCorreta = strtoupper(
        $gabarito[$i] ?? ''
    );

    $respostaValida = in_array(
        $respostaAluno,
        ['A', 'B', 'C', 'D', 'E'],
        true
    );

    $acertou = $respostaValida &&
        $respostaAluno === $respostaCorreta;

    if ($respostaValida) {
        $respondidas++;
    }

    if ($acertou) {
        $acertos++;
    }

    $correcao[] = [
        'numero' => $i,
        'resposta_aluno' => $respostaAluno,
        'resposta_correta' => $respostaCorreta,
        'acertou' => $acertou
    ];
}

$erros = $totalQuestoes - $acertos;

$aproveitamento = ($acertos / $totalQuestoes) * 100;

/* =========================================
   SALVAR RESULTADO
========================================= */

try {

    $resultadoId = $simuladoModel->registrarResultado(
        $usuarioId,
        $simuladoId,
        $totalQuestoes,
        $acertos
    );

} catch (Throwable $e) {

    error_log('Erro ao registrar resultado: ' . $e->getMessage());

    header('Location: simulados.php?erro=resultado');
    exit;
}
unset($_SESSION[$chaveInicio]);

/* =========================================
   EXIBIR RESULTADO
========================================= */


include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
$bannerTitulo = "Simulados";
$bannerSubtitulo = "Teste seus conhecimentos na prática.";
include(__DIR__ . '/../includes/banner.php');

?>

<style>
    .resultado-page {
        background: #f1f1f1;
        min-height: 70vh;
        padding: 50px 20px;
    }

    .resultado-container {
        max-width: 1000px;
        margin: auto;
    }

    .resultado-card {
        background: white;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
        text-align: center;
    }

    .resultado-card h1 {
        color: var(--green-dark, #233703);
        font-size: 26px;
        margin-bottom: 10px;
    }

    .resultado-card p {
        color: #666;
    }

    .resultado-nota {
        background: #f5f6f1;
        border-radius: 15px;
        padding: 25px;
        margin: 25px 0;
    }

    .resultado-nota strong {
        display: block;
        color: var(--green-main, #6B783E);
        font-size: 48px;
        margin-bottom: 5px;
    }

    .resultado-dados {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin: 25px 0;
    }

    .resultado-item {
        background: #f7f7f7;
        border-radius: 12px;
        padding: 18px 8px;
    }

    .resultado-item strong {
        display: block;
        font-size: 23px;
        color: var(--green-dark, #233703);
    }

    .resultado-item span {
        font-size: 12px;
        color: #777;
    }

    .resultado-botoes {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 25px;
    }

    .resultado-botoes a {
        padding: 12px 22px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-voltar {
        background: var(--green-main, #6B783E);
        color: white;
    }

    .btn-voltar:hover {
        color: white;
        opacity: .9;
    }
/* =========================================
   GABARITO CORRIGIDO
========================================= */
/* =========================================
   GABARITO CORRIGIDO
========================================= */

.gabarito-resultado {
    margin-top: 30px;
    text-align: left;
}

.gabarito-resultado h2 {
    color: var(--green-dark, #233703);
    font-size: 21px;
    text-align: center;
    margin-bottom: 20px;
}

/* Organização em três colunas */
.gabarito-lista {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    grid-template-rows: repeat(15, auto);
    grid-auto-flow: column;
    gap: 20px;
}

/* Cada questão */
.gabarito-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 8px 12px;
    background: #f9f9f9;
    border-radius: 10px;
    min-width: 0;
    box-sizing: border-box;
}

/* Questão acertada */
.gabarito-item.acertou {
    background: #eaf5ea;
    border: 1px solid #2e7d32;
}

/* Questão errada */
.gabarito-item.errou {
    background: #fbeceb;
    border: 1px solid #b3261e;
}

/* Número */
.gabarito-numero {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    flex-shrink: 0;
}

/* Grupo de alternativas */
.gabarito-alternativas {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

/* Bolinhas */
.gabarito-alternativa {
    width: 26px;
    height: 26px;
    min-width: 26px;
    border-radius: 50%;
    border: 1.5px solid var(--green-main, #6B783E);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: var(--green-main, #6B783E);
    box-sizing: border-box;
}

/* Resposta correta */
.gabarito-alternativa.correta {
    background: var(--dourado);
    border-color: var(--dourado);
    color: white;
}

/* Aluno acertou */
.gabarito-alternativa.selecionada-correta {
    background: var(--green-main, #6B783E);
    border-color: var(--green-main, #6B783E);
    color: white;
}

/* Aluno errou */
.gabarito-alternativa.selecionada-errada {
    background: #a34f32;
    border-color: #a34f32;
    color: white;
}

/* =========================================
   RESPONSIVIDADE - CELULARES
========================================= */

@media (max-width: 576px) {

    .resultado-container {
        width: 100%;
        max-width: 100%;
    }

    .resultado-card {
        padding: 22px 15px;
    }

    .gabarito-lista {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: none;
        grid-auto-flow: row;
        gap: 8px;
        width: 100%;
    }

    .gabarito-item {
        width: 100%;
        padding: 10px 12px;
        gap: 8px;
    }

    .gabarito-alternativas {
        gap: 7px;
    }

    .gabarito-alternativa {
        width: 26px;
        height: 26px;
        min-width: 26px;
    }
}

    @media(max-width: 500px) {
        .resultado-card {
            padding: 22px 15px;
        }

        .resultado-dados {
            gap: 7px;
        }

        .resultado-item {
            padding: 15px 5px;
        }
    }
</style>

<main class="resultado-page">

    <div class="resultado-container">

        <section class="resultado-card">

            <h1>Simulado finalizado!</h1>

            <p>
                <?= htmlspecialchars($simulado['titulo']) ?>
            </p>

            <div class="resultado-nota">

                <strong>
                    <?= number_format($aproveitamento, 1, ',', '.') ?>%
                </strong>

                <span><br><br>Seu aproveitamento</span>

            </div>

            <div class="resultado-dados">

                <div class="resultado-item">
                    <strong><?= $acertos ?></strong>
                    <span>Acertos</span>
                </div>

                <div class="resultado-item">
                    <strong><?= $erros ?></strong>
                    <span>Erros</span>
                </div>

                <div class="resultado-item">
                    <strong><?= $respondidas ?></strong>
                    <span>Respondidas</span>
                </div>

            </div>

            <!-- GABARITO COM CORREÇÃO -->

<!-- GABARITO COM CORREÇÃO -->

<section class="gabarito-resultado">

    <h2>Correção das questões</h2>

    <div class="gabarito-lista">

        <?php foreach ($correcao as $questao): ?>

            <?php
                if ($questao['acertou']) {
                    $classeQuestao = 'acertou';
                } elseif ($questao['resposta_aluno'] === '') {
                    $classeQuestao = '';
                } else {
                    $classeQuestao = 'errou';
                }
            ?>

            <div class="gabarito-item <?= $classeQuestao ?>">

                <span class="gabarito-numero">
                    <?= $questao['numero'] ?>.
                </span>

                <div class="gabarito-alternativas">

                    <?php foreach (['A', 'B', 'C', 'D', 'E'] as $alternativa): ?>

                        <?php
                            $classeAlternativa = '';

                            if (
                                $alternativa === $questao['resposta_correta']
                            ) {
                                $classeAlternativa = 'correta';
                            }

                            if (
                                $alternativa === $questao['resposta_aluno']
                            ) {
                                if ($questao['acertou']) {
                                    $classeAlternativa = 'selecionada-correta';
                                } else {
                                    $classeAlternativa = 'selecionada-errada';
                                }
                            }
                        ?>

                        <span class="gabarito-alternativa <?= $classeAlternativa ?>">
                            <?= $alternativa ?>
                        </span>

                    <?php endforeach; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>

            <p>
                Seu resultado foi registrado com sucesso!
            </p>

            <div class="resultado-botoes">

                <a
                    href="simulados.php"
                    class="btn-voltar"
                >
                    Voltar aos simulados
                </a>

            </div>

        </section>

    </div>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
