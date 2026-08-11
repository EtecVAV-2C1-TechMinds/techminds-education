<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN DASHBOARD
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';


/* =========================================
   CREATE CONTENT MODEL
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

        $conteudoEditar = $conteudoModel->buscarPorId($id);
    }
}

// Define o título para a tag <title> no header.php
$title = "Painel Administrativo | TechMinds Education";

// Includes do Header e da Navbar padrão do projeto
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilos exclusivos do Dashboard -->
<style>

    /* =========================================
       DASHBOARD PAGE
    ========================================= */

    body {
        background-color: #ffffff;
        color: #333333;
    }


    /* =========================================
       ADMIN HEADER
    ========================================= */

    .admin-header {
        background-color: #1A2601;
        min-height: 80px;
        display: flex;
        align-items: center;
    }


    .admin-logo {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
    }


    .admin-menu {
        width: 34px;
        height: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }


    .admin-menu span {
        display: block;
        width: 100%;
        height: 2px;
        background-color: #ffffff;
        border-radius: 10px;
    }


    /* =========================================
       PAGE TITLE
    ========================================= */

    .dashboard-hero {
        background-color: #93A651;
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
        box-shadow: inset 0 0 0 2px #93A651;
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


    .contents-count {
        display: block;
        width: fit-content;
        margin: 0 auto 30px;
        background-color: #93A651;
        color: #ffffff;
        padding: 5px 18px;
        border-radius: 20px;
        font-size: 0.85rem;
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


    .content-subject {
        display: inline-block;
        background-color: #757B4B;
        color: #ffffff;
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 0.75rem;
        margin-bottom: 15px;
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
       EMPTY CONTENT MESSAGE
    ========================================= */

    .empty-content {
        background-color: #f2f2f2;
        border-radius: 20px;
        padding: 45px 20px;
        text-align: center;
    }


    .empty-content h3 {
        color: #1A2601;
        font-size: 1.1rem;
        font-weight: 700;
    }


    .empty-content p {
        color: #777777;
        margin-bottom: 0;
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


    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 768px) {

        .admin-header {
            min-height: 65px;
        }


        .admin-logo {
            font-size: 0.95rem;
        }


        .dashboard-hero {
            padding: 35px 20px;
        }


        .dashboard-hero h1 {
            font-size: 1.65rem;
        }


        .dashboard-content {
            padding: 30px 15px;
        }


        .dashboard-card {
            padding: 22px 18px;
            border-radius: 18px;
        }


        .dashboard-card-title {
            font-size: 1.25rem;
        }


        .contents-title {
            font-size: 1.4rem;
            margin-top: 40px;
        }


        .content-card {
            padding: 22px;
        }

    }

</style>


<!-- Script para garantir a atualização do título da aba no navegador -->
<script>
    document.title = "Painel Administrativo | TechMinds Education";
</script>


<!-- =========================================
     PAGE HERO
========================================= -->

<section class="dashboard-hero">

    <h1>
        Painel Administrativo
    </h1>

    <p>
        Área de gerenciamento da plataforma
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

        <div class="alert alert-danger dashboard-alert">

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

    <section>

        <div class="dashboard-card">

            <h2 class="dashboard-card-title">

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
                            class="dashboard-label"
                        >

                            Matéria

                        </label>


                        <select
                            name="materia_id"
                            id="materia_id"
                            class="dashboard-select"
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
                            class="dashboard-label"
                        >

                            Título

                        </label>


                        <input
                            type="text"
                            name="titulo"
                            id="titulo"
                            class="dashboard-input"
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
                            class="dashboard-label"
                        >

                            Descrição

                        </label>


                        <textarea
                            name="descricao"
                            id="descricao"
                            class="dashboard-textarea"
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

                    <div class="col-12 text-center">


                        <button
                            type="submit"
                            class="dashboard-button"
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
         CONTENT LIST
    ========================================= -->

    <section>

        <h2 class="contents-title">

            Conteúdos Cadastrados

        </h2>


        <span class="contents-count">

            <?php echo count($conteudos); ?>

            <?php

            echo count($conteudos) == 1
                ? ' conteúdo'
                : ' conteúdos';

            ?>

        </span>



        <?php if (empty($conteudos)): ?>


            <div class="empty-content">

                <h3>

                    Nenhum conteúdo cadastrado

                </h3>


                <p>

                    Cadastre o primeiro conteúdo
                    utilizando o formulário acima.

                </p>

            </div>


        <?php else: ?>


            <div class="row g-4">


                <?php foreach ($conteudos as $conteudo): ?>


                    <div class="col-md-6 col-lg-4">


                        <article class="content-card">


                            <!-- Subject -->

                            <span class="content-subject">

                                <?php

                                echo htmlspecialchars(
                                    $conteudo['materia']
                                );

                                ?>

                            </span>



                            <!-- Title -->

                            <h3>

                                <?php

                                echo htmlspecialchars(
                                    $conteudo['titulo']
                                );

                                ?>

                            </h3>



                            <!-- Description -->

                            <p>

                                <?php

                                echo htmlspecialchars(
                                    $conteudo['descricao']
                                );

                                ?>

                            </p>



                            <!-- Status -->

                            <div class="content-status">

                                ● Conteúdo ativo

                            </div>



                            <!-- Actions -->

                            <div class="content-actions">


                                <a
                                    href="dashboard.php?editar=<?php echo $conteudo['id']; ?>"
                                    class="edit-button"
                                >

                                    Editar

                                </a>


                                <a
                                    href="../controllers/ConteudoController.php?acao=excluir&id=<?php echo $conteudo['id']; ?>"
                                    class="delete-button"

                                    onclick="return confirm('Tem certeza que deseja excluir este conteúdo?');"
                                >

                                    Excluir

                                </a>


                            </div>


                        </article>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </section>


</main>



<!-- =========================================
     FOOTER REUTILIZÁVEL DO SITE
========================================= -->

<?php include(__DIR__ . '/../includes/footer.php'); ?>
