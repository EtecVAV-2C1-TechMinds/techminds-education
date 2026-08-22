<?php

/* =========================================
   TECHMINDS EDUCATION
   STUDENT AREA
========================================= */

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../includes/auth.php';


/* =========================================
   PAGE TITLE
========================================= */

$title = "Área do Aluno | TechMinds Education";


/* =========================================
   USER DATA
========================================= */

$nome = $_SESSION['usuario_nome'] ?? 'Aluno';

$email = $_SESSION['usuario_email'] ?? '';

$tipoUsuario = $_SESSION['usuario_tipo'] ?? 'aluno';


/* =========================================
   HEADER
========================================= */

include(__DIR__ . '/../includes/header.php');

include(__DIR__ . '/../includes/navbar.php');

?>


<style>

/* =========================================
   CORREÇÃO DA ESTRUTURA DA PÁGINA
========================================= */

html,
body {

    width: 100%;

    min-height: 100%;

    margin: 0;

    padding: 0;

}


body {

    display: flex;

    flex-direction: column;

    min-height: 100vh;

}


/*
   Impede que o footer fique fixo
   ou sobreponha o conteúdo.
*/

footer,
.footer {

    position: static !important;

    bottom: auto !important;

    left: auto !important;

    right: auto !important;

    top: auto !important;

    width: 100%;

    flex-shrink: 0;

}


/* =========================================
   ÁREA PRINCIPAL
========================================= */

.student-page {

    width: 100%;

    background-color: #f1f1f1;

    flex: 1 0 auto;

    padding: 50px 20px 70px;

    box-sizing: border-box;

}


/* =========================================
   CONTAINER
========================================= */

.student-container {

    width: 100%;

    max-width: 1100px;

    margin: 0 auto;

}


/* =========================================
   WELCOME
========================================= */

.student-welcome {

    width: 100%;

    background-color: #5d7034;

    color: #ffffff;

    border-radius: 20px;

    padding: 35px 40px;

    margin-bottom: 35px;

    box-sizing: border-box;

    box-shadow:
        0 7px 20px rgba(0, 0, 0, 0.10);

}


.student-welcome small {

    display: block;

    color: #dce5c3;

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 7px;

}


.student-welcome h1 {

    margin: 0 0 10px;

    color: #ffffff;

    font-size: 30px;

    font-weight: 700;

}


.student-welcome p {

    margin: 0;

    color: rgba(255,255,255,0.88);

    font-size: 15px;

    line-height: 1.6;

}


/* =========================================
   TÍTULO
========================================= */

.student-section-title {

    color: #233703;

    font-size: 23px;

    font-weight: 700;

    margin: 0 0 20px;

}


/* =========================================
   GRID
========================================= */

.student-grid {

    width: 100%;

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 20px;

}


/* =========================================
   CARDS
========================================= */

.student-card {

    display: flex;

    align-items: center;

    gap: 20px;

    width: 100%;

    min-height: 145px;

    box-sizing: border-box;

    background-color: #ffffff;

    border-radius: 18px;

    padding: 25px;

    color: inherit;

    text-decoration: none;

    box-shadow:
        0 5px 16px rgba(0, 0, 0, 0.07);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;

    /*
       Remove a mãozinha.
    */

    cursor: default;

}


/* =========================================
   CARDS CLICÁVEIS
========================================= */

.student-card[href] {

    cursor: default;

}


.student-card[href]:hover {

    color: inherit;

    text-decoration: none;

}


/* =========================================
   ÍCONE
========================================= */

.student-card-icon {

    width: 58px;

    height: 58px;

    min-width: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    background-color: #eef1e7;

    color: #5d7034;

    border-radius: 15px;

    font-size: 22px;

}


/* =========================================
   CARD TITLE
========================================= */

.student-card h3 {

    margin: 0 0 7px;

    color: #233703;

    font-size: 18px;

    font-weight: 700;

}


/* =========================================
   CARD TEXT
========================================= */

.student-card p {

    margin: 0;

    color: #666666;

    font-size: 13px;

    line-height: 1.6;

}


/* =========================================
   PERFIL / MEUS DADOS
========================================= */

.student-profile {

    width: 100%;

    margin-top: 35px;

    margin-bottom: 0;

    background-color: #ffffff;

    border-radius: 18px;

    padding: 25px;

    box-sizing: border-box;

    box-shadow:
        0 5px 16px rgba(0, 0, 0, 0.07);

}


.student-profile h2 {

    margin: 0 0 18px;

    color: #233703;

    font-size: 19px;

    font-weight: 700;

}


/* =========================================
   LINHAS DO PERFIL
========================================= */

.profile-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    width: 100%;

    padding: 13px 0;

    border-bottom: 1px solid #eeeeee;

    box-sizing: border-box;

}


.profile-row:last-child {

    border-bottom: none;

}


/* =========================================
   LABEL
========================================= */

.profile-label {

    color: #777777;

    font-size: 13px;

    font-weight: 600;

}


/* =========================================
   VALOR
========================================= */

.profile-value {

    color: #333333;

    font-size: 14px;

    text-align: right;

    word-break: break-word;

}


/* =========================================
   FOOTER
========================================= */

.footer {

    position: static !important;

    width: 100%;

    margin-top: 0 !important;

    flex-shrink: 0;

    background-color: #1A2601;

    color: #ffffff;

    padding: 40px 0;

    box-sizing: border-box;

}


/* =========================================
   FOOTER TÍTULO
========================================= */

.footer h4 {

    margin-bottom: 10px;

    color: #ffffff;

    font-size: 18px;

    font-weight: 700;

}


/* =========================================
   FOOTER TEXTOS
========================================= */

.footer p {

    margin-bottom: 6px;

    color: rgba(255,255,255,0.82);

    font-size: 14px;

}


.footer p:last-child {

    margin-bottom: 0;

}


/* =========================================
   RESPONSIVIDADE
========================================= */

@media (max-width: 767px) {


    .student-page {

        padding: 35px 15px 50px;

    }


    .student-welcome {

        padding: 28px 24px;

    }


    .student-welcome h1 {

        font-size: 25px;

    }


    .student-welcome p {

        font-size: 14px;

    }


    .student-grid {

        grid-template-columns: 1fr;

    }


    .student-card {

        min-height: 130px;

        padding: 22px;

    }


    .student-profile {

        padding: 22px;

    }


    .profile-row {

        flex-direction: column;

        align-items: flex-start;

        gap: 5px;

    }


    .profile-value {

        text-align: left;

    }

}


/* =========================================
   TELAS MUITO PEQUENAS
========================================= */

@media (max-width: 400px) {


    .student-welcome {

        padding: 24px 20px;

    }


    .student-welcome h1 {

        font-size: 22px;

    }


    .student-card {

        gap: 15px;

        padding: 18px;

    }


    .student-card-icon {

        width: 50px;

        height: 50px;

        min-width: 50px;

    }


    .student-card h3 {

        font-size: 16px;

    }


    .student-card p {

        font-size: 12px;

    }

}

</style>


<!-- =========================================
     ÁREA PRINCIPAL
========================================= -->

<main class="student-page">

    <div class="student-container">


        <!-- =====================================
             BOAS-VINDAS
        ====================================== -->

        <section class="student-welcome">

            <small>
                ÁREA DO ALUNO
            </small>


            <h1>

                Olá, <?= htmlspecialchars($nome); ?>!

            </h1>


            <p>

                Bem-vindo à sua área de estudos.
                Continue sua preparação e acompanhe
                sua evolução na TechMinds Education.

            </p>

        </section>


        <!-- =====================================
             ACESSO RÁPIDO
        ====================================== -->

        <h2 class="student-section-title">

            Acesso rápido

        </h2>


        <div class="student-grid">


            <!-- =================================
                 MATÉRIAS
            ================================== -->

            <a
                href="materias.php"
                class="student-card"
            >

                <div class="student-card-icon">

                    <i class="fa-solid fa-book-open"></i>

                </div>


                <div>

                    <h3>

                        Minhas matérias

                    </h3>


                    <p>

                        Acesse as matérias e conteúdos
                        disponíveis para seus estudos.

                    </p>

                </div>

            </a>


            <!-- =================================
                 EXERCÍCIOS
            ================================== -->

            <a
                href="questoes.php"
                class="student-card"
            >

                <div class="student-card-icon">

                    <i class="fa-solid fa-circle-question"></i>

                </div>


                <div>

                    <h3>

                        Exercícios

                    </h3>


                    <p>

                        Pratique seus conhecimentos
                        através de questões de fixação.

                    </p>

                </div>

            </a>


            <!-- =================================
                 PERFIL
            ================================== -->

            <a
                href="perfil.php"
                class="student-card"
            >

                <div class="student-card-icon">

                    <i class="fa-solid fa-user"></i>

                </div>


                <div>

                    <h3>

                        Meu perfil

                    </h3>


                    <p>

                        Consulte e atualize suas
                        informações pessoais.

                    </p>

                </div>

            </a>


            <!-- =================================
                 PROGRESSO
            ================================== -->

            <div class="student-card">

                <div class="student-card-icon">

                    <i class="fa-solid fa-chart-line"></i>

                </div>


                <div>

                    <h3>

                        Meu progresso

                    </h3>


                    <p>

                        O acompanhamento do seu desempenho
                        será disponibilizado em breve.

                    </p>

                </div>

            </div>


        </div>


        <!-- =====================================
             MEUS DADOS
        ====================================== -->

        <section class="student-profile">

            <h2>

                Meus dados

            </h2>


            <!-- NOME -->

            <div class="profile-row">

                <span class="profile-label">

                    Nome

                </span>


                <span class="profile-value">

                    <?= htmlspecialchars($nome); ?>

                </span>

            </div>


            <!-- E-MAIL -->

            <div class="profile-row">

                <span class="profile-label">

                    E-mail

                </span>


                <span class="profile-value">

                    <?= htmlspecialchars($email); ?>

                </span>

            </div>


            <!-- TIPO -->

            <div class="profile-row">

                <span class="profile-label">

                    Tipo de usuário

                </span>


                <span class="profile-value">

                    <?= htmlspecialchars($tipoUsuario); ?>

                </span>

            </div>


        </section>


    </div>

</main>


<!-- =========================================
     FOOTER
========================================= -->

<?php

include(__DIR__ . '/../includes/footer.php');

?>
