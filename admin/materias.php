<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - MATÉRIAS
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Materia.php';

$materiaModel = new Materia();
$materias = $materiaModel->listar();

$materiaEditar = null;

if (isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];
    if ($id > 0) {
        $materiaEditar = $materiaModel->buscarPorId($id);
    }
}

$title = "Gerenciar Matérias | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilos exclusivos do Dashboard e Gerenciamento -->
<style>

    /* =========================================
       DASHBOARD PAGE
    ========================================= */

    body {
        background-color: #ffffff;
        color: #333333;
    }


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


    .dashboard-card-title {
        color: #1A2601;
        font-size: 1.45rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
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


    /* =========================================
       CONTENTS SECTION
    ========================================= */

    .contents-title {
        color: #1A2601;
        font-size: 1.6rem;
        font-weight: 700;
        text-align: center;
        margin: 50px 0 25px;
    }


    /* =========================================
       CONTENT CARDS
    ========================================= */

    .content-card {
        height: 100%;
        background-color: #f2f2f2;
        border-radius: 20px;
        padding: 25px;
        border: none;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
    }


    .content-card h3 {
        color: #1A2601;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 10px;
    }


    .content-card p {
        color: #666666;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }


    .content-status {
        font-size: 0.75rem;
        color: #5d7034;
        font-weight: 600;
        margin-bottom: 18px;
    }


    .content-status-inactive {
        font-size: 0.75rem;
        color: #888888;
        font-weight: 600;
        margin-bottom: 18px;
    }


    .content-actions {
        display: flex;
        gap: 8px;
    }


    .edit-button,
    .delete-button {
        flex: 1;
        text-align: center;
        padding: 8px 10px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
    }


    .edit-button {
        background-color: #A77E34;
        color: #ffffff;
    }


    .edit-button:hover {
        background-color: #8f692b;
        color: #ffffff;
    }


    .delete-button {
        background-color: #757B4B;
        color: #ffffff;
    }


    .delete-button:hover {
        background-color: #60643c;
        color: #ffffff;
    }


    /* =========================================
       ALERTS
    ========================================= */

    .dashboard-alert {
        max-width: 700px;
        margin: 0 auto 30px;
        border: none;
        border-radius: 15px;
        text-align: center;
    }

</style>


<!-- Script para garantir a atualização do título da aba no navegador -->
<script>
    document.title = "Gerenciar Matérias | <?= addslashes(NOME_SISTEMA) ?>";
</script>


<!-- =========================================
     PAGE HERO
========================================= -->

<section class="dashboard-hero">

    <h1>
        Gerenciar Matérias
    </h1>

    <p>
        Área do administrador
    </p>

</section>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="dashboard-content">

    <!-- =========================================
         SUCCESS MESSAGES
    ========================================= -->

    <?php if (isset($_GET['sucesso'])): ?>

        <div class="alert alert-success dashboard-alert">

            <?php

            switch ($_GET['sucesso']) {

                case 'criado':
                    echo 'Matéria cadastrada com sucesso.';
                    break;

                case 'editado':
                    echo 'Matéria atualizada com sucesso.';
                    break;

                case 'excluido':
                    echo 'Matéria excluída com sucesso.';
                    break;

                default:
                    echo 'Operação realizada com sucesso.';
            }

            ?>

        </div>

    <?php endif; ?>


    <!-- =========================================
         ERROR MESSAGES
    ========================================= -->

    <?php if (isset($_GET['erro'])): ?>

        <div class="alert alert-danger dashboard-alert">

            Não foi possível realizar a operação. Verifique os dados e tente novamente.

        </div>

    <?php endif; ?>


    <!-- =========================================
         FORM CARD
    ========================================= -->

    <section>

        <div class="dashboard-card mb-5">

            <h2 class="dashboard-card-title">

                <?= $materiaEditar ? 'Editar Matéria' : 'Cadastrar Matéria'; ?>

            </h2>


            <form
                method="POST"
                action="../controllers/AdminController.php?acao=<?= $materiaEditar ? 'materia_editar' : 'materia_criar'; ?>"
            >

                <?php if ($materiaEditar): ?>

                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $materiaEditar['id']; ?>"
                    >

                <?php endif; ?>


                <div class="row g-4">

                    <div class="col-12">

                        <label class="dashboard-label">
                            Nome da matéria
                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="dashboard-input"
                            placeholder="Digite o nome da matéria"
                            value="<?= $materiaEditar ? htmlspecialchars($materiaEditar['nome']) : ''; ?>"
                            required
                        >

                    </div>


                    <div class="col-12">

                        <label class="dashboard-label">
                            Descrição
                        </label>

                        <textarea
                            name="descricao"
                            class="dashboard-textarea"
                            placeholder="Digite uma descrição para a matéria"
                            rows="3"
                        ><?= $materiaEditar ? htmlspecialchars($materiaEditar['descricao']) : ''; ?></textarea>

                    </div>


                    <?php if ($materiaEditar): ?>

                        <div class="col-12">

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    name="ativo"
                                    class="form-check-input"
                                    id="ativo"
                                    <?= (int) $materiaEditar['ativo'] === 1 ? 'checked' : ''; ?>
                                >

                                <label
                                    class="form-check-label dashboard-label ms-1"
                                    for="ativo"
                                >
                                    Matéria ativa
                                </label>

                            </div>

                        </div>

                    <?php endif; ?>


                    <div class="col-12 text-center">

                        <button
                            type="submit"
                            class="dashboard-button"
                        >

                            <?= $materiaEditar ? 'Salvar Alterações' : 'Cadastrar Matéria'; ?>

                        </button>


                        <?php if ($materiaEditar): ?>

                            <a
                                href="materias.php"
                                class="dashboard-cancel ms-2"
                            >

                                Cancelar

                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </form>

        </div>

    </section>


    <!-- =========================================
         LIST SECTION
    ========================================= -->

    <section>

        <h2 class="contents-title">
            Matérias Cadastradas
        </h2>


        <div class="row g-4">

            <?php foreach ($materias as $materia): ?>

                <div class="col-md-6 col-lg-4">

                    <article class="content-card">

                        <h3>
                            <?= htmlspecialchars($materia['nome']); ?>
                        </h3>


                        <p>
                            <?= htmlspecialchars($materia['descricao'] ?? ''); ?>
                        </p>


                        <div class="<?= (int) $materia['ativo'] === 1 ? 'content-status' : 'content-status-inactive'; ?>">

                            ● <?= (int) $materia['ativo'] === 1 ? 'Matéria ativa' : 'Matéria inativa'; ?>

                        </div>


                        <div class="content-actions">

                            <a
                                href="materias.php?editar=<?= (int) $materia['id']; ?>"
                                class="edit-button"
                            >

                                Editar

                            </a>


                            <a
                                href="../controllers/AdminController.php?acao=materia_excluir&id=<?= (int) $materia['id']; ?>"
                                class="delete-button"
                                onclick="return confirm('Excluir esta matéria? Todos os conteúdos ligados a ela também serão excluídos.');"
                            >

                                Excluir

                            </a>

                        </div>

                    </article>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

</main>


<?php include(__DIR__ . '/../includes/footer.php'); ?>