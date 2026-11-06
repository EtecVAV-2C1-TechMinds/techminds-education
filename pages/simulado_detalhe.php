<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Simulado.php';
require_once __DIR__ . '/../includes/auth.php';

$simuladoId = (int) ($_GET['id'] ?? 0);
if ($simuladoId <= 0) {
    header('Location: simulados.php');
    exit;
}

$simuladoModel = new Simulado();
$simulado = $simuladoModel->buscarPorId($simuladoId);

if (!$simulado) {
    header('Location: simulados.php');
    exit;
}
// =========================================
// TEMPORIZADOR DO SIMULADO
// =========================================

$tempoMinutos = !empty($simulado['tempo_minutos'])
    ? (int) $simulado['tempo_minutos']
    : 150;

// Identifica o horário de início deste simulado
$chaveInicio = 'simulado_inicio_' . $simuladoId;

// Se ainda não existe horário inicial, inicia o temporizador
if (!isset($_SESSION[$chaveInicio])) {
    $_SESSION[$chaveInicio] = time();
}

// Calcula o horário em que o tempo termina
$horarioFinal = $_SESSION[$chaveInicio] + ($tempoMinutos * 60);

$title = htmlspecialchars($simulado['titulo']) . " | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = htmlspecialchars($simulado['titulo']);
$bannerSubtitulo = "Teste seus conhecimentos na prática";
include(__DIR__ . '/../includes/banner.php');
?>



<style>
/* =========================================
   TEMPORIZADOR
========================================= */

.temporizador {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #f5f6f1;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 25px;
    color: var(--green-dark, #233703);
    font-size: 15px;
}

.temporizador strong {
    color: var(--green-main, #6B783E);
    font-size: 22px;
    font-weight: 700;
    font-variant-numeric: tabular-nums;
}

.temporizador.esgotado {
    background: #fbeceb;
    color: #b3261e;
}

.temporizador.esgotado strong {
    color: #b3261e;
}



    .simulado-page {
        background-color: #f1f1f1;
        padding: 40px 20px 80px;
    }
    .simulado-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--green-dark, #233703);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .desistir-link {
    color: #c0392b;
}


/* =========================================
   RESPONSIVIDADE - CELULARES
   ========================================= */




.desistir-link:hover {
    color: #922b21;
    text-decoration: underline;
}
    .aviso-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        margin-bottom: 25px;
    }
    .aviso-card h3 {
        color: var(--green-dark, #233703);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .aviso-card p, .aviso-card li {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }
    .pdf-box {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        margin-bottom: 25px;
    }
    .btn-pdf {
        background-color: var(--green-main, #6B783E);
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }
    .btn-pdf:hover {
        background-color: var(--green-dark, #233703);
        color: white;
    }
    .gabarito-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .gabarito-table {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    grid-template-rows: repeat(15, auto);
    grid-auto-flow: column;
    gap: 20px;
}
    .questao-linha {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #f9f9f9;
        border-radius: 10px;
        margin-bottom: 8px;
    }
    .bolinhas {
        display: flex;
        gap: 8px;
    }
    .bolinha {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 1.5px solid var(--green-main, #6B783E);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        color: var(--green-main, #6B783E);
        transition: 0.2s;
    }
    .bolinha input {
        display: none;
    }
    .bolinha.selecionada, .bolinha input:checked + span {
        background-color: var(--green-main, #6B783E);
        color: white;
    }
    .btn-finalizar {
        display: block;
        width: 100%;
        background-color: #B58837; /* Tom de marrom/dourado dos botões de ação final dos simulados no wireframe */
        color: white;
        border: none;
        padding: 14px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 16px;
        text-align: center;
        margin-top: 30px;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-finalizar:hover {
        background-color: #9c722e;
    }


    @media (max-width: 576px) {

    /* Área principal */
    .simulado-page {
        padding: 25px 12px 50px;
    }

    .simulado-container {
        width: 100%;
        max-width: 100%;
    }

    /* Cartão do PDF */
    .pdf-box {
        padding: 18px 20px;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    /* Cartão do gabarito */
    .gabarito-card {
        padding: 22px 16px;
        width: 100%;
        box-sizing: border-box;
    }

    .gabarito-card h3 {
        font-size: 20px;
    }

    .gabarito-card p {
        line-height: 1.5;
    }

    /* Gabarito: apenas uma coluna no celular */
    .gabarito-table {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: none;
        grid-auto-flow: row;
        gap: 8px;
        width: 100%;
    }

    /* Cada questão ocupa toda a largura */
    .questao-linha {
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 0;
        padding: 10px 12px;
        gap: 8px;
        min-width: 0;
    }

    /* Alternativas */
    .bolinhas {
        display: flex;
        gap: 7px;
        flex-shrink: 0;
    }

    .bolinha {
        width: 26px;
        height: 26px;
        min-width: 26px;
        flex: 0 0 26px;
        font-size: 12px;
    }

    /* Botão finalizar */
    .btn-finalizar {
        margin-top: 22px;
        padding: 13px;
        font-size: 14px;
    }
}
</style>

<main class="simulado-page">
    <div class="simulado-container">

    <a
    href="<?= URL_SISTEMA ?>/pages/desistir_simulado.php?id=<?= $simuladoId ?>"
    class="back-link desistir-link"
>
    <i class="fa-solid fa-circle-xmark"></i>
    Desistir do simulado
</a>


        <!-- Bloco do PDF -->
        <div class="pdf-box">

    <div>
        <h3 style="color:var(--green-dark, #233703); margin-bottom: 10px; font-weight:700;">
            Simulado em PDF
        </h3>

        <p style="margin:0; font-size:13px; color:#666;">
            Baixe ou abra o arquivo com as questões.
        </p>
    </div>

    <?php if (!empty($simulado['pdf_path'])): ?>

        <a
            href="<?= URL_SISTEMA . '/' . htmlspecialchars($simulado['pdf_path']) ?>"
            target="_blank"
            rel="noopener"
            class="btn-pdf"
        >
            <i class="fa-solid fa-file-pdf"></i>
            Abrir PDF
        </a>

    <?php else: ?>

        <span style="font-size:13px; color:#999;">
            PDF indisponível
        </span>

    <?php endif; ?>

</div>

        <!-- Seção do Gabarito -->
        <form
    action="<?= rtrim(URL_SISTEMA, '/') ?>/pages/processar_gabarito.php"
    method="POST"
    class="gabarito-card"
>

<div class="temporizador">
    <i class="fa-regular fa-clock"></i>

    <span>Tempo restante:</span>

    <strong id="tempo-restante"><?= sprintf('%02d:%02d', $tempoMinutos, 0) ?></strong>
</div>

            <input type="hidden" name="simulado_id" value="<?= $simulado['id']; ?>">
            
            <h3 style="color:var(--green-dark, #233703); margin-bottom: 20px; font-weight:700;">Gabarito</h3>
            <p style="font-size:13px; color:#666; margin-bottom:20px;">Selecione a alternativa correta correspondente a cada questão do seu simulado em PDF:</p>

            <div class="gabarito-table">
                <?php 
                // Simulando 45 questões padrão ENEM (ou ajuste conforme necessário)
                $totalQuestoes = 45; 
                for ($i = 1; $i <= $totalQuestoes; $i++): 
                ?>
                    <div class="questao-linha">
                        <span style="font-weight:600; font-size:14px; color:#333;"><?= $i; ?>.</span>
                        <div class="bolinhas">
                            <?php foreach (['A', 'B', 'C', 'D', 'E'] as $letra): ?>
                                <label class="bolinha">
                                    <input type="radio" name="resposta[<?= $i; ?>]" value="<?= $letra; ?>">
                                    <?= $letra; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="btn-finalizar">Finalizar Simulado</button>
        </form>

    </div>
</main>

<script>
    // Script simples para marcar visualmente a bolinha selecionada
    document.querySelectorAll('.bolinha input').forEach(input => {
        input.addEventListener('change', function() {
            // Remove a seleção das outras bolinhas da mesma questão
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(el => {
                el.closest('.bolinha').style.background = 'transparent';
                el.closest('.bolinha').style.color = 'var(--green-main, #6B783E)';
            });
            // Marca a atual
            if (this.checked) {
                this.closest('.bolinha').style.background = 'var(--green-main, #6B783E)';
                this.closest('.bolinha').style.color = 'white';
            }
        });
    });
</script>



<script>
    const horarioFinal = <?= $horarioFinal ?> * 1000;

    const temporizador = document.getElementById('tempo-restante');
    const caixaTemporizador = document.querySelector('.temporizador');
    const formulario = document.querySelector('.gabarito-card');
    const botaoFinalizar = document.querySelector('.btn-finalizar');

    let enviado = false;

    function atualizarTemporizador() {

        const agora = Date.now();
        const diferenca = Math.max(0, horarioFinal - agora);

        const minutos = Math.floor(diferenca / 60000);
        const segundos = Math.floor((diferenca % 60000) / 1000);

        temporizador.textContent =
            String(minutos).padStart(2, '0') + ':' +
            String(segundos).padStart(2, '0');

        if (diferenca <= 0 && !enviado) {

            enviado = true;

            temporizador.textContent = '00:00';
            caixaTemporizador.classList.add('esgotado');

            botaoFinalizar.disabled = true;
            botaoFinalizar.textContent = 'Finalizando simulado...';

            formulario.submit();
        }
    }

    formulario.addEventListener('submit', function(event) {

        if (enviado) {
            return;
        }

        enviado = true;
        botaoFinalizar.disabled = true;
        botaoFinalizar.textContent = 'Enviando respostas...';

    });

    atualizarTemporizador();

    setInterval(atualizarTemporizador, 1000);
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
