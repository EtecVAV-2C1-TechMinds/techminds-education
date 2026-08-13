<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTENTS BY SUBJECT
========================================= */



require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Conteudo.php';

$materiaId = (int) ($_GET['materia_id'] ?? 0);

if ($materiaId <= 0) {
    header('Location: materias.php');
    exit;
}

/* =========================================
   BUSCAR NOME DA MATÉRIA
========================================= */

$sqlMateria = "
    SELECT nome
    FROM materias
    WHERE id = :id
    AND ativo = 1
";

$stmtMateria = $pdo->prepare($sqlMateria);

$stmtMateria->execute([
    ':id' => $materiaId
]);

$materia = $stmtMateria->fetch(PDO::FETCH_ASSOC);

if (!$materia) {
    header('Location: materias.php');
    exit;
}

$nomeMateria = $materia['nome'];

/* =========================================
   LOAD CONTENTS
========================================= */

$conteudoModel = new Conteudo();

$conteudos = $conteudoModel->listarPorMateria($materiaId);


/* =========================================
   GET SUBJECT NAME
========================================= */

$materiaNome = 'Conteúdos';


if (!empty($conteudos)) {

    $materiaNome = $conteudos[0]['materia'] ?? 'Conteúdos';

}


$title = "Conteúdos | TechMinds Education";


/* =========================================
   INCLUDES
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<style>

    .contents-page {

        background-color: #f1f1f1;

        min-height: 600px;

        padding: 40px 20px 70px;

    }


    .contents-container {

        max-width: 1000px;

        margin: 0 auto;

    }


    .contents-header {

        background-color: var(--green-main);

        color: white;

        padding: 35px 25px;

        border-radius: 18px;

        margin-bottom: 30px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.08);

    }


    .contents-header h1 {

        margin: 0 0 8px;

        font-size: 30px;

        font-weight: 700;

    }


    .contents-header p {

        margin: 0;

        font-size: 15px;

        opacity: 0.95;

    }


    .contents-title {

        color: var(--green-dark);

        font-size: 24px;

        font-weight: 700;

        margin-bottom: 18px;

    }


    .content-card {

        background-color: #b0b29a;

        border-radius: 15px;

        padding: 22px 25px;

        margin-bottom: 15px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.08);

        transition: 0.2s;

    }


    .content-card:hover {

        transform: translateY(-2px);

        box-shadow:
            0 8px 18px rgba(0, 0, 0, 0.12);

    }


    .content-link {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        color: white;

        text-decoration: none;

    }


    .content-info {

        display: flex;

        align-items: center;

        gap: 15px;

    }


    .content-icon {

        width: 45px;

        height: 45px;

        border-radius: 50%;

        background-color: rgba(255,255,255,0.2);

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

    }


    .content-icon i {

        font-size: 18px;

        color: white;

    }


    .content-info h3 {

        margin: 0 0 4px;

        font-size: 18px;

        font-weight: 700;

        color: white;

    }


    .content-info p {

        margin: 0;

        font-size: 13px;

        color: rgba(255,255,255,0.85);

    }


    .content-arrow {

        font-size: 18px;

        color: white;

    }


    .empty-contents {

        background-color: white;

        border-radius: 15px;

        padding: 40px 25px;

        text-align: center;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.06);

    }


    .empty-contents i {

        font-size: 35px;

        color: var(--green-main);

        margin-bottom: 15px;

    }


    .empty-contents h3 {

        color: var(--green-dark);

        font-size: 20px;

        font-weight: 700;

    }


    .empty-contents p {

        color: #666;

        margin: 0;

    }


    @media (min-width: 768px) {

        .contents-page {

            padding: 55px 30px 80px;

        }


        .contents-header {

            padding: 45px 40px;

        }


        .contents-header h1 {

            font-size: 38px;

        }

    }

</style>


<main class="contents-page">

    <div class="contents-container">


        <!-- =========================================
             HEADER
        ========================================== -->

        <section class="contents-header">

            <h1>
                <?= htmlspecialchars($nomeMateria); ?>
            </h1>

            <p>
                Conteúdos com questões disponíveis para a matéria
            </p>

        </section>


        <!-- =========================================
             TITLE
        ========================================== -->

        <h2 class="contents-title">

            Conteúdos

        </h2>


        <!-- =========================================
             CONTENTS
        ========================================== -->

        <?php if (!empty($conteudos)): ?>


            <?php foreach ($conteudos as $conteudo): ?>


                <div class="content-card">

                    <a
                        href="questoes_conteudo.php?conteudo_id=<?= (int) $conteudo['id']; ?>"
                        class="content-link"
                    >

                        <div class="content-info">


                            <div class="content-icon">

                                <i class="fa-solid fa-book-open"></i>

                            </div>


                            <div>

                                <h3>

                                    <?= htmlspecialchars(
                                        $conteudo['titulo']
                                    ); ?>

                                </h3>


                                <?php if (!empty($conteudo['descricao'])): ?>

                                    <p>

                                        <?= htmlspecialchars(
                                            $conteudo['descricao']
                                        ); ?>

                                    </p>

                                <?php else: ?>

                                    <p>

                                        Clique para acessar este conteúdo.

                                    </p>

                                <?php endif; ?>

                            </div>


                        </div>


                        <i class="fa-solid fa-arrow-right content-arrow"></i>


                    </a>

                </div>


            <?php endforeach; ?>


        <?php else: ?>


            <div class="empty-contents">

                <i class="fa-solid fa-book-open"></i>

                <h3>

                    Nenhum conteúdo disponível

                </h3>

                <p>

                    Ainda não existem conteúdos cadastrados com questões para essa matéria.

                </p>

            </div>


        <?php endif; ?>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>
