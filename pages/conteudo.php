<?php
/* =========================================
   TECHMINDS EDUCATION
   CONTENT PAGE
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';

/* =========================================
   GET CONTENT ID
========================================= */
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

/* =========================================
   VALIDATE ID
========================================= */
if ($id <= 0) {
    header('Location: materias.php');
    exit;
}

/* =========================================
   LOAD CONTENT
========================================= */
try {
    $conteudoModel = new Conteudo();
    $conteudo = $conteudoModel->buscarPorId($id);
} catch (PDOException $e) {
    $conteudo = false;
}

/* =========================================
   CONTENT NOT FOUND
========================================= */
if (!$conteudo) {
    header('Location: materias.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($conteudo['titulo']); ?> | TechMinds Education
    </title>

    <!-- =========================================
         BOOTSTRAP
    ========================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- =========================================
         MAIN STYLESHEET
    ========================================== -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- =========================================
         CONTENT PAGE STYLE
    ========================================== -->
    <style>
        .content-header {
            background-color: var(--green-main);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .content-header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }

        .content-header p {
            margin-top: 10px;
            margin-bottom: 0;
            font-size: 15px;
        }

        .content-section {
            background-color: #f1f1f1;
            min-height: 500px;
            padding: 40px 20px 60px;
        }

        .content-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .content-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .content-card h2 {
            color: var(--green-dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .content-card .content-description {
            color: #4f4f4f;
            font-size: 16px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .content-subject {
            display: inline-block;
            background-color: #b0b29a;
            color: white;
            padding: 7px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            margin-top: 30px;
            background-color: var(--green-main);
            color: white;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 25px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-button:hover {
            color: white;
            opacity: 0.9;
        }

        @media (max-width: 767px) {
            .content-header {
                padding: 30px 20px;
            }

            .content-header h1 {
                font-size: 27px;
            }

            .content-section {
                padding: 30px 15px 50px;
            }

            .content-card {
                padding: 25px 20px;
            }

            .content-card h2 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<!-- =========================================
     NAVBAR (Padronizada igual à de Matérias)
========================================= -->
<?php require_once __DIR__ . '/../includes/navbar.php'; ?>

<!-- =========================================
     PAGE HEADER
========================================== -->
<section class="content-header">
    <h1>
        Conteúdos
    </h1>
    <p>
        Ciências e suas tecnologias
    </p>
</section>

<!-- =========================================
     CONTENT
========================================== -->
<section class="content-section">
    <div class="content-container">
        <div class="content-card">

            <!-- Subject -->
            <span class="content-subject">
                <?= htmlspecialchars($conteudo['materia']); ?>
            </span>

            <!-- Content title -->
            <h2>
                <?= htmlspecialchars($conteudo['titulo']); ?>
            </h2>

            <!-- Content description -->
            <div class="content-description">
                <?= nl2br(htmlspecialchars($conteudo['descricao'])); ?>
            </div>

            <!-- Back button -->
            <a href="materias.php" class="back-button">
                ← Voltar para matérias
            </a>

        </div>
    </div>
</section>

<!-- =========================================
     FOOTER (Padronizado)
========================================= -->
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<!-- =========================================
     BOOTSTRAP JS
========================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
