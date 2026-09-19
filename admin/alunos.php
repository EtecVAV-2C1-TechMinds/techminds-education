<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - GERENCIAR ALUNOS
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Usuario.php';

$usuarioModel = new Usuario();
$alunos = $usuarioModel->listarAlunos();

$title = "Gerenciar Alunos | " . NOME_SISTEMA;

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<section class="py-5" style="background-color: var(--green-main); color: white;">
    <div class="container text-center">
        <h1 class="fw-bold">Gerenciar Alunos</h1>
        <p class="mb-0">Área do administrador</p>
    </div>
</section>

<main class="container py-5">

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success">Status do aluno atualizado com sucesso.</div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger">Não foi possível atualizar o status do aluno.</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cadastro</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($alunos as $aluno): ?>

                        <tr>
                            <td><?= htmlspecialchars($aluno['nome']); ?></td>
                            <td><?= htmlspecialchars($aluno['email']); ?></td>
                            <td><?= formatarData($aluno['data_cadastro']); ?></td>
                            <td>
                                <?php if ((int) $aluno['ativo'] === 1): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>

                                <?php if ((int) $aluno['ativo'] === 1): ?>

                                    <a
                                        href="../controllers/AdminController.php?acao=aluno_status&id=<?= (int) $aluno['id']; ?>&status=0"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Desativar o acesso deste aluno?');"
                                    >
                                        Desativar
                                    </a>

                                <?php else: ?>

                                    <a
                                        href="../controllers/AdminController.php?acao=aluno_status&id=<?= (int) $aluno['id']; ?>&status=1"
                                        class="btn btn-outline-success btn-sm"
                                    >
                                        Ativar
                                    </a>

                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>