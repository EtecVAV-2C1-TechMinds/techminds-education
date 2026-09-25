<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - MANAGE CLASSES
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$aulas = $aulaModel->listar();

$title = "Gerenciar Aulas | " . NOME_SISTEMA;

?>

<?php include('../includes/header.php'); ?>

<?php include('../includes/navbar.php'); ?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- =========================================
     PAGE HEADER
========================================= -->

<section class="py-5" style="background-color: var(--green-main); color: white;">
    <div class="container text-center">
        <h1 class="fw-bold">Gerenciar Aulas</h1>
        <p class="mb-0">Painel Administrativo de Gestão do Conteúdo</p>
    </div>
</section>

<!-- =========================================
     CLASSES MANAGEMENT
========================================= -->

<main class="container py-5">

    <!-- TOP ACTION & FILTERS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h2 class="h4 fw-bold mb-1">Aulas Cadastradas</h2>
                    <p class="text-muted mb-0 small">Consulte, pesquise, edite ou remova aulas da plataforma.</p>
                </div>

                <a href="../pages/cadastroaula.php" class="btn btn-tech d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Cadastrar Nova Aula
                </a>
            </div>

            <hr class="my-3">

            <!-- SEARCH BAR -->
            <div class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="inputBusca" class="form-control bg-light border-start-0" placeholder="Buscar por título ou conteúdo...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="selectStatus" class="form-select bg-light">
                        <option value="">Todos os status</option>
                        <option value="ativa">Somente Ativas</option>
                        <option value="inativa">Somente Inativas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS / ERROR MESSAGES -->

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php
            switch ($_GET['sucesso']) {
                case 'criado':
                    echo 'Aula cadastrada com sucesso.';
                    break;
                case 'editado':
                    echo 'Aula editada com sucesso.';
                    break;
                case 'excluido':
                    echo 'Aula excluída com sucesso.';
                    break;
                default:
                    echo 'Operação realizada com sucesso.';
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Não foi possível realizar a operação.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- CHECK IF THERE ARE CLASSES -->

    <?php if (!empty($aulas)): ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tabelaAulas">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">Ordem</th>
                                <th>Título & Conteúdo</th>
                                <th>Descrição</th>
                                <th style="width: 120px;">Status</th>
                                <th class="text-end pe-4" style="width: 180px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aulas as $aula): ?>
                                <tr class="item-aula" data-status="<?= ((int)$aula['ativo'] === 1) ? 'ativa' : 'inativa'; ?>">
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                                            #<?= (int) $aula['ordem']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark campo-titulo"><?= htmlspecialchars($aula['titulo']); ?></div>
                                        <small class="text-muted d-block campo-conteudo">
                                            <i class="bi bi-folder2 me-1"></i><?= htmlspecialchars($aula['conteudo']); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="text-muted small d-inline-block text-truncate" style="max-width: 280px;" title="<?= htmlspecialchars($aula['descricao'] ?? ''); ?>">
                                            <?= htmlspecialchars($aula['descricao'] ?? 'Sem descrição'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ((int) $aula['ativo'] === 1): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                                <i class="bi bi-dot"></i> Ativa
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1">
                                                <i class="bi bi-dot"></i> Inativa
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="../admin/editar_aula.php?id=<?= (int) $aula['id']; ?>" class="btn btn-outline-primary" title="Editar Aula">
                                                <i class="bi bi-pencil-fill me-1"></i> Editar
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir<?= (int) $aula['id']; ?>" title="Excluir Aula">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>

                                        <!-- MODAL DE EXCLUSÃO PROFISSIONAL -->
                                        <div class="modal fade" id="modalExcluir<?= (int) $aula['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered text-start">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title h6 fw-bold">
                                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Exclusão
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <p class="mb-1">Tem certeza que deseja excluir a aula abaixo?</p>
                                                        <p class="fw-bold text-dark mb-0">"<?= htmlspecialchars($aula['titulo']); ?>"</p>
                                                        <small class="text-danger mt-2 d-block">Esta ação não poderá ser desfeita.</small>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="../controllers/AulaController.php?acao=excluir&id=<?= (int) $aula['id']; ?>" class="btn btn-danger btn-sm">
                                                            Confirmar Exclusão
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php else: ?>

        <!-- EMPTY STATE -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <div class="mb-3 text-muted">
                    <i class="bi bi-journal-x display-4"></i>
                </div>
                <h3 class="fw-bold mb-2">Nenhuma aula cadastrada</h3>
                <p class="text-muted mb-4">Ainda não existem aulas cadastradas nesta plataforma.</p>
                <a href="../pages/cadastroaula.php" class="btn btn-tech">
                    <i class="bi bi-plus-lg me-1"></i> Cadastrar Primeira Aula
                </a>
            </div>
        </div>

    <?php endif; ?>

</main>

<!-- FILTRO EM TEMPO REAL EM JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputBusca = document.getElementById('inputBusca');
    const selectStatus = document.getElementById('selectStatus');
    const linhas = document.querySelectorAll('.item-aula');

    function filtrar() {
        const termo = inputBusca ? inputBusca.value.toLowerCase() : '';
        const status = selectStatus ? selectStatus.value : '';

        linhas.forEach(linha => {
            const titulo = linha.querySelector('.campo-titulo').textContent.toLowerCase();
            const conteudo = linha.querySelector('.campo-conteudo').textContent.toLowerCase();
            const statusLinha = linha.getAttribute('data-status');

            const atendeBusca = titulo.includes(termo) || conteudo.includes(termo);
            const atendeStatus = (status === '' || statusLinha === status);

            if (atendeBusca && atendeStatus) {
                linha.style.display = '';
            } else {
                linha.style.display = 'none';
            }
        });
    }

    if (inputBusca) inputBusca.addEventListener('input', filtrar);
    if (selectStatus) selectStatus.addEventListener('change', filtrar);
});
</script>

<?php include('../includes/footer.php'); ?>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento do código
Finalidade: Auxílio na organização da estrutura CSS e identificação de erros no raciocínio de programação.
Validação: O código foi analisado e testado pelas alunas.
*/
?>
