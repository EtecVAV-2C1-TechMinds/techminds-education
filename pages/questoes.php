<?php

require_once __DIR__ . '/../config/conexao.php';

require_once __DIR__ . '/../models/Conteudo.php';

$title = "Questões | TechMinds Education";

$conteudoModel = new Conteudo();

$materias = $conteudoModel->listarMaterias();

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Questões";
$bannerSubtitulo = "Questões de fixação por conteúdo";
include(__DIR__ . '/../includes/banner.php');

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= $title; ?></title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        :root {
    --green-dark: #233703;
    /* Alterada para bater com o verde de Conteúdos (var(--green-main)) */
    --green-banner: #5e7037; 
    --green-btn: #6B783E;
    --green-btn-hover: #576332;
    --bg-light: #EBEBEB;
}

        body {

            background-color: var(--bg-light);

            min-height: 100vh;

        }


        /* =========================================
   TÍTULO PRINCIPAL ("Escolha uma matéria")
   -> Estilo idêntico ao "Aulas" (.lessons-title) da página de Conteúdos
========================================= */
.materias-title {
    color: var(--green-dark);
    font-size: 24px;       /* Tamanho idêntico a "Aulas" */
    font-weight: 700;      /* Peso idêntico */
    margin-bottom: 18px;   /* Mesma margem inferior */
}

/* =========================================
   TÍTULO DOS CARDS ("Biologia", "Física", "Química")
   -> Estilo idêntico ao título das matérias da página de Conteúdos
========================================= */
.materia-card h3 {
    color: var(--green-dark);
    font-size: 21px;       /* Tamanho idêntico aos títulos de matérias do Conteúdo */
    font-weight: 700;      /* Mesmo peso (ao invés de 800) */
    margin-bottom: 10px;
}

/* =========================================
   SUBTÍTULO / DESCRIÇÃO DOS CARDS
   -> Estilo idêntico ao "Introdução a Biologia" (.lesson-info p)
========================================= */
.materia-card p {
    color: #666;           /* Mantém o contraste em fundo claro */
    font-size: 13px;       /* Tamanho igual ao estilo da página de conteúdos */
    margin: 0;
    line-height: 1.6;
}


        .materias-page {

            padding: 50px 70px;

            max-width: 1200px;

            margin: auto;

        }




        .materias-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;

        }


        .materia-card {

            background-color: white;

            border-radius: 20px;

            padding: 30px;

            min-height: 190px;

            box-shadow:
                0 6px 18px rgba(0,0,0,0.08);

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            transition: 0.2s;

        }


        .materia-card:hover {

            transform: translateY(-5px);

        }




        .btn-materia {

            background-color:
                var(--green-btn);

            color: white;

            text-decoration: none;

            text-align: center;

            padding: 10px 20px;

            border-radius: 25px;

            font-weight: 700;

        }


        .btn-materia:hover {

            background-color:
                var(--green-btn-hover);

            color: white;

        }


    </style>

</head>


<body>



<main class="materias-page">


    <h2 class="materias-title">

        Escolha uma matéria

    </h2>


    <div class="materias-grid">


        <?php foreach ($materias as $materia): ?>


            <div class="materia-card">


                <div>

                    <h3>

                        <?= htmlspecialchars(
                            $materia['nome']
                        ); ?>

                    </h3>


                    <p>

                        <?= htmlspecialchars(
                            $materia['descricao']
                        ); ?>

                    </p>

                </div>


                <a
                    href="conteudos.php?materia_id=<?= $materia['id']; ?>"
                    class="btn-materia"
                >

                    Ver conteúdos

                    <i class="fa-solid fa-arrow-right"></i>

                </a>


            </div>


        <?php endforeach; ?>


    </div>


</main>


<?php

include(__DIR__ . '/../includes/footer.php');

?>


</body>

</html>
