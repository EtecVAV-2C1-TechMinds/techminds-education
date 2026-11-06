<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Simulado.php';
require_once __DIR__ . '/../includes/auth.php';

$title = "Simulados | " . NOME_SISTEMA;

$simuladoModel = new Simulado();
$simulados = $simuladoModel->listarAtivos();

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Simulados";
$bannerSubtitulo = "Teste seus conhecimentos na prática.";
include(__DIR__ . '/../includes/banner.php');
?>

<style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        background-color: #f1f1f1;
    }
    .botoes-instrucoes {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 25px;
}

.btn-voltar-simulados {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: 1px solid #a77e34;
    border-radius: 25px;
    color: #a77e34;
    background-color: transparent;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    transition: 0.2s;
}

.btn-voltar-simulados:hover {
    background-color: #f5eee2;
    color: #805d25;
}

.btn-continuar-aviso {
    background-color: #a77e34;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-continuar-aviso:hover {
    background-color: #805d25;
    color: white;
}
    .imagem-gabarito {
    display: block;
    width: 40%;
    max-width: 400px;
    height: auto;
    margin: 20px auto;
    border-radius: 12px;
}
    .contents-page {
        flex: 1;
        max-width: 1000px;
        width: 100%;
        margin: 0 auto;
        padding: 45px 20px 80px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--green-dark, #233703);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 25px;
    }

    #instrucoesSimulado[hidden] {
    display: none !important;
}

    .back-link:hover {
        color: var(--green-main, #6B783E);
    }

    /* =========================================
       CARD DE AVISO / ORIENTAÇÃO (NO TOPO)
    ========================================= */
    .aviso-simulado-card {
        background-color: white;
        border-radius: 16px;
        padding: 24px 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        border-left: 5px solid var(--green-main, #6B783E);
    }

    .aviso-simulado-card h3 {
        color: var(--green-dark, #233703);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .aviso-simulado-card p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .btn-continuar-aviso {
        background-color: var(--green-main, #6B783E);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-continuar-aviso:hover {
        background-color: var(--green-dark, #233703);
        color: white;
        transform: translateY(-1px);
    }

    .contents-intro {
        margin-bottom: 30px;
    }

    .contents-intro h1 {
        color: var(--green-dark, #233703);
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .contents-intro p {
        color: #666;
        margin: 0;
        line-height: 1.6;
    }

    .content-card {
        background-color: white;
        border-radius: 16px;
        padding: 22px 25px;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.11);
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

    .content-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--green-main, #6B783E);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-weight: 700;
        font-size: 16px;
    }

    .content-info h2 {
        color: var(--green-dark, #233703);
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

    .content-arrow {
        color: var(--green-main, #6B783E);
        font-size: 18px;
        flex-shrink: 0;
    }

    .empty-contents {
        background-color: white;
        border-radius: 16px;
        padding: 50px 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
    }

    .empty-contents h2 {
        color: var(--green-dark, #233703);
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-contents p {
        color: #666;
        margin: 0;
    }

    @media (max-width: 575px) {
        .contents-page {
            padding: 35px 15px 60px;
        }
        .contents-intro h1 {
            font-size: 24px;
        }
        .content-card {
            padding: 18px;
        }
        .content-icon {
            width: 42px;
            height: 42px;
            font-size: 14px;
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
    <div style="width: 100%;">

        <!-- Voltar para Matérias -->
        <a href="materias.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar para matérias
        </a>


        <!-- Lista de simulados -->
<div id="listaSimulados">

<div class="contents-intro">
    <h1>Simulados Disponíveis</h1>
    <p>
        Simulados preparatórios com questões focadas no ENEM
        e vestibulares.
    </p>
</div>

<?php if (!empty($simulados)): ?>
    <?php foreach ($simulados as $index => $simulado): ?>

        <article class="content-card">
            <a
                href="simulado_detalhe.php?id=<?= (int) $simulado['id']; ?>"
                class="content-link"
            >
                <div class="content-info">
                    <div class="content-icon">
                        #<?= $index + 1; ?>
                    </div>

                    <div>
                        <h2>
                            <?= htmlspecialchars($simulado['titulo']); ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars(
                                $simulado['descricao']
                                ?? 'Acesse para abrir o PDF e preencher o gabarito.'
                            ); ?>
                        </p>
                    </div>
                </div>

                <i class="fa-solid fa-arrow-right content-arrow"></i>
            </a>
        </article>

    <?php endforeach; ?>

<?php else: ?>

    <div class="empty-contents">
        <h2>Nenhum simulado disponível</h2>
        <p>Ainda não existem simulados cadastrados.</p>
    </div>

<?php endif; ?>

</div>

<!-- Instruções: aparecem somente após selecionar um simulado -->
<div class="aviso-simulado-card" id="instrucoesSimulado" hidden>


    <h3>Instruções Importantes para o Simulado</h3>

    <p>
        Atenção! Ao iniciá-lo, a
        <strong>contagem de tempo (150 minutos) não poderá ser interrompida.</strong>
        Além disso, simulados iniciados serão finalizados
        automaticamente ao final do tempo disponível para resolução.
    </p>

    <p>
        Ao descartar o simulado,
        <strong>todas as respostas serão descartadas</strong>
        e você poderá refazê-lo a qualquer momento.
    </p>

    <p>
        <strong>Dicas:</strong> Resolva as questões com atenção,
        prepare um ambiente calmo e faça pausas inteligentes.
    </p>

    <p><strong>O simulado permite o envio sem o preenchimento de todas as questões. Atente-se ao preenchimento completo do gabarito antes de finalizar.</strong></p>

    <h3>Como funciona o gabarito?</h3>

    <p>
        Selecione a alternativa correta correspondente a cada questão.
    </p>

    <img
        src="/techminds-education/assets/img/gabarito.png"
        alt="Exemplo de preenchimento do gabarito"
        class="imagem-gabarito"
    >

    <h3>Como funciona a correção do simulado?</h3>

    <p>
        Ao clicar em finalizar o simulado, você visualizará o seu desempenho em porcentagem, o número de acertos e erros e o número de questões respondidas. Além disso, é possível visualizar o gabarito:
        o card da questão fica verde com o acerto, vermelho com o erro e cinza se a questão não foi respondida. A alternativa correta em caso de erro ou não resposta é apresentada na cor dourado.
    </p>

    <img
        src="/techminds-education/assets/img/correcao-gabarito.png"
        alt="Exemplo da correção do gabarito"
        class="imagem-gabarito"
    >

</div>

<div class="botoes-instrucoes">
    <a href="simulados.php" class="btn-voltar-simulados">
        <i class="fa-solid fa-arrow-left"></i>
        Voltar aos simulados
    </a>

    <button type="button" class="btn-continuar-aviso" id="btnContinuar">
        Iniciar Simulado
        <i class="fa-solid fa-arrow-right"></i>
    </button>
</div>


</div>

    </div>
</main>
<script>
    let simuladoSelecionado = null;

    const listaSimulados = document.getElementById('listaSimulados');
    const instrucoes = document.getElementById('instrucoesSimulado');
    const btnContinuar = document.getElementById('btnContinuar');

    // Ao clicar em um simulado, mostrar as instruções
    listaSimulados.addEventListener('click', function(event) {
        const link = event.target.closest('.content-link');

        if (!link) {
            return;
        }

        event.preventDefault();

        simuladoSelecionado = link.href;

        listaSimulados.hidden = true;
        instrucoes.hidden = false;

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Ao clicar em continuar, abrir o simulado escolhido
    btnContinuar.addEventListener('click', function() {
        if (simuladoSelecionado) {
            window.location.href = simuladoSelecionado;
        }
    });
</script>

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
