<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - EDIT CLASS
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

/* =========================================
   GET CLASS ID
========================================= */

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {

    header('Location: aulas.php?erro=editar');
    exit;

}

/* =========================================
   LOAD CLASS
========================================= */

$aula = $aulaModel->buscarPorId($id);

if (!$aula) {

    header('Location: aulas.php?erro=editar');
    exit;

}

/* =========================================
   LOAD CONTENTS
========================================= */

$conteudos = $aulaModel->listarConteudos();

$title = "Editar Aula | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilos exclusivos da página de Edição de Aula -->
<style>

    /* =========================================
       PAGE TITLE / HERO
    ========================================= */

    .dashboard-hero {
        background-color: var(--green-main);
        padding: 45px 20px;
        text-align: center;
    }


    .dashboard-hero h1 {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }


    .dashboard-hero p {
        color: #ffffff;
        margin: 0;
        font-size: 0.95rem;
    }


    /* =========================================
       MAIN CONTENT
    ========================================= */

    .dashboard-content {
        max-width: 1050px;
        margin: 0 auto;
        padding: 45px 20px;
    }


    /* =========================================
       FORM CARD
    ========================================= */

    .dashboard-card {
        background-color: #f2f2f2;
        border: none;
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }


    /* =========================================
       FORM FIELDS
    ========================================= */

    .dashboard-label {
        color: #555555;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 7px;
    }


    .dashboard-input,
    .dashboard-select,
    .dashboard-textarea {
        width: 100%;
        border: none;
        background-color: #ffffff;
        border-radius: 12px;
        padding: 12px 15px;
        color: #444444;
        outline: none;
        box-shadow: inset 0 0 0 1px #dddddd;
    }


    .dashboard-input:focus,
    .dashboard-select:focus,
    .dashboard-textarea:focus {
        box-shadow: inset 0 0 0 2px var(--green-main);
    }


    .dashboard-textarea {
        min-height: 120px;
        resize: vertical;
    }


    /* =========================================
       BUTTONS
    ========================================= */

    .dashboard-button {
        background-color: #A77E34;
        color: #ffffff;
        border: none;
        border-radius: 25px;
        padding: 11px 28px;
        font-weight: 600;
        transition: 0.2s;
    }


    .dashboard-button:hover {
        background-color: #8f692b;
        color: #ffffff;
    }


    .dashboard-cancel {
        background-color: #757B4B;
        color: #ffffff;
        border: none;
        border-radius: 25px;
        padding: 11px 28px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
    }


    .dashboard-cancel:hover {
        color: #ffffff;
        background-color: #60643c;
    }

</style>


<!-- Script para garantir a atualização do título da aba no navegador -->
<script>
    document.title = "Editar Aula | <?= addslashes(NOME_SISTEMA) ?>";
</script>


<!-- =========================================
     PAGE HERO
========================================= -->

<section class="dashboard-hero">

    <h1>
        Editar Aula
    </h1>

    <p>
        Área do administrador
    </p>

</section>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="dashboard-content">

    <div class="dashboard-card">

        <form
            method="POST"
            action="../controllers/AulaController.php?acao=editar"
        >

            <input
                type="hidden"
                name="id"
                value="<?= (int) $aula['id']; ?>"
            >


            <div class="row g-4">

                <!-- CONTEÚDO -->

                <div class="col-md-6">

                    <label class="dashboard-label">
                        Conteúdo
                    </label>

                    <select
                        name="conteudo_id"
                        class="dashboard-select"
                        required
                    >

                        <?php foreach ($conteudos as $conteudo): ?>

                            <option
                                value="<?= (int) $conteudo['id']; ?>"
                                <?= (int) $conteudo['id'] === (int) $aula['conteudo_id']
                                    ? 'selected'
                                    : ''; ?>
                            >

                                <?= htmlspecialchars(
                                    $conteudo['titulo']
                                ); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- TÍTULO -->

                <div class="col-md-6">

                    <label class="dashboard-label">
                        Título da aula
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        class="dashboard-input"
                        value="<?= htmlspecialchars($aula['titulo']); ?>"
                        required
                    >

                </div>


                <!-- DESCRIÇÃO -->

                <div class="col-12">

                    <label class="dashboard-label">
                        Descrição
                    </label>

                    <textarea
                        name="descricao"
                        class="dashboard-textarea"
                        rows="5"
                        required
                    ><?= htmlspecialchars($aula['descricao']); ?></textarea>

                </div>


                <!-- VÍDEO -->

                <div class="col-md-6">

                    <label class="dashboard-label">
                        Link do vídeo
                    </label>

                    <input
                        type="text"
                        name="video"
                        class="dashboard-input"
                        value="<?= htmlspecialchars($aula['video'] ?? ''); ?>"
                    >

                </div>


                <!-- MATERIAL -->

                <div class="col-md-6">

                    <label class="dashboard-label">
                        Material
                    </label>

                    <input
                        type="text"
                        name="material"
                        class="dashboard-input"
                        value="<?= htmlspecialchars($aula['material'] ?? ''); ?>"
                    >

                </div>


                <!-- ORDEM -->

                <div class="col-12">

                    <label class="dashboard-label">
                        Ordem
                    </label>

                    <input
                        type="number"
                        name="ordem"
                        class="dashboard-input"
                        min="1"
                        value="<?= (int) $aula['ordem']; ?>"
                        required
                    >

                </div>


                <!-- BOTÕES -->

                <div class="col-12 text-center mt-4">

                    <button
                        type="submit"
                        class="dashboard-button"
                    >

                        Salvar alterações

                    </button>


                    <a
                        href="aulas.php"
                        class="dashboard-cancel ms-2"
                    >

                        Cancelar

                    </a>

                </div>

            </div>

        </form>

    </div>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>