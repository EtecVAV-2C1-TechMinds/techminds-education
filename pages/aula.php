<?php

/* =========================================
   TECHMINDS EDUCATION
   PÁGINA DA AULA
========================================= */

require_once __DIR__ . '/../models/Aula.php';


/* =========================================
   BUSCAR ID DA AULA
========================================= */

$aulaId = (int) ($_GET['id'] ?? 0);

if ($aulaId <= 0) {
    header('Location: materias.php');
    exit;
}


/* =========================================
   BUSCAR AULA
========================================= */

$aulaModel = new Aula();

$aula = $aulaModel->buscarPorId($aulaId);

if (!$aula) {
    header('Location: materias.php');
    exit;
}

// Define o título da página dinamicamente para o header.php
$title = htmlspecialchars($aula['titulo']) . ' | TechMinds Education';

// Includes de Header e Navbar padrão do site
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>

    /* =========================================
       PÁGINA DA AULA
    ========================================= */

    .aula-page {

        background-color: #f1f1f1;

        min-height: 500px;

        padding: 40px 20px 60px;

    }


    /* =========================================
       CONTAINER DA AULA
    ========================================= */

    .aula-container {

        width: 100%;

        max-width: 900px;

        margin: 0 auto;

        box-sizing: border-box;

    }


    /* =========================================
       CABEÇALHO DA AULA
    ========================================= */

    .aula-card-header {

        background-color: var(--green-main);

        color: #ffffff;

        text-align: center;

        padding: 35px 25px;

        border-radius: 18px;

        margin-bottom: 30px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.08);

    }


    .aula-card-header h1 {

        margin: 0 0 8px;

        font-size: 32px;

        font-weight: 700;

    }


    .aula-card-header p {

        margin: 0;

        font-size: 15px;

    }


    /* =========================================
       TEXTO INTRODUTÓRIO
    ========================================= */

    .texto-introdutorio {

        background-color: #ffffff;

        color: #555555;

        padding: 30px;

        margin: 0;

        font-size: 16px;

        line-height: 1.7;

        border-radius: 18px 18px 0 0;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.05);

    }


    /* =========================================
       BOTÕES DE RECURSOS
    ========================================= */

    .botoes-container {

        background-color: #ffffff;

        display: flex;

        flex-direction: column;

        gap: 15px;

        padding: 0 30px 30px;

    }


    .btn-recurso {

        display: flex;

        align-items: center;

        justify-content: center;

        text-align: center;

        width: 100%;

        min-height: 52px;

        padding: 14px 20px;

        box-sizing: border-box;

        background-color: #b0b29a;

        color: #ffffff;

        text-decoration: none;

        border-radius: 12px;

        font-size: 15px;

        font-weight: 600;

        transition: 0.2s;

    }


    .btn-recurso:hover {

        background-color: var(--green-main);

        color: #ffffff;

        transform: translateY(-2px);

    }


    /* =========================================
       CONCLUSÃO
    ========================================= */

    .concluir-container {

        background-color: #ffffff;

        text-align: center;

        padding: 25px 30px;

        border-top: 1px solid #dddddd;

    }


    .btn-concluir {

        border: none;

        background-color: var(--green-dark);

        color: #ffffff;

        padding: 14px 30px;

        border-radius: 30px;

        font-size: 15px;

        font-weight: 700;

        cursor: pointer;

        transition: 0.2s;

    }


    .btn-concluir:hover {

        opacity: 0.9;

        transform: translateY(-2px);

    }


    /* =========================================
       VOLTAR
    ========================================= */

    .voltar-container {

        background-color: #ffffff;

        text-align: center;

        padding: 0 30px 35px;

        border-radius: 0 0 18px 18px;

    }


    .btn-voltar {

        color: var(--green-dark);

        text-decoration: none;

        font-size: 15px;

        font-weight: 600;

    }


    .btn-voltar:hover {

        color: var(--green-main);

        text-decoration: underline;

    }


    /* =========================================
       DESKTOP
    ========================================= */

    @media (min-width: 768px) {

        .aula-page {

            padding: 55px 30px 80px;

        }


        .aula-container {

            width: 92%;

            max-width: 1200px;

            margin: 0 auto;

        }


        .aula-card-header {

            padding: 45px 60px;

        }


        .aula-card-header h1 {

            font-size: 42px;

        }


        .aula-card-header p {

            font-size: 17px;

        }


        .texto-introdutorio {

            padding: 40px 55px;

            font-size: 17px;

        }


        .botoes-container {

            flex-direction: row;

            gap: 20px;

            padding: 0 55px 40px;

        }


        .btn-recurso {

            flex: 1;

            min-height: 58px;

        }


        .concluir-container {

            padding: 30px 55px;

        }


        .voltar-container {

            padding: 0 55px 40px;

        }

    }


    /* =========================================
       DESKTOP GRANDE
    ========================================= */

    @media (min-width: 1200px) {

        .aula-container {

            max-width: 1250px;

        }


        .aula-card-header {

            padding: 50px 70px;

        }


        .texto-introdutorio {

            padding: 45px 70px;

        }


        .botoes-container {

            padding-left: 70px;

            padding-right: 70px;

        }


        .concluir-container {

            padding-left: 70px;

            padding-right: 70px;

        }


        .voltar-container {

            padding-left: 70px;

            padding-right: 70px;

        }

    }


    /* =========================================
       CELULAR
    ========================================= */

    @media (max-width: 767px) {

        .aula-page {

            padding: 25px 15px 50px;

        }


        .aula-card-header {

            padding: 28px 20px;

        }


        .aula-card-header h1 {

            font-size: 28px;

        }


        .texto-introdutorio {

            padding: 25px 20px;

            font-size: 15px;

        }


        .botoes-container {

            padding: 0 20px 25px;

        }


        .concluir-container {

            padding: 20px;

        }


        .voltar-container {

            padding: 0 20px 30px;

        }

    }

</style>


<!-- Script para reforçar o título dinâmico na aba do navegador -->
<script>
    document.title = "<?= addslashes($aula['titulo']); ?> | TechMinds Education";
</script>


<!-- =========================================
     CONTEÚDO PRINCIPAL
========================================= -->

<main class="aula-page">

    <div class="aula-container">


        <!-- =========================================
             CABEÇALHO DA AULA
        ========================================== -->

        <section class="aula-card-header">

            <h1>

                <?= htmlspecialchars(
                    $aula['titulo']
                ); ?>

            </h1>


            <p>

                <?= htmlspecialchars(
                    $aula['conteudo'] ?? 'Matéria'
                ); ?>

            </p>

        </section>


        <!-- =========================================
             TEXTO INTRODUTÓRIO
        ========================================== -->

        <p class="texto-introdutorio">

            <?= !empty($aula['descricao'])

                ? nl2br(
                    htmlspecialchars(
                        $aula['descricao']
                    )
                )

                : 'Texto introdutório'; ?>

        </p>


        <!-- =========================================
             BOTÕES DE RECURSOS
        ========================================== -->

        <div class="botoes-container">


            <!-- PDF -->

            <?php if (!empty($aula['material'])): ?>

                <a
                    href="<?= htmlspecialchars(
                        $aula['material']
                    ); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-recurso"
                >

                    <i class="fa-solid fa-file-pdf"></i>

                    &nbsp;

                    Arquivo PDF da explicação

                </a>

            <?php else: ?>

                <div
                    class="btn-recurso"
                    style="
                        opacity: 0.8;
                        cursor: not-allowed;
                    "
                >

                    <i class="fa-solid fa-file-pdf"></i>

                    &nbsp;

                    Arquivo PDF não disponível

                </div>

            <?php endif; ?>


            <!-- RESUMO -->

            <a
                href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>"
                class="btn-recurso"
            >

                <i class="fa-solid fa-book-open"></i>

                &nbsp;

                Acesse o resumo da aula

            </a>


            <!-- VÍDEO -->

            <?php if (!empty($aula['video'])): ?>

                <a
                    href="<?= htmlspecialchars(
                        $aula['video']
                    ); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-recurso"
                >

                    <i class="fa-solid fa-circle-play"></i>

                    &nbsp;

                    Link da aula em vídeo

                </a>

            <?php else: ?>

                <div
                    class="btn-recurso"
                    style="
                        opacity: 0.8;
                        cursor: not-allowed;
                    "
                >

                    <i class="fa-solid fa-circle-play"></i>

                    &nbsp;

                    Vídeo ainda não disponível

                </div>

            <?php endif; ?>


        </div>


        <!-- =========================================
             MARCAR COMO CONCLUÍDA
        ========================================== -->

        <div class="concluir-container">

            <button
                type="button"
                class="btn-concluir"
                onclick="marcarConcluida()"
            >

                <i class="fa-solid fa-check"></i>

                &nbsp;

                Marcar aula como concluída

            </button>

        </div>


        <!-- =========================================
             VOLTAR
        ========================================== -->

        <div class="voltar-container">

            <a
                href="conteudo.php?id=<?= (int) $aula['conteudo_id']; ?>"
                class="btn-voltar"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Voltar para o conteúdo

            </a>

        </div>


    </div>

</main>


<!-- =========================================
     FOOTER REUTILIZÁVEL DO SITE
========================================= -->

<?php include(__DIR__ . '/../includes/footer.php'); ?>


<!-- =========================================
     JAVASCRIPT DE CORREÇÃO DO MENU
========================================= -->

<script>

function marcarConcluida() {

    const botao =
        document.querySelector('.btn-concluir');


    botao.innerHTML =
        '<i class="fa-solid fa-check"></i> Aula concluída!';


    botao.disabled = true;

    botao.style.opacity = '0.7';

}

/* ===================================================
   CORREÇÃO DO MENU FECHAR NO SEGUNDO CLIQUE
=================================================== */
document.addEventListener('DOMContentLoaded', function () {
    // Procura todos os possíveis botões e menus (Bootstrap ou Customizados)
    const togglers = document.querySelectorAll('.navbar-toggler, .menu-toggle, .hamburguer, .admin-menu');

    togglers.forEach(function (toggler) {
        toggler.addEventListener('click', function (e) {
            e.preventDefault();

            // Identifica qual alvo o botão tenta controlar
            let targetSelector = toggler.getAttribute('data-bs-target') || toggler.getAttribute('data-target');
            let targetMenu = targetSelector ? document.querySelector(targetSelector) : null;

            if (!targetMenu) {
                targetMenu = document.querySelector('.navbar-collapse') || document.querySelector('.nav-menu') || document.querySelector('.admin-menu-list');
            }

            if (targetMenu) {
                // Se o menu tem a classe 'show' ou 'active', REMOVE (fecha). Senão, ADICIONA (abre).
                const estaAberto = targetMenu.classList.contains('show') || targetMenu.classList.contains('active');

                if (estaAberto) {
                    targetMenu.classList.remove('show', 'active');
                    toggler.classList.add('collapsed');
                    toggler.classList.remove('active');
                } else {
                    targetMenu.classList.add('show', 'active');
                    toggler.classList.remove('collapsed');
                    toggler.classList.add('active');
                }
            }
        });
    });
});

</script>
