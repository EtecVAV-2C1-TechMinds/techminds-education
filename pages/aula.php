<?php

/* =========================================
   TECHMINDS EDUCATION
   STUDENT - CLASS PAGE
========================================= */

require_once __DIR__ . '/../models/Aula.php';


/* =========================================
   GET CLASS ID
========================================= */

$aulaId = (int) ($_GET['id'] ?? 0);

if ($aulaId <= 0) {
    header('Location: materias.php');
    exit;
}


/* =========================================
   LOAD CLASS
========================================= */

$aulaModel = new Aula();
$aula = $aulaModel->buscarPorId($aulaId);

if (!$aula) {
    header('Location: materias.php');
    exit;
}

// Define o título dinâmico para o header.php
$title = htmlspecialchars($aula['titulo']) . " | TechMinds Education";

// Includes padrão da aplicação (Navbar e Header)
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- CSS complementar (Bootstrap, FontAwesome e Stylesheet principal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">

<style>
    :root {
        --green-dark: #233703;
        --green-card: #a8b092;
        --brown-btn: #aa7c32;
        --brown-btn-hover: #966c29;
        --bg-light: #EBEBEB;
    }

    body {
        background-color: var(--bg-light) !important;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* MAIN CONTAINER */
    .aula-page {
        flex: 1;
        padding: 30px 20px 60px;
    }

    .aula-container {
        width: 100%;
        max-width: 500px; /* Alinhado ao protótipo da imagem */
        margin: 0 auto;
    }

    /* CABEÇALHO DA AULA (CARD MUSGO) */
    .aula-card-header {
        background-color: var(--green-card);
        color: #ffffff;
        text-align: center;
        padding: 24px 20px;
        border-radius: 18px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .aula-card-header h1 {
        font-weight: 800;
        font-size: 1.5rem;
        line-height: 1.2;
        margin-bottom: 6px;
        color: var(--green-dark);
    }

    .aula-card-header p {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
    }

    /* TEXTO INTRODUTÓRIO */
    .texto-introdutorio {
        color: #555555;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 25px;
        padding: 0 5px;
    }

    /* BOTÕES DE RECURSOS (ESTILO PÍLULA DOURADO) */
    .botoes-container {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 30px;
    }

    .btn-recurso {
        display: block;
        width: 100%;
        background-color: var(--brown-btn);
        color: #ffffff !important;
        text-decoration: none !important;
        text-align: center;
        padding: 13px 20px;
        border-radius: 25px;
        font-size: 0.95rem;
        font-weight: 600;
        transition: transform 0.2s, background-color 0.2s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        box-sizing: border-box;
    }

    .btn-recurso:hover {
        background-color: var(--brown-btn-hover);
        transform: translateY(-1px);
    }

    /* ÁREA DE MARCAR CONCLUÍDA */
    .concluir-container {
        background-color: #eaeaea;
        padding: 20px;
        border-radius: 16px;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-concluir {
        background-color: #dcdfd5;
        color: var(--green-dark);
        border: 2px solid var(--green-dark);
        border-radius: 25px;
        padding: 10px 24px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-concluir:hover {
        background-color: var(--green-dark);
        color: #ffffff;
    }

    /* BOTAO VOLTAR */
    .voltar-container {
        text-align: center;
        margin-top: 15px;
    }

    .btn-voltar {
        color: var(--green-dark);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .btn-voltar:hover {
        text-decoration: underline;
    }

    /* DESKTOP RESPONSIVIDADE */
    @media (min-width: 768px) {
        .aula-container {
            max-width: 600px;
        }
    }
</style>

<!-- Script para garantir a troca do título da aba do navegador -->
<script>
    document.title = "<?= $title; ?>";
</script>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="aula-page">

    <div class="aula-container">

        <!-- CABEÇALHO DA AULA -->
        <section class="aula-card-header">
            <h1>
                <?= htmlspecialchars($aula['titulo']); ?>
            </h1>
            <p>
                <?= htmlspecialchars($aula['conteudo'] ?? 'Matéria'); ?>
            </p>
        </section>

        <!-- TEXTO INTRODUTÓRIO -->
        <p class="texto-introdutorio">
            <?= !empty($aula['descricao'])
                ? nl2br(htmlspecialchars($aula['descricao']))
                : 'Texto introdutório'; ?>
        </p>

        <!-- BOTÕES DE RECURSOS E AULAS -->
        <div class="botoes-container">

            <?php if (!empty($aula['material'])): ?>
                <a href="<?= htmlspecialchars($aula['material']); ?>" target="_blank" rel="noopener noreferrer" class="btn-recurso">
                    Arquivo PDF da explicação
                </a>
            <?php else: ?>
                <div class="btn-recurso" style="opacity: 0.8; cursor: not-allowed;">
                    Arquivo PDF não disponível
                </div>
            <?php endif; ?>

            <a href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>" class="btn-recurso">
                Acesse o resumo da aula
            </a>

            <?php if (!empty($aula['video'])): ?>
                <a href="<?= htmlspecialchars($aula['video']); ?>" target="_blank" rel="noopener noreferrer" class="btn-recurso">
                    Link da aula em vídeo
                </a>
            <?php else: ?>
                <div class="btn-recurso" style="opacity: 0.8; cursor: not-allowed;">
                    Vídeo ainda não disponível
                </div>
            <?php endif; ?>

        </div>

        <!-- MARCAR COMO CONCLUÍDA -->
        <div class="concluir-container">
            <button type="button" class="btn-concluir" onclick="marcarConcluida()">
                Marcar aula como concluída
            </button>
        </div>

        <!-- BOTÃO VOLTAR -->
        <div class="voltar-container">
            <a href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para o conteúdo
            </a>
        </div>

    </div>

</main>


<!-- =========================================
     FOOTER INCLUSO
========================================= -->
<?php include(__DIR__ . '/../includes/footer.php'); ?>


<!-- =========================================
     JAVASCRIPT MANTIDO
========================================= -->
<script>
function marcarConcluida() {
    const botao = document.querySelector('.btn-concluir');
    botao.innerHTML = '<i class="fa-solid fa-check"></i> Aula concluída!';
    botao.disabled = true;
    botao.style.opacity = '0.7';
}
</script>

</body>
</html>
