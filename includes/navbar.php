<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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


            <?php if (!empty($_SESSION['usuario_logado'])): ?>

<!-- =========================================
     USUÁRIO LOGADO
========================================= -->

<div class="tech-user-dropdown">

    <button type="button"
            class="tech-user-button">

        <!-- Ícone de pessoa -->

        <span class="tech-user-icon">

            <svg width="20"
                 height="20"
                 viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <circle cx="12"
                        cy="8"
                        r="4"
                        stroke="currentColor"
                        stroke-width="2"/>

                <path d="M4 21C4 16.5817 7.58172 13 12 13C16.4183 13 20 16.5817 20 21"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"/>

            </svg>

        </span>


        <!-- Nome -->

        <span class="tech-user-name">

        <?= htmlspecialchars(explode(' ', trim($_SESSION['usuario_nome'] ?? 'Aluno'))[0]) ?>

        </span>

    </button>


    <!-- =========================================
         MENU DO USUÁRIO
    ========================================= -->

    <div class="tech-user-menu">


        <!-- Informações -->

        <div class="tech-user-menu-header">

            <strong>

            <?= htmlspecialchars(explode(' ', trim($_SESSION['usuario_nome'] ?? 'Aluno'))[0]) ?>

            </strong>

            <small>

                <?= htmlspecialchars($_SESSION['usuario_email'] ?? '') ?>

            </small>

        </div>


        <!-- Perfil -->

        <a href="/techminds-education/pages/perfil.php">

            Meu perfil

        </a>


        <!-- Área do aluno -->

        <a href="/techminds-education/pages/conteudo.php">

    Área do aluno

</a>


        <!-- Separador -->

        <div class="tech-user-menu-divider"></div>


        <!-- Logout -->

        <a href="/techminds-education/pages/logout.php"
           class="tech-logout">

            Sair da conta

        </a>

    </div>

</div>


<?php else: ?>

<!-- =========================================
     USUÁRIO NÃO LOGADO
========================================= -->

<a href="/techminds-education/pages/login.php"
   class="tech-login">

    Entrar

</a>


<a href="/techminds-education/pages/cadastro.php"
   class="tech-register">

    Cadastrar

</a>

<?php endif; ?>


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


                    <a href="/techminds-education/pages/questoes.php"
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

                        <?php if (!empty($_SESSION['usuario_logado'])): ?>

<a href="/techminds-education/pages/conteudo.php"
   class="tech-highlight-button">

    Acessar área do aluno

</a>

<?php else: ?>

<a href="/techminds-education/pages/login.php"
   class="tech-highlight-button">

    Acessar área do aluno

</a>

<?php endif; ?>

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
