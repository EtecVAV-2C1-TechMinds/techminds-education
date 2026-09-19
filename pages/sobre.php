<?php

/* =========================================
   TECHMINDS EDUCATION
   SOBRE A INSTITUIÇÃO
========================================= */

require_once __DIR__ . '/../config/config.php';

$title = "Sobre a Instituição | " . NOME_SISTEMA;

include('../includes/header.php');
include('../includes/navbar.php');

?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --sobre-accent: #839745;
    }
</style>

<main id="main-content">

    <!-- Hero Section -->
    <header class="hero-sobre text-center d-flex align-items-center position-relative py-5 overflow-hidden"
            style="background: linear-gradient(180deg, rgba(131, 151, 69, 0.78) 0%, rgba(90, 105, 45, 0.88) 100%), url('../assets/img/area_externa.png') center/cover no-repeat; min-height: 420px;">

        <div class="position-absolute top-50 start-50 translate-middle rounded-circle pointer-events-none"
             style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(0, 0, 0, 0) 70%); filter: blur(50px); z-index: 0;">
        </div>

        <div class="container px-4 my-auto position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">

                    <span class="badge border px-3 py-2 rounded-pill fw-semibold mb-3 shadow-sm text-uppercase"
                          style="letter-spacing: 2px; font-size: 0.7rem; color: #ffffff; background-color: rgba(255, 255, 255, 0.15); border-color: rgba(255, 255, 255, 0.3) !important;">
                        Institucional
                    </span>

                    <h1 class="display-5 fw-medium mb-3 text-white" style="letter-spacing: -0.3px;">
                        Sobre a <?= htmlspecialchars(NOME_SISTEMA) ?>
                    </h1>

                    <p class="lead mx-auto mb-0 fs-6 text-white" style="max-width: 680px; font-weight: 300; line-height: 1.7; opacity: 0.95;">
                        Plataforma voltada ao desenvolvimento educacional, combinando inovação tecnológica, organização pedagógica e acessibilidade ao conhecimento.
                    </p>

                </div>
            </div>
        </div>
    </header>

    <!-- Números da plataforma -->
    <section class="py-4" style="background-color: #ffffff; border-bottom: 1px solid #eee;">
        <div class="container">
            <div class="row text-center g-4">

                <div class="col-6 col-md-3">
                    <h3 class="fw-bold mb-0" style="color: var(--sobre-accent);">3</h3>
                    <p class="text-muted small mb-0">Áreas de ensino</p>
                </div>

                <div class="col-6 col-md-3">
                    <h3 class="fw-bold mb-0" style="color: var(--sobre-accent);">100%</h3>
                    <p class="text-muted small mb-0">Conteúdo online</p>
                </div>

                <div class="col-6 col-md-3">
                    <h3 class="fw-bold mb-0" style="color: var(--sobre-accent);">24h</h3>
                    <p class="text-muted small mb-0">Acesso disponível</p>
                </div>

                <div class="col-6 col-md-3">
                    <h3 class="fw-bold mb-0" style="color: var(--sobre-accent);">ENEM</h3>
                    <p class="text-muted small mb-0">Foco principal</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Conteúdo Principal -->
    <section class="sobre-content py-5 bg-light">
        <div class="container px-4" style="max-width: 900px;">

            <article class="card border-0 shadow-lg p-4 p-md-5 bg-white rounded-4 position-relative overflow-hidden mb-5">

                <div class="position-absolute top-50 start-50 translate-middle pointer-events-none" style="z-index: 0; width: 320px; opacity: 0.08;">
                    <img src="../logo/logo.png" alt="" class="img-fluid">
                </div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="text-center mb-4">
                        <h2 class="h6 text-uppercase fw-bold mb-2" style="color: var(--sobre-accent); letter-spacing: 1px;">Quem Somos</h2>
                        <h3 class="fw-bold text-dark fs-3 mb-0">Compromisso com a Excelência Acadêmica</h3>
                    </div>

                    <div class="row g-4 fs-6 text-secondary leading-relaxed pt-2">
                        <div class="col-md-6">
                            <p class="mb-0">
                                Nosso compromisso é disponibilizar conteúdos de qualidade, materiais organizados e ferramentas educacionais que auxiliem os estudantes a desenvolverem seus conhecimentos de forma estruturada e produtiva, contribuindo para melhores resultados em avaliações e processos seletivos.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                Acreditamos que a educação é uma das principais ferramentas de transformação social. Por isso, buscamos criar um ambiente digital que incentive a autonomia, a disciplina e o desenvolvimento contínuo dos nossos alunos.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <div class="row g-4">

                <div class="col-md-12">
                    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 border-start border-4" style="border-color: var(--sobre-accent) !important;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle p-3 text-white me-3 d-flex align-items-center justify-content-center" style="background-color: var(--sobre-accent); width: 48px; height: 48px;">
                                <i class="bi bi-compass fs-4"></i>
                            </div>
                            <h4 class="fw-bold text-dark m-0 fs-4">Nossa Missão</h4>
                        </div>
                        <p class="text-secondary fs-6 leading-relaxed mb-0">
                            Democratizar o acesso ao conhecimento por meio da tecnologia, oferecendo recursos educacionais de qualidade que contribuam para a formação acadêmica e pessoal dos estudantes. Nosso objetivo é proporcionar uma experiência de aprendizagem eficiente, organizada e acessível para todos.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 text-center h-100">
                        <i class="bi bi-journal-check fs-2 mb-2" style="color: var(--sobre-accent);"></i>
                        <h5 class="fw-bold fs-6 text-dark mb-2">Organização</h5>
                        <p class="text-muted small mb-0">Estruturação completa de conteúdos focados na eficiência dos estudos.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 text-center h-100">
                        <i class="bi bi-laptop fs-2 mb-2" style="color: var(--sobre-accent);"></i>
                        <h5 class="fw-bold fs-6 text-dark mb-2">Tecnologia</h5>
                        <p class="text-muted small mb-0">Ferramentas digitais acessíveis para potencializar o aprendizado.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 text-center h-100">
                        <i class="bi bi-award fs-2 mb-2" style="color: var(--sobre-accent);"></i>
                        <h5 class="fw-bold fs-6 text-dark mb-2">Autonomia</h5>
                        <p class="text-muted small mb-0">Incentivo ao desenvolvimento contínuo e à disciplina pessoal.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php include('../includes/footer.php'); ?>