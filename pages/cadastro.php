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


            <!-- Error messages -->
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


                        case 'senhas':

                            echo 'As senhas não coincidem.';

                            break;


                        case 'senha_curta':

                            echo 'A senha deve possuir pelo menos 6 caracteres.';

                            break;


                        case 'email_existente':

                            echo 'Este e-mail já está cadastrado.';

                            break;


                        case 'cadastro':

                            echo 'Não foi possível realizar o cadastro.';

                            break;


                        case 'database':

                            echo 'Ocorreu um erro ao acessar o banco de dados.';

                            break;


                        default:

                            echo 'Não foi possível realizar o cadastro.';

                    }

                    ?>

                </div>

            <?php endif; ?>


            <!-- Registration form -->
            <form
                method="POST"
                action="../controllers/CadastroController.php"
            >


                <!-- Full name field -->
                <div class="mb-3">

                    <label class="form-label">
                        Nome Completo
                    </label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        placeholder="Digite seu nome completo"
                        required
                    >

                </div>


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


                <!-- Password fields -->
                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                Senha
                            </label>

                            <input
                                type="password"
                                name="senha"
                                class="form-control"
                                placeholder="Crie uma senha"
                                minlength="6"
                                required
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                Confirmar Senha
                            </label>

                            <input
                                type="password"
                                name="confirmar_senha"
                                class="form-control"
                                placeholder="Repita a senha"
                                minlength="6"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- Terms checkbox -->
                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="termos"
                        value="1"
                        required
                    >

                    <label class="form-check-label">

                        Concordo com os termos de uso da plataforma.

                    </label>

                </div>


                <!-- Submit button -->
                <button
                    type="submit"
                    class="btn btn-tech w-100 py-2"
                >

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

