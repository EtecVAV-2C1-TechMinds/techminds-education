<?php
/* =========================================
   TECHMINDS EDUCATION
   SUBJECTS PAGE
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';

/* =========================================
   CREATE CONTENT MODEL
========================================= */
$conteudoModel = new Conteudo();

/* =========================================
   GET SUBJECTS AND CONTENTS
========================================= */
$materias = $conteudoModel->listarMaterias();
$conteudos = $conteudoModel->listar();

/* =========================================
   ORGANIZE CONTENTS BY SUBJECT
========================================= */
$conteudosPorMateria = [];

foreach ($conteudos as $conteudo) {
    $materiaId = $conteudo['materia_id'] ?? null;
    if ($materiaId !== null) {
        $conteudosPorMateria[$materiaId][] = $conteudo;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- =========================================
         PAGE CONFIGURATION
    ========================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Conteúdos | TechMinds Education</title>

    <!-- =========================================
         BOOTSTRAP
    ========================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- =========================================
         MAIN STYLESHEET
    ========================================== -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- ESTILO DEDICADO PARA OS LINKS DOS CARDS -->
    <style>
        .subject-card .content-list li a,
        .subject-card .content-list li a:link,
        .subject-card .content-list li a:visited {
            color: #283818 !important; /* Verde oliva escuro harmonizado */
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: color 0.2s ease-in-out;
        }

        .subject-card .content-list li a:hover,
        .subject-card .content-list li a:focus {
            color: #16240d !important; /* Verde ainda mais escuro ao passar o mouse */
            text-decoration: underline !important;
        }
    </style>
</head>

<body>

<!-- =========================================
     NAVBAR
========================================= -->
<?php require_once __DIR__ . '/../includes/navbar.php'; ?>

<!-- =========================================
     PAGE HEADER
========================================= -->
<section class="subjects-header text-center py-5">
    <div class="container">
        <h1 class="fw-bold">Conteúdos</h1>
        <p class="mb-0">Ciências e suas tecnologias</p>
    </div>
</section>

<!-- =========================================
     SUBJECTS AREA
========================================= -->
<section class="subjects-section py-5">
    <div class="container">
        <div class="subjects-container d-flex flex-column align-items-center gap-4">

            <?php if (!empty($materias)): ?>

                <?php foreach ($materias as $materia): ?>
                    <?php
                    $materiaId = $materia['id'];
                    $listaConteudos = $conteudosPorMateria[$materiaId] ?? [];
                    ?>

                    <!-- =========================================
                         SUBJECT CARD
                    ========================================== -->
                    <div class="subject-card w-100 max-w-600 p-4 rounded-4 shadow-sm">
                        <!-- Subject name -->
                        <h2 class="h4 fw-bold text-white mb-3">
                            <?= htmlspecialchars($materia['nome']); ?>
                        </h2>

                        <!-- CONTENTS -->
                        <?php if (!empty($listaConteudos)): ?>
                            <ul class="content-list mb-0 ps-4">
                                <?php foreach ($listaConteudos as $conteudo): ?>
                                    <li>
                                        <a
                                            href="conteudo.php?id=<?= (int) $conteudo['id']; ?>"
                                            style="color: #283818 !important; text-decoration: none; font-weight: 600;"
                                        >
                                            <?= htmlspecialchars($conteudo['titulo']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="no-content mb-0 text-white-50">
                                Nenhum conteúdo disponível no momento.
                            </p>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <!-- =========================================
                     EMPTY SUBJECTS
                ========================================== -->
                <div class="empty-subjects text-center my-5">
                    <h2>Nenhuma matéria disponível</h2>
                    <p class="text-muted">Os conteúdos serão disponibilizados em breve.</p>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<!-- =========================================
     FOOTER
========================================= -->
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<!-- =========================================
     BOOTSTRAP JAVASCRIPT
========================================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
