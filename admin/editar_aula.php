<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - EDIT CLASS
========================================= */

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

?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>


<section class="py-5"
         style="background-color: var(--green-main); color: white;">

    <div class="container text-center">

        <h1 class="fw-bold">
            Editar Aula
        </h1>

        <p class="mb-0">
            Área do administrador
        </p>

    </div>

</section>


<main class="container py-5">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4 p-lg-5">

            <form
                method="POST"
                action="../controllers/AulaController.php?acao=editar"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $aula['id']; ?>"
                >


                <!-- CONTEÚDO -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Conteúdo
                    </label>

                    <select
                        name="conteudo_id"
                        class="form-select"
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

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Título da aula
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        class="form-control"
                        value="<?= htmlspecialchars($aula['titulo']); ?>"
                        required
                    >

                </div>


                <!-- DESCRIÇÃO -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Descrição
                    </label>

                    <textarea
                        name="descricao"
                        class="form-control"
                        rows="5"
                        required
                    ><?= htmlspecialchars($aula['descricao']); ?></textarea>

                </div>


                <!-- VÍDEO -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Link do vídeo
                    </label>

                    <input
                        type="text"
                        name="video"
                        class="form-control"
                        value="<?= htmlspecialchars($aula['video'] ?? ''); ?>"
                    >

                </div>


                <!-- MATERIAL -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Material
                    </label>

                    <input
                        type="text"
                        name="material"
                        class="form-control"
                        value="<?= htmlspecialchars($aula['material'] ?? ''); ?>"
                    >

                </div>


                <!-- ORDEM -->

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Ordem
                    </label>

                    <input
                        type="number"
                        name="ordem"
                        class="form-control"
                        min="1"
                        value="<?= (int) $aula['ordem']; ?>"
                        required
                    >

                </div>


                <!-- BOTÕES -->

                <div class="d-flex gap-2 flex-wrap">

                    <button
                        type="submit"
                        class="btn btn-tech"
                    >

                        Salvar alterações

                    </button>

                    <a
                        href="aulas.php"
                        class="btn btn-outline-secondary"
                    >

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</main>


<?php include('../includes/footer.php'); ?>
