<?php include('../includes/header.php'); ?>

<?php include('../includes/navbar.php'); ?>

<!-- Registration section -->
<section class="container py-5">

<div class="row justify-content-center">

    <div class="col-lg-7">

        <!-- Registration card -->
        <div class="card shadow-lg border-0">

            <div class="card-body p-5">

                <!-- Page heading -->
                <div class="text-center mb-4">

                    <h1 class="fw-bold">
                        Crie sua Conta
                    </h1>

                   <p class="text-muted">
                     Cadastre-se para acessar os conteúdos da plataforma,
                      acompanhar seu desempenho e organizar seus estudos
                      de forma prática e eficiente.
                    </p>

                </div>

                <!-- Registration form -->
                <form method="POST">

                    <!-- Full name field -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nome Completo
                        </label>

                        <input type="text"
                               class="form-control"
                               placeholder="Digite seu nome completo">

                    </div>

                    <!-- Email field -->
                    <div class="mb-3">

                        <label class="form-label">
                            E-mail
                        </label>

                        <input type="email"
                               class="form-control"
                               placeholder="Digite seu e-mail">

                    </div>

                    <!-- Password fields -->
                    <div class="row">

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Senha
                                </label>

                                <input type="password"
                                       class="form-control"
                                       placeholder="Crie uma senha">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Confirmar Senha
                                </label>

                                <input type="password"
                                       class="form-control"
                                       placeholder="Repita a senha">

                            </div>

                        </div>

                    </div>

                    <!-- Terms checkbox -->
                    <div class="form-check mb-4">

                        <input class="form-check-input"
                               type="checkbox">

                        <label class="form-check-label">

                            Concordo com os termos de uso da plataforma.

                        </label>

                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-tech w-100 py-2">

                        Criar Conta

                    </button>

                </form>

                <hr class="my-4">

                <!-- Login link -->
                <div class="text-center">

                    <p class="mb-0">

                        Já possui uma conta?

                        <a href="login.php">
                            Entrar agora
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</section>

<?php include('../includes/footer.php'); ?>
