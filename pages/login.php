<?php include('../includes/header.php'); ?>

<?php include('../includes/navbar.php'); ?>

<!-- Login section -->
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <!-- Login card -->
            <div class="card shadow">

                <div class="card-body p-5">

                    <!-- Page heading -->
                    <h2 class="text-center mb-4">
                        Entrar na Plataforma
                    </h2>

                    <!-- Login description -->
                    <p class="text-center">
                        Faça login para acessar conteúdos,
                        exercícios e acompanhar seu progresso.
                    </p>

                   <?php if (isset($_GET['erro'])): ?>

    <div class="alert alert-danger text-center">

        <?php

        switch ($_GET['erro']) {

            case 'preencha':
                echo 'Preencha todos os campos.';
                break;

            case 'email':
                echo 'Digite um e-mail válido.';
                break;

            case 'login':
                echo 'E-mail ou senha incorretos.';
                break;

            case 'desativado':
                echo 'Sua conta está desativada.';
                break;

            default:
                echo 'Não foi possível realizar o login.';

        }

        ?>

    </div>

<?php endif; ?>

<!-- Login form -->
<form
    method="POST"
    action="../controllers/LoginController.php"
>

                        <!-- Email field -->
                        <div class="mb-3">

                            <label class="form-label">
                                E-mail
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Digite seu e-mail"
                                required
                                >

                        </div>

                        <!-- Password field -->
                        <div class="mb-3">

                            <label class="form-label">
                                Senha
                            </label>

                            <input
                                type="password"
                                name="senha"
                                class="form-control"
                                placeholder="Digite sua senha"
                                required
                                >

                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-tech w-100">

                            Entrar

                        </button>

                    </form>

                    <hr>

                    <!-- Registration link -->
                    <p class="text-center">

                        Ainda não possui conta?

                        <a href="cadastro.php">
                            Cadastre-se aqui
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<?php include('../includes/footer.php'); ?>
