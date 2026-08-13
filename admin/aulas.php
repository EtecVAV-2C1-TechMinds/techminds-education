<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - MANAGE CLASSES
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$aulas = $aulaModel->listar();

?>

<?php include('../includes/header.php'); ?>

<?php include('../includes/navbar.php'); ?>


<!-- =========================================
     PAGE HEADER
========================================= -->

<section class="py-5" style="background-color: var(--green-main); color: white;">

    <div class="container">

        <div class="text-center">

            <h1 class="fw-bold">
                Gerenciar Aulas
            </h1>

            <p class="mb-0">
                Área do administrador
            </p>

        </div>

    </div>

</section>


<!-- =========================================
     CLASSES LIST
========================================= -->

<main class="container py-5">

    <!-- TOP ACTION -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Aulas cadastradas
            </h2>

            <p class="text-muted mb-0">
                Consulte, edite ou exclua as aulas da plataforma.
            </p>

        </div>


        <!-- LINK ATUALIZADO PARA PAGES -->
        <a href="../pages/cadastroaula.php" class="btn btn-tech">

            + Cadastrar nova aula

        </a>

    </div>


    <!-- SUCCESS / ERROR MESSAGES -->

    <?php if (isset($_GET['sucesso'])): ?>

        <div class="alert alert-success">

            <?php

            switch ($_GET['sucesso']) {

                case 'criado':
                    echo 'Aula cadastrada com sucesso.';
                    break;

                case 'editado':
                    echo 'Aula editada com sucesso.';
                    break;

                case 'excluido':
                    echo 'Aula excluída com sucesso.';
                    break;

                default:
                    echo 'Operação realizada com sucesso.';
            }

            ?>

        </div>

    <?php endif; ?>


    <?php if (isset($_GET['erro'])): ?>

        <div class="alert alert-danger">

            Não foi possível realizar a operação.

        </div>

    <?php endif; ?>


    <!-- =========================================
         CHECK IF THERE ARE CLASSES
    ========================================== -->

    <?php if (!empty($aulas)): ?>


        <div class="row g-4">


            <?php foreach ($aulas as $aula): ?>


                <div class="col-12 col-lg-6">


                    <div class="card border-0 shadow-sm h-100">


                        <div class="card-body p-4">


                            <!-- CONTENT -->

                            <p class="text-muted mb-1">

                                Conteúdo:

                            </p>


                            <h5 class="fw-bold">

                                <?= htmlspecialchars(
                                    $aula['conteudo']
                                ); ?>

                            </h5>


                            <hr>


                            <!-- CLASS TITLE -->

                            <h4 class="fw-bold mb-3">

                                <?= htmlspecialchars(
                                    $aula['titulo']
                                ); ?>

                            </h4>


                            <!-- DESCRIPTION -->

                            <p class="text-muted">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $aula['descricao']
                                    )
                                ); ?>

                            </p>


                            <!-- ORDER -->

                            <p class="mb-3">

                                <strong>
                                    Ordem:
                                </strong>

                                <?= (int) $aula['ordem']; ?>

                            </p>


                            <!-- STATUS -->

                            <p class="mb-4">

                                <strong>
                                    Status:
                                </strong>


                                <?php if ((int) $aula['ativo'] === 1): ?>

                                    <span class="badge bg-success">
                                        Ativa
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-secondary">
                                        Inativa
                                    </span>

                                <?php endif; ?>

                            </p>


                            <!-- ACTIONS -->

                            <div class="d-flex gap-2 flex-wrap">


                                <!-- EDIT (ATUALIZADO PARA A PASTA PAGES) -->

                                <a
                                    href="../admin/editar_aula.php?id=<?= (int) $aula['id']; ?>"
                                    class="btn btn-tech"
                                >

                                    Editar

                                </a>


                                <!-- DELETE -->

                                <a
                                    href="../controllers/AulaController.php?acao=excluir&id=<?= (int) $aula['id']; ?>"
                                    class="btn btn-outline-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir esta aula?');"
                                >

                                    Excluir

                                </a>


                            </div>


                        </div>

                    </div>


                </div>


            <?php endforeach; ?>


        </div>


    <?php else: ?>


        <!-- =========================================
             EMPTY STATE
        ========================================== -->

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center p-5">


                <h3 class="fw-bold mb-3">

                    Nenhuma aula cadastrada

                </h3>


                <p class="text-muted mb-4">

                    Ainda não existem aulas cadastradas
                    nesta plataforma.

                </p>


                <!-- LINK ATUALIZADO PARA PAGES -->
                <a
                    href="../pages/cadastro_aula.php"
                    class="btn btn-tech"
                >

                    Cadastrar primeira aula

                </a>


            </div>

        </div>


    <?php endif; ?>


</main>


<?php include('../includes/footer.php'); ?>
