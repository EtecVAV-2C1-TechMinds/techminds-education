<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<!-- =========================================
     HERO SECTION
========================================= -->

<section class="hero">
    <div class="container">
        <h1>
            Preparação completa para o ENEM e Vestibulares
        </h1>
        <p>
            A TechMinds Education é um cursinho preparatório que une
            ensino de qualidade, acompanhamento acadêmico e tecnologia
            educacional para potencializar o desempenho dos estudantes.
        </p>
        <div class="mt-4">
            <a href="pages/sobre.php" class="btn btn-light btn-lg me-2">
                Conheça a Instituição
            </a>
            <?php if (!empty($_SESSION['usuario_logado'])): ?>

<a href="pages/conteudo.php" class="btn btn-tech btn-lg">
    Área do Aluno
</a>

<?php else: ?>

<a href="pages/login.php" class="btn btn-tech btn-lg">
    Área do Aluno
</a>

<?php endif; ?>
        </div>
    </div>
</section>

<!-- =========================================
     ABOUT US SECTION
========================================= -->

<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <img src="assets/img/area_externa.png" class="img-fluid rounded shadow" alt="Área Externa">
        </div>
        <div class="col-lg-6">
            <h2>
                Quem Somos
            </h2>
            <p>
                A TechMinds Education nasceu com o propósito de oferecer
                uma preparação sólida para estudantes que desejam ingressar
                no ensino superior através do ENEM e dos principais vestibulares.
            </p>
            <p>
                Nossa proposta une ensino presencial, recursos tecnológicos
                e materiais de apoio para proporcionar uma experiência de
                aprendizagem moderna, organizada e eficiente.
            </p>
            <p>
                Além das aulas e conteúdos especializados, disponibilizamos
                ferramentas digitais que auxiliam os alunos no acompanhamento
                de seus estudos e desempenho acadêmico.
            </p>
            <p>



            </p>
        </div>
    </div>
</section>

<!-- =========================================
     EDUCATIONAL AREAS SECTION
========================================= -->

<section class="subjects-section py-5 bg-white">
    <div class="container" style="max-width: 1200px;">
        <h2 class="text-center fw-bold mb-5">
            Áreas de Ensino
        </h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="d-flex align-items-center mb-5">
                    <div class="me-4 flex-shrink-0">
                        <img src="assets/img/biologia.png" alt="Biologia" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div>
                        <h4 class="fw-bold mb-2">Biologia</h4>
                        <p class="text-secondary mb-0">
                            Domine genética, ecologia, citologia e fisiologia. Aprenda a conectar a teoria biológica aos temas mais cobrados e atuais do ENEM e vestibulares.
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-5 text-end">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-2">Física</h4>
                        <p class="text-secondary mb-0">
                            Entenda mecânica, eletricidade, óptica e termodinâmica. Desenvolva o raciocínio lógico para interpretar gráficos e resolver problemas com facilidade.
                        </p>
                    </div>
                    <div class="ms-4 flex-shrink-0">
                        <img src="assets/img/fisica.png" alt="Física" class="img-fluid" style="max-width: 200px;">
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="me-4 flex-shrink-0">
                        <img src="assets/img/quimica.png" alt="Química" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div>
                        <h4 class="fw-bold mb-2">Química</h4>
                        <p class="text-secondary mb-0">
                            Explore a química geral, orgânica e físico-química. Saiba analisar reações, estruturas moleculares e cálculos estequiométricos de forma prática.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- =========================================
     SCHOOL STRUCTURE SECTION
========================================= -->

<section class="structure-section py-5 px-3 text-center bg-light">
    <div class="container" style="max-width: 700px;">
        <h1 class="fw-bold text-dark mb-2 fs-3">Nossa Estrutura</h2>
        <p class="text-secondary mb-6 opacity-85">
            Ambientes planejados para proporcionar conforto, organização e qualidade durante o processo de aprendizagem.
        </p>

        <div class="row g-3">
            <div class="col-12">
                <img src="assets/img/laboratorio.png" alt="Laboratório de Pesquisa e Inovação" class="img-fluid rounded shadow-sm w-100">
            </div>
            <div class="col-6">
                <img src="assets/img/estudante.png" alt="Sala de aula com alunos" class="img-fluid rounded shadow-sm w-100">
            </div>
            <div class="col-6">
                <img src="assets/img/biblioteca.png" alt="Biblioteca para estudos" class="img-fluid rounded shadow-sm w-100">
            </div>
        </div>
    </div>
</section>

<!-- =========================================
     DIFFERENTIALS SECTION
========================================= -->

<section class="differentials-section py-5 px-3 bg-white">
    <div class="container" style="max-width: 500px;">
        <h2 class="fw-bold text-center text-dark mb-4 fs-3">Nossos Diferenciais</h2>

        <div class="d-flex flex-column gap-3">
            <div class="differential-card p-3 text-white text-center shadow-sm">
                Conteúdos direcionados para ENEM e vestibulares.
            </div>
            <div class="differential-card p-3 text-white text-center shadow-sm">
                Tecnologia aplicada ao processo de aprendizagem na plataforma.
            </div>
            <div class="differential-card p-3 text-white text-center shadow-sm">
                Atividades para reforçar e fixar conteúdos disponíveis em exercícios e simulados.
            </div>
            <div class="differential-card p-3 text-white text-center shadow-sm">
                Acompanhamento acadêmico no monitoramento da evolução dos estudantes.
            </div>
        </div>
    </div>
</section>

<!-- =========================================
     CALL TO ACTION SECTION
========================================= -->

<section class="container py-5">
    <div class="card border-0 shadow">
        <div class="card-body text-center p-5">
            <h2>
                Prepare-se para conquistar seus objetivos
            </h2>
            <p class="mt-3">
                Faça parte da TechMinds Education e tenha acesso a uma
                estrutura completa, conteúdos especializados e recursos
                tecnológicos desenvolvidos para potencializar seus estudos.
            </p>
            <div class="mt-4">
                <a href="pages/cadastro.php" class="btn btn-tech btn-lg me-2">
                    Criar Conta
                </a>
                <a href="pages/contato.php" class="btn btn-outline-secondary btn-lg">
                    Entre em Contato
                </a>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
