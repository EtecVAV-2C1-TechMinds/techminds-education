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

                    <!-- Login form -->
                    <form>

                        <!-- Email field -->
                        <div class="mb-3">

                            <label class="form-label">
                                E-mail
                            </label>

                            <input type="email"
                                   class="form-control">

                        </div>

                        <!-- Password field -->
                        <div class="mb-3">

                            <label class="form-label">
                                Senha
                            </label>

                            <input type="password"
                                   class="form-control">

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
