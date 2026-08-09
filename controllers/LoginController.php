<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN DASHBOARD
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';


/* =========================================
   CREATE MODEL
========================================= */

$conteudoModel = new Conteudo();


/* =========================================
   LOAD DATA
========================================= */

$conteudos = $conteudoModel->listar();

$materias = $conteudoModel->listarMaterias();


/* =========================================
   EDIT CONTENT
========================================= */

$conteudoEditar = null;

if (isset($_GET['editar'])) {

    $id = (int) $_GET['editar'];

    if ($id > 0) {

        $conteudoEditar =
            $conteudoModel->buscarPorId($id);
    }
}

?>


<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Painel Administrativo | TechMinds Education
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Project CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body>


<!-- =========================================
     ADMIN NAVBAR
========================================= -->

<nav class="navbar navbar-dark">

    <div class="container">

        <span class="navbar-brand fw-bold">

            TechMinds Education

        </span>


        <a
            href="../index.php"
            class="btn btn-outline-light btn-sm"
        >

            Voltar ao site

        </a>

    </div>

</nav>



<!-- =========================================
     MAIN CONTENT
========================================= -->

<main class="container py-5">


    <!-- Page heading -->

    <div class="mb-5">

        <h1 class="fw-bold">

            Painel Administrativo

        </h1>

        <p class="text-muted">

            Gerencie os conteúdos da plataforma
            TechMinds Education.

        </p>

    </div>



    <!-- =========================================
         SUCCESS MESSAGES
    ========================================= -->

    <?php if (isset($_GET['sucesso'])): ?>

        <div class="alert alert-success">

            <?php

            switch ($_GET['sucesso']) {

                case 'criado':

                    echo 'Conteúdo cadastrado com sucesso.';

                    break;


                case 'editado':

                    echo 'Conteúdo atualizado com sucesso.';

                    break;


                case 'excluido':

                    echo 'Conteúdo excluído com sucesso.';

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

        <div class="alert alert-danger">

            <?php

            switch ($_GET['erro']) {

                case 'preencha':

                    echo 'Preencha todos os campos.';

                    break;


                case 'criar':

                    echo 'Não foi possível cadastrar o conteúdo.';

                    break;


                case 'editar':

                    echo 'Não foi possível atualizar o conteúdo.';

                    break;


                case 'excluir':

                    echo 'Não foi possível excluir o conteúdo.';

                    break;


                default:

                    echo 'Ocorreu um erro.';
            }

            ?>

        </div>

    <?php endif; ?>



    <!-- =========================================
         CONTENT FORM
    ========================================= -->

    <div class="card border-0 shadow-sm mb-5">

        <div class="card-body p-4 p-lg-5">


            <h2 class="h4 fw-bold mb-4">

                <?php if ($conteudoEditar): ?>

                    Editar Conteúdo

                <?php else: ?>

                    Cadastrar Conteúdo

                <?php endif; ?>

            </h2>



            <form
                method="POST"
                action="../controllers/ConteudoController.php?acao=<?php echo $conteudoEditar ? 'editar' : 'criar'; ?>"
            >


                <!-- Hidden ID -->

                <?php if ($conteudoEditar): ?>

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $conteudoEditar['id']; ?>"
                    >

                <?php endif; ?>



                <div class="row g-4">


                    <!-- Subject -->

                    <div class="col-md-6">

                        <label
                            for="materia_id"
                            class="form-label fw-semibold"
                        >

                            Matéria

                        </label>


                        <select
                            name="materia_id"
                            id="materia_id"
                            class="form-select"
                            required
                        >

                            <option value="">

                                Selecione uma matéria

                            </option>


                            <?php foreach ($materias as $materia): ?>

                                <option
                                    value="<?php echo $materia['id']; ?>"

                                    <?php

                                    if (
                                        $conteudoEditar &&
                                        $conteudoEditar['materia_id']
                                        == $materia['id']
                                    ) {

                                        echo 'selected';
                                    }

                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $materia['nome']
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>



                    <!-- Title -->

                    <div class="col-md-6">

                        <label
                            for="titulo"
                            class="form-label fw-semibold"
                        >

                            Título

                        </label>


                        <input
                            type="text"
                            name="titulo"
                            id="titulo"
                            class="form-control"
                            placeholder="Digite o título do conteúdo"

                            value="<?php

                            echo $conteudoEditar
                                ? htmlspecialchars(
                                    $conteudoEditar['titulo']
                                )
                                : '';

                            ?>"

                            required
                        >

                    </div>



                    <!-- Description -->

                    <div class="col-12">

                        <label
                            for="descricao"
                            class="form-label fw-semibold"
                        >

                            Descrição

                        </label>


                        <textarea
                            name="descricao"
                            id="descricao"
                            class="form-control"
                            rows="5"
                            placeholder="Digite uma descrição para o conteúdo"
                            required
                        ><?php

                        echo $conteudoEditar
                            ? htmlspecialchars(
                                $conteudoEditar['descricao']
                            )
                            : '';

                        ?></textarea>

                    </div>



                    <!-- Buttons -->

                    <div class="col-12 d-flex gap-2">


                        <button
                            type="submit"
                            class="btn btn-tech px-4"
                        >

                            <?php if ($conteudoEditar): ?>

                                Salvar Alterações

                            <?php else: ?>

                                Cadastrar Conteúdo

                            <?php endif; ?>

                        </button>



                        <?php if ($conteudoEditar): ?>

                            <a
                                href="dashboard.php"
                                class="btn btn-outline-secondary"
                            >

                                Cancelar

                            </a>

                        <?php endif; ?>


                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- =========================================
         CONTENT LIST
    ========================================= -->

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4 p-lg-5">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="h4 fw-bold mb-0">

                    Conteúdos cadastrados

                </h2>


                <span class="badge text-bg-secondary">

                    <?php echo count($conteudos); ?>

                </span>

            </div>



            <?php if (empty($conteudos)): ?>


                <div class="text-center py-5">

                    <h3 class="h5">

                        Nenhum conteúdo cadastrado

                    </h3>


                    <p class="text-muted mb-0">

                        Cadastre o primeiro conteúdo usando
                        o formulário acima.

                    </p>

                </div>


            <?php else: ?>


                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Matéria
                                </th>

                                <th>
                                    Título
                                </th>

                                <th>
                                    Descrição
                                </th>

                                <th>
                                    Status
                                </th>

                                <th class="text-end">
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($conteudos as $conteudo): ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <?php
                                        echo $conteudo['id'];
                                        ?>

                                    </td>



                                    <!-- Subject -->

                                    <td>

                                        <span class="fw-semibold">

                                            <?php

                                            echo htmlspecialchars(
                                                $conteudo['materia']
                                            );

                                            ?>

                                        </span>

                                    </td>



                                    <!-- Title -->

                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $conteudo['titulo']
                                        );

                                        ?>

                                    </td>



                                    <!-- Description -->

                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $conteudo['descricao']
                                        );

                                        ?>

                                    </td>



                                    <!-- Status -->

                                    <td>

                                        <?php if ($conteudo['ativo']): ?>

                                            <span class="badge text-bg-success">

                                                Ativo

                                            </span>

                                        <?php else: ?>

                                            <span class="badge text-bg-secondary">

                                                Inativo

                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- Actions -->

                                    <td class="text-end">


                                        <a
                                            href="dashboard.php?editar=<?php echo $conteudo['id']; ?>"
                                            class="btn btn-sm btn-outline-primary"
                                        >

                                            Editar

                                        </a>


                                        <a
                                            href="../controllers/ConteudoController.php?acao=excluir&id=<?php echo $conteudo['id']; ?>"
                                            class="btn btn-sm btn-outline-danger"

                                            onclick="return confirm('Tem certeza que deseja excluir este conteúdo?');"
                                        >

                                            Excluir

                                        </a>


                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        </tbody>

                    </table>

                </div>


            <?php endif; ?>


        </div>

    </div>


</main>



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>
