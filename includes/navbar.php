<!-- =========================================
     MAIN NAVIGATION
========================================= -->

<nav class="tech-navbar">

    <div class="container">

        <div class="tech-navbar-content">


            <!-- Brand -->

            <a href="/techminds-education/index.php"
               class="tech-brand">

                <span class="tech-brand-name">
                    TechMinds
                </span>

                <span class="tech-brand-subtitle">
                    Education
                </span>

            </a>


            <!-- Navigation Actions -->

            <div class="tech-navbar-actions">


                <!-- Login -->

                <a href="/techminds-education/pages/login.php"
                   class="tech-login">

                    Entrar

                </a>


                <!-- Register -->

                <a href="/techminds-education/pages/cadastro.php"
                   class="tech-register">

                    Cadastrar

                </a>


                <!-- Menu Button (Toggle com Bootstrap + JS) -->

                <button type="button"
                        class="tech-menu-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#techNavigation"
                        aria-controls="techNavigation"
                        aria-expanded="false"
                        aria-label="Alternar menu">

                    <span></span>
                    <span></span>
                    <span></span>

                </button>


            </div>

        </div>


        <!-- =========================================
             NAVIGATION PANEL
        ========================================= -->

        <div class="collapse"
             id="techNavigation">

            <div class="tech-navigation-panel">


                <!-- Main Navigation -->

                <div class="tech-navigation-column">

                    <span class="tech-navigation-title">
                        NAVEGAÇÃO
                    </span>


                    <a href="/techminds-education/index.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            01
                        </span>

                        <span>
                            Início
                        </span>

                    </a>


                    <a href="/techminds-education/pages/sobre.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            02
                        </span>

                        <span>
                            Sobre a Instituição
                        </span>

                    </a>


                    <a href="/techminds-education/pages/contato.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            03
                        </span>

                        <span>
                            Contato
                        </span>

                    </a>

                </div>


                <!-- Academic Environment -->

                <div class="tech-navigation-column">

                    <span class="tech-navigation-title">
                        AMBIENTE ACADÊMICO
                    </span>


                    <a href="/techminds-education/pages/materias.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            04
                        </span>

                        <span>
                            Conteúdos
                        </span>

                    </a>


                    <a href="/techminds-education/pages/exercicios.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            05
                        </span>

                        <span>
                            Exercícios
                        </span>

                    </a>


                    <a href="/techminds-education/pages/simulados.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            06
                        </span>

                        <span>
                            Simulados
                        </span>

                    </a>


                    <a href="/techminds-education/pages/desempenho.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            07
                        </span>

                        <span>
                            Meu Desempenho
                        </span>

                    </a>

                </div>


                <!-- Administrative Area -->

                <div class="tech-navigation-column">

                    <span class="tech-navigation-title">
                        ADMINISTRAÇÃO
                    </span>


                    <a href="/techminds-education/pages/admin.php"
                       class="tech-navigation-link">

                        <span class="tech-link-number">
                            08
                        </span>

                        <span>
                            Área do Administrador
                        </span>

                    </a>


                    <!-- Student Area Highlight -->

                    <div class="tech-navigation-highlight">

                        <span class="tech-highlight-label">
                            ÁREA DO ALUNO
                        </span>

                        <p>
                            Acesse seus conteúdos,
                            atividades e acompanhe
                            seu desempenho acadêmico.
                        </p>

                        <a href="/techminds-education/pages/login.php"
                           class="tech-highlight-button">

                            Acessar área do aluno

                        </a>

                    </div>

                </div>


            </div>

        </div>

    </div>

</nav>

<!-- =========================================
     TOGGLE BEHAVIOR (Garante o clique Toggle de abrir/fechar)
========================================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('.tech-menu-button');
    const navPanel = document.querySelector('#techNavigation');

    if (menuButton && navPanel) {
        menuButton.addEventListener('click', function () {
            // Se o Bootstrap JS estiver ativo, ele trata automaticamente via data-bs-toggle
            // Mas adicionamos a classe 'active' para criar animações no botão (ex: virar um X)
            menuButton.classList.toggle('active');
        });
    }
});
</script>
