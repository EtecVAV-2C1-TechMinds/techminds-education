<?php

/* =========================================
   TECHMINDS EDUCATION
   LESSON PAGE
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Aula.php';
require_once __DIR__ . '/../models/Progresso.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   GET LESSON ID
========================================= */

$aulaId = (int) ($_GET['id'] ?? 0);

if ($aulaId <= 0) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   LOAD LESSON
========================================= */

$aulaModel = new Aula();

$aula = $aulaModel->buscarPorId($aulaId);

if (!$aula) {

    header('Location: materias.php');
    exit;

}


/* =========================================
   PROGRESS (MARCAR COMO CONCLUÍDA)
========================================= */

$progressoModel = new Progresso();

$usuarioId = (int) ($_SESSION[SESSION_USUARIO] ?? 0);

$aulaConcluida = false;

if ($usuarioId > 0) {
    $aulaConcluida = $progressoModel->aulaConcluida($usuarioId, $aulaId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_concluir'])) {

    if ($usuarioId > 0) {
        $progressoModel->concluirAula($usuarioId, $aulaId);
        $aulaConcluida = true;
    }
}


/* =========================================
   LOAD OTHER LESSONS
========================================= */

$aulas = $aulaModel->listarPorConteudo(
    (int) $aula['conteudo_id']
);


/* =========================================
   PAGE TITLE
========================================= */

$title = htmlspecialchars(
    $aula['titulo']
) . " | " . NOME_SISTEMA;


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<style>

/* =========================================
   FIX FOOTER
========================================= */

body {
    overflow-x: hidden;
}


/* =========================================
   LESSON PAGE
========================================= */

.lesson-page {

    flex: 1;
    box-sizing: border-box;

    background-color: #f1f1f1;

    width: 100%;

    padding: 45px 20px 80px;

}

/* =========================================
   CONTAINER
========================================= */

.lesson-container {

    max-width: 1000px;

    margin: 0 auto;

}


/* =========================================
   BACK LINK
========================================= */

.back-link {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: var(--green-dark);

    text-decoration: none;

    font-weight: 600;

    margin-bottom: 20px;

}

.back-link:hover {

    color: var(--green-main);

}


/* =========================================
   LESSON CARD
========================================= */

.lesson-content {

    background-color: white;

    border-radius: 18px;

    padding: 35px;

    box-shadow:
        0 5px 18px rgba(0,0,0,0.08);

}


/* =========================================
   SUBJECT
========================================= */

.lesson-subject {

    color: var(--green-main);

    font-size: 14px;

    font-weight: 700;

    margin-bottom: 5px;

}


/* =========================================
   TITLE
========================================= */

.lesson-content h1 {

    color: var(--green-dark);

    font-size: 34px;

    font-weight: 700;

    margin-bottom: 20px;

}


/* =========================================
   DESCRIPTION
========================================= */

.lesson-description {

    color: #555;

    line-height: 1.7;

    margin-bottom: 30px;

}


/* =========================================
   VIDEO
========================================= */

.video-container {

    width: 100%;

    aspect-ratio: 16 / 9;

    background-color: #1c1c1c;

    border-radius: 15px;

    overflow: hidden;

    margin-bottom: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

}


.video-container video {

    width: 100%;

    height: 100%;

    object-fit: contain;

}


/* =========================================
   VIDEO PLACEHOLDER
========================================= */

.video-placeholder {

    text-align: center;

    color: white;

    padding: 30px;

}


.video-placeholder i {

    font-size: 45px;

    margin-bottom: 15px;

    opacity: 0.8;

}


.video-placeholder h3 {

    font-size: 20px;

    margin-bottom: 8px;

}


.video-placeholder p {

    margin: 0;

    opacity: 0.7;

    font-size: 14px;

}


/* =========================================
   MATERIAL
========================================= */

.material-box {

    background-color: #f5f5f5;

    border-radius: 12px;

    padding: 20px;

    margin-top: 25px;

    display: flex;

    align-items: center;

    gap: 15px;

}


.material-icon {

    width: 44px;

    height: 44px;

    border-radius: 10px;

    background-color: var(--green-main);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 18px;

    flex-shrink: 0;

}


.material-text {

    flex: 1;

    min-width: 0;

}


.material-text h3 {

    color: var(--green-dark);

    font-size: 16px;

    font-weight: 700;

    margin: 0 0 4px;

}


.material-text p {

    color: #777;

    font-size: 13px;

    margin: 0;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

}


.material-button {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background-color: var(--green-main);

    color: white;

    text-decoration: none;

    padding: 10px 18px;

    border-radius: 8px;

    font-weight: 600;

    flex-shrink: 0;

}


.material-button:hover {

    color: white;

    opacity: 0.9;

}


/* =========================================
   COMPLETE ACTION AT BOTTOM
========================================= */

.complete-section {

    margin-top: 30px;

    text-align: center;

}

.btn-complete {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    background-color: #e0e0e0;

    color: #444;

    border: none;

    padding: 12px 24px;

    border-radius: 8px;

    font-weight: 600;

    font-size: 15px;

    cursor: pointer;

    transition: 0.2s;

}

.btn-complete:hover {

    background-color: var(--green-main);

    color: white;

}

.btn-complete.completed {

    background-color: #2e7d32;

    color: white;

}


/* =========================================
   LESSON NAVIGATION
========================================= */

.lesson-navigation {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-top: 30px;

    padding-top: 25px;

    border-top: 1px solid #e5e5e5;

}


.lesson-navigation a {

    text-decoration: none;

    color: var(--green-dark);

    font-weight: 600;

}


.lesson-navigation a:hover {

    color: var(--green-main);

}



/* =========================================
   MOBILE
========================================= */

@media (max-width: 575px) {

    .lesson-page {

        padding: 30px 15px 60px;

    }


    .lesson-content {

        padding: 25px 20px;

    }


    .lesson-content h1 {

        font-size: 27px;

    }


    .material-box {

        flex-direction: column;

        align-items: stretch;

        text-align: center;

    }


    .btn-complete {

        width: 100%;

    }


    .lesson-navigation {

        flex-direction: column;

        align-items: stretch;

    }


    .lesson-navigation a {

        display: flex;

        justify-content: center;

        padding: 10px;

        background-color: #f5f5f5;

        border-radius: 8px;

    }

}

</style>


<!-- =========================================
     LESSON PAGE
========================================= -->

<main class="lesson-page">

    <div class="lesson-container">


        <!-- =========================================
             BACK
        ========================================== -->

        <a 
            href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>"
            class="back-link"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Voltar para aulas

        </a>


        <!-- =========================================
             LESSON
        ========================================== -->

        <article class="lesson-content">


            <!-- SUBJECT -->

            <div class="lesson-subject">

                <?= htmlspecialchars(
                    $aula['conteudo']
                ); ?>

            </div>


            <!-- TITLE -->

            <h1>

                <?= htmlspecialchars(
                    $aula['titulo']
                ); ?>

            </h1>


            <!-- DESCRIPTION -->

            <?php if (!empty($aula['descricao'])): ?>

                <div class="lesson-description">

                    <?= nl2br(
                        htmlspecialchars(
                            $aula['descricao']
                        )
                    ); ?>

                </div>

            <?php endif; ?>


            <!-- =========================================
                 VIDEO
            ========================================== -->

            <div class="video-container">


                <?php if (!empty($aula['video'])): ?>

                    <video
                        controls
                        preload="metadata"
                    >

                        <source
                            src="<?= htmlspecialchars($aula['video']); ?>"
                        >

                        Seu navegador não suporta
                        reprodução de vídeo.

                    </video>


                <?php else: ?>


                    <div class="video-placeholder">

                        <i class="fa-solid fa-circle-play"></i>

                        <h3>

                            Vídeo da aula

                        </h3>

                        <p>

                            O vídeo desta aula será
                            disponibilizado em breve.

                        </p>

                    </div>


                <?php endif; ?>


            </div>


            <!-- =========================================
                 MATERIAL (PDF / APOSTILA)
            ========================================== -->

            <?php if (!empty($aula['material'])): ?>

                <?php
                    $extensaoMaterial = strtolower(
                        pathinfo($aula['material'], PATHINFO_EXTENSION)
                    );
                    $ehPdf = $extensaoMaterial === 'pdf';
                ?>

                <div class="material-box">

                    <div class="material-icon">

                        <i class="fa-solid <?= $ehPdf ? 'fa-file-pdf' : 'fa-file-arrow-down'; ?>"></i>

                    </div>

                    <div class="material-text">

    <h3>
        <?= $ehPdf ? 'Apostila em PDF' : 'Material da aula'; ?>
    </h3>

    <p>
        <?= $ehPdf
            ? 'Baixe o material de apoio desta aula.'
            : htmlspecialchars($aula['material']); ?>
    </p>

</div>

<a
    href="<?= htmlspecialchars($aula['material']); ?>"
    target="_blank"
    rel="noopener noreferrer"
    class="material-button"
>
    <i class="fa-solid fa-download"></i>
    Acessar material
</a>


                </div>

            <?php endif; ?>


            <!-- =========================================
                 MARCAR COMO CONCLUÍDA (NO FINAL)
            ========================================== -->

            <div class="complete-section">

                <form method="POST">

                    <button 
                        type="submit" 
                        name="acao_concluir" 
                        class="btn-complete <?= $aulaConcluida ? 'completed' : ''; ?>"
                    >

                        <i class="fa-solid <?= $aulaConcluida ? 'fa-circle-check' : 'fa-circle'; ?>"></i>

                        <?= $aulaConcluida ? 'Aula Concluída' : 'Marcar como concluída'; ?>

                    </button>

                </form>

            </div>


            <!-- =========================================
                 LESSON NAVIGATION
            ========================================== -->

            <?php

            $indiceAtual = null;

            foreach ($aulas as $indice => $item) {

                if (
                    (int) $item['id']
                    === (int) $aula['id']
                ) {

                    $indiceAtual = $indice;

                    break;

                }

            }

            ?>


            <div class="lesson-navigation">


                <!-- PREVIOUS -->

                <?php if (
                    $indiceAtual !== null
                    && $indiceAtual > 0
                ): ?>

                    <?php
                    $anterior =
                        $aulas[$indiceAtual - 1];
                    ?>

                    <a 
                        href="aula.php?id=<?= (int) $anterior['id']; ?>"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Aula anterior

                    </a>

                <?php else: ?>

                    <span></span>

                <?php endif; ?>


                <!-- NEXT -->

                <?php if (
                    $indiceAtual !== null
                    && $indiceAtual < count($aulas) - 1
                ): ?>

                    <?php
                    $proxima =
                        $aulas[$indiceAtual + 1];
                    ?>

                    <a 
                        href="aula.php?id=<?= (int) $proxima['id']; ?>"
                    >

                        Próxima aula

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                <?php endif; ?>


            </div>


        </article>


    </div>

</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento do código
Finalidade: Otimização da lógica de scripts e apoio na estruturação das tags. 
Validação: Script revisado linha a linha, corrigido manualmente e validado quanto ao funcionamento final.
*/
?>
