<?php

/* =========================================
   TECHMINDS EDUCATION
   QUESTIONS BY CONTENT
========================================= */

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Questao.php';
require_once __DIR__ . '/../models/Conteudo.php';

/* =========================================
   PAGE TITLE
========================================= */
$title = "Questões | TechMinds Education";

/* =========================================
   GET CONTENT ID
========================================= */
$conteudo_id = (int) ($_GET['conteudo_id'] ?? 0);

if ($conteudo_id <= 0) {
    header('Location: questoes.php');
    exit;
}

/* =========================================
   CREATE MODELS
========================================= */
$questaoModel = new Questao($pdo);
$conteudoModel = new Conteudo();

/* =========================================
   GET CONTENT
========================================= */
$conteudo = $conteudoModel->buscarPorId($conteudo_id);

if (!$conteudo) {
    header('Location: questoes.php');
    exit;
}

/* =========================================
   GET QUESTIONS
========================================= */
$questoes = $questaoModel->listarPorConteudo($conteudo_id);

/* =========================================
   INCLUDES
========================================= */
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =========================================
           VARIÁVEIS DE CORES
        ========================================= */
        :root {
            --green-dark: #233703;
            --green-main: #5e7037;
            --green-btn: #8A9E48;
            --btn-verificar: #A07D35;
            --btn-verificar-hover: #866729;
            --bg-light: #EBEBEB;
        }

        body {
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        /* =========================================
           BANNER IGUAL AO CONTEÚDOS
        ========================================= */
        .banner-questoes {
            background-color: var(--green-main);
            color: white;
            text-align: center;
            padding: 35px 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .banner-questoes h1 {
            margin: 0 0 8px;
            font-size: 30px;
            font-weight: 700;
        }

        .banner-questoes p {
            margin: 0;
            font-size: 15px;
            opacity: 0.95;
            color: white;
        }

        /* =========================================
           ÁREA PRINCIPAL
        ========================================= */
        .questoes-page {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px 70px;
        }

        /* =========================================
           CABEÇALHO
        ========================================= */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h2 {
            color: var(--green-dark);
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .page-header p {
            margin: 4px 0 0;
            color: #666666;
            font-size: 13px;
        }

        .btn-voltar {
            color: var(--green-dark);
            text-decoration: none;
            font-weight: 700;
            border: 2px solid var(--green-dark);
            padding: 9px 20px;
            border-radius: 25px;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-voltar:hover {
            background-color: var(--green-dark);
            color: #ffffff;
        }

        /* =========================================
           PAGINAÇÃO DA QUESTÃO (CÍRCULOS)
        ========================================= */
        .questoes-navegacao {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
        }

        .num-questao-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #d1d1d1;
            color: #444;
            font-weight: 700;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .num-questao-btn.active {
            background-color: var(--green-btn);
            color: white;
        }

        /* =========================================
           CARD DA QUESTÃO (SLIDER)
        ========================================= */
        .questao-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 35px 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            display: none; /* Esconde todas por padrão */
        }

        .questao-card.active {
            display: block !important; /* Exibe apenas a questão ativa */
        }

        .questao-card h3.questao-titulo {
            color: var(--green-dark);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .questao-enunciado {
            color: #555555;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* =========================================
           ALTERNATIVAS
        ========================================= */
        .alternativas {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 30px;
        }

        .alternativa-input {
            display: none;
        }

        .alternativa-label {
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1.5px solid #333333;
            border-radius: 50px;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #333333;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
        }

        .letra-alternativa {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            min-width: 32px;
            border-radius: 50%;
            border: 1.5px solid #333333;
            color: #333333;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .texto-alternativa {
            font-size: 14px;
            font-weight: 500;
        }

        .alternativa-input:checked + .alternativa-label {
            border-color: var(--green-dark);
            background-color: #f4f7ee;
        }

        .alternativa-input:checked + .alternativa-label .letra-alternativa {
            background-color: var(--green-btn);
            border-color: var(--green-btn);
            color: white;
        }

        /* =========================================
           BOTÃO VERIFICAR
        ========================================= */
        .btn-verificar {
            background-color: var(--btn-verificar);
            color: white;
            border: none;
            padding: 10px 35px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-verificar:hover {
            background-color: var(--btn-verificar-hover);
        }

        /* =========================================
           ESTADO VAZIO
        ========================================= */
        .sem-questoes {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
        }

        .sem-questoes i {
            font-size: 35px;
            color: var(--green-main);
            margin-bottom: 15px;
        }

        .sem-questoes h3 {
            color: var(--green-dark);
            font-size: 20px;
            font-weight: 700;
        }

        .sem-questoes p {
            color: #666666;
            margin: 0;
        }

        @media (min-width: 768px) {
            .banner-questoes {
                padding: 45px 40px;
            }
            .banner-questoes h1 {
                font-size: 38px;
            }
            .questoes-page {
                padding: 55px 30px 80px;
            }
        }
    </style>
</head>
<body>

<section class="banner-questoes">
    <h1><?= htmlspecialchars($conteudo['titulo']); ?></h1>
    <p>Questões do conteúdo</p>
</section>

<main class="questoes-page">

    <div class="page-header">
        <div>
            <h2>Questões</h2>
            <p><?= htmlspecialchars($conteudo['descricao'] ?? 'Intro'); ?></p>
        </div>

        <a href="http://localhost:8080/techminds-education/pages/conteudo.php?id=<?= $conteudo['id']; ?>" class="btn-voltar">
    <i class="fa-solid fa-arrow-left"></i> Voltar para conteúdos
</a>
    </div>

    <?php if (empty($questoes)): ?>

        <div class="sem-questoes">
            <i class="fa-solid fa-circle-question"></i>
            <h3>Nenhuma questão disponível</h3>
            <p>Ainda não existem questões cadastradas para este conteúdo.</p>
        </div>

    <?php else: ?>

        <div class="questoes-navegacao">
            <?php foreach ($questoes as $index => $q): ?>
                <button 
                    type="button" 
                    class="num-questao-btn <?= $index === 0 ? 'active' : ''; ?>" 
                    onclick="mostrarQuestao(<?= $index + 1; ?>)"
                    id="btn-nav-<?= $index + 1; ?>">
                    <?= $index + 1; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($questoes as $index => $questao): 
            $num = $index + 1;
            $qId = $questao['id'] ?? $num;
        ?>

            <div class="questao-card <?= $num === 1 ? 'active' : ''; ?>" id="questao-<?= $num; ?>">
                
                <h3 class="questao-titulo">
                    <?= htmlspecialchars($questao['disciplina'] ?? 'Interdisciplinar'); ?>
                </h3>

                <div class="questao-enunciado">
                    <?= nl2br(htmlspecialchars($questao['enunciado'])); ?>
                </div>

                <form class="form-questao">
                    <div class="alternativas">

                        <?php 
                        $letras = ['a', 'b', 'c', 'd', 'e'];
                        foreach ($letras as $letra): 
                            $campoAlt = 'alternativa_' . $letra;
                            if (empty($questao[$campoAlt])) continue;
                            $inputUniqueId = "q_{$qId}_{$letra}";
                        ?>
                            <div>
                                <input type="radio" 
                                       name="resposta_q<?= $qId; ?>" 
                                       id="<?= $inputUniqueId; ?>" 
                                       value="<?= strtoupper($letra); ?>" 
                                       class="alternativa-input">
                                
                                <label for="<?= $inputUniqueId; ?>" class="alternativa-label">
                                    <span class="letra-alternativa"><?= strtoupper($letra); ?></span>
                                    <span class="texto-alternativa">
                                        <?= htmlspecialchars($questao[$campoAlt]); ?>
                                    </span>
                                </label>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <button type="button" class="btn-verificar">Verificar</button>
                </form>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script>
function mostrarQuestao(numero) {
    // 1. Esconde todos os cards de questão
    const cards = document.querySelectorAll('.questao-card');
    cards.forEach(card => card.classList.remove('active'));

    // 2. Remove o destaque de todas as bolinhas numéricas
    const botoes = document.querySelectorAll('.num-questao-btn');
    botoes.forEach(btn => btn.classList.remove('active'));

    // 3. Mostra a questão selecionada
    const questaoSelecionada = document.getElementById('questao-' + numero);
    if (questaoSelecionada) {
        questaoSelecionada.classList.add('active');
    }

    // 4. Destaca a bolinha da questão selecionada
    const botaoSelecionado = document.getElementById('btn-nav-' + numero);
    if (botaoSelecionado) {
        botaoSelecionado.classList.add('active');
    }
}
</script>

</body>
</html>

</body>
</html>
