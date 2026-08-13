<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Questao.php';

$title = "Cadastrar Questões | TechMinds Education";

$sqlProximoId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'questoes'";
$stmtProximoId = $pdo->query($sqlProximoId);
$proximoId = $stmtProximoId->fetchColumn();

$sql = "SELECT id, nome FROM materias WHERE ativo = 1 ORDER BY nome";
$stmt = $pdo->query($sql);
$materias = $stmt->fetchAll();

$sqlConteudos = "SELECT id, materia_id, titulo FROM conteudos WHERE ativo = 1 ORDER BY titulo";
$stmtConteudos = $pdo->query($sqlConteudos);
$conteudos = $stmtConteudos->fetchAll(PDO::FETCH_ASSOC);

$questaoModel = new Questao($pdo);


/* =========================================
   PESQUISAR POR ID
========================================= */

$buscarId = $_GET['buscar_id'] ?? '';

if ($buscarId !== '' && ctype_digit($buscarId)) {

    $questoes = $questaoModel->listarPorId((int)$buscarId);

} else {

    $questoes = $questaoModel->listar();

}


/* =========================================
   QUESTÃO PARA EDITAR
========================================= */

$questaoEditar = null;

if (isset($_GET['editar']) && ctype_digit($_GET['editar'])) {

    $questaoEditar = $questaoModel->buscarPorId(
        (int)$_GET['editar']
    );

}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Cadastrar Questões";
$bannerSubtitulo = "Área Administrativa";
include(__DIR__ . '/../includes/banner.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --green-dark: #233703;
            --green-banner: #8A9E48;
            --green-input: #6B783E;
            --green-btn: #6B783E;
            --green-btn-hover: #576332;
            --bg-light: #EBEBEB;
        }

        body {
            background-color: var(--bg-light) !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .questoes-page {
            flex: 1;
            padding: 40px 20px 60px;
        }

        .questoes-container {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            background-color: #fff;
            padding: 35px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
            font-size: 1rem;
        }

        .question-id-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .question-id {
            width: 100%;
            background-color: #E8E8E8;
            border: 2px solid #C5C5C5;
            border-radius: 20px;
            padding: 12px 20px;
            color: #555;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: not-allowed;
        }

        .id-info {
            display: block;
            margin-top: 7px;
            color: #666;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .input-green {
            background-color: var(--green-input) !important;
            border: none !important;
            border-radius: 20px !important;
            color: #fff !important;
            padding: 12px 20px !important;
            width: 100%;
            outline: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.08);
            font-size: 0.95rem;
        }

        .input-green::placeholder {
            color: #e0e0e0 !important;
        }

        .input-green:focus {
            background-color: var(--green-input) !important;
            color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(107,120,62,0.4) !important;
        }

        select.input-green {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 15px center !important;
            background-size: 20px !important;
            cursor: pointer;
        }

        select.input-green option {
            background-color: #fff;
            color: #333;
        }

        .alternativas-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .input-alternativa-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .badge-letra {
            position: absolute;
            left: 15px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid var(--green-dark);
            color: var(--green-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            background-color: #fff;
            pointer-events: none;
        }

        .input-alternativa {
            width: 100%;
            padding: 10px 15px 10px 52px !important;
            border: 1.5px solid #a8a8a8 !important;
            border-radius: 25px !important;
            background-color: #fff !important;
            color: #333 !important;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 0.95rem;
        }

        .input-alternativa:focus {
            border-color: var(--green-dark) !important;
            box-shadow: 0 0 0 0.15rem rgba(35,55,3,0.2) !important;
        }

        .correta-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }

        .select-correta {
            max-width: 180px;
            border-radius: 25px !important;
            text-align: center;
        }

        .dica-correta {
            font-size: 0.85rem;
            color: #666;
            font-weight: 600;
        }

        .btn-submit-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn-submit {
            background-color: var(--green-btn);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 12px 60px;
            font-weight: 700;
            font-size: 1.05rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.12);
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--green-btn-hover);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

<main class="questoes-page">
    <div class="questoes-container">

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success rounded-4 mb-4 text-center">
                <strong>Questão cadastrada com sucesso!</strong><br>
                ID da questão:
                <strong>#<?= htmlspecialchars($_GET['id'] ?? ''); ?></strong>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger rounded-4 mb-4 text-center">
                <?php
                switch ($_GET['erro']) {
                    case 'preencha':
                        echo 'Por favor, preencha todos os campos obrigatórios.';
                        break;
                    case 'cadastro':
                        echo 'Erro ao cadastrar a questão. Tente novamente.';
                        break;
                    default:
                        echo 'Ocorreu um erro ao processar a solicitação.';
                }
                ?>
            </div>
        <?php endif; ?>

        <form
    action="../controllers/QuestaoController.php?acao=<?= $questaoEditar ? 'editar' : 'criar'; ?>"
    method="POST" >

    <?php if ($questaoEditar): ?>

    <input
        type="hidden"
        name="id"
        value="<?= htmlspecialchars($questaoEditar['id']); ?>"
    >

<?php endif; ?>


            <div class="form-group">
                <label>ID da Questão:</label>
                <div class="question-id-box">
                    <input
    type="text"
    class="question-id"
    value="<?= htmlspecialchars($questaoEditar['id'] ?? $proximoId); ?>"
    readonly
>
                </div>
                <small class="id-info">Este ID é gerado automaticamente pelo sistema.</small>
            </div>

            <div class="form-group">
                <label for="materia_id">Matéria:</label>
                <select id="materia_id" name="materia_id" class="input-green" required>
                    <option value="">Selecione a matéria</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= $materia['id']; ?>">
                            <?= htmlspecialchars($materia['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="conteudo_id">Conteúdo:</label>
                <select id="conteudo_id" name="conteudo_id" class="input-green" required disabled>
                    <option value="">Primeiro selecione a matéria</option>
                </select>
            </div>

            <div class="form-group">
                <label for="enunciado">Enunciado:</label>
                <textarea
    id="enunciado"
    name="enunciado"
    class="input-green"
    rows="4"
    placeholder="Digite o enunciado da questão..."
    required
><?= htmlspecialchars($questaoEditar['enunciado'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
    <label>Alternativas:</label>

    <div class="alternativas-wrapper">

        <div class="input-alternativa-container">
            <span class="badge-letra">A</span>

            <input
                type="text"
                name="alternativa_a"
                class="input-alternativa"
                placeholder="Alternativa A"
                value="<?= htmlspecialchars($questaoEditar['alternativa_a'] ?? ''); ?>"
                required
            >
        </div>


        <div class="input-alternativa-container">
            <span class="badge-letra">B</span>

            <input
                type="text"
                name="alternativa_b"
                class="input-alternativa"
                placeholder="Alternativa B"
                value="<?= htmlspecialchars($questaoEditar['alternativa_b'] ?? ''); ?>"
                required
            >
        </div>


        <div class="input-alternativa-container">
            <span class="badge-letra">C</span>

            <input
                type="text"
                name="alternativa_c"
                class="input-alternativa"
                placeholder="Alternativa C"
                value="<?= htmlspecialchars($questaoEditar['alternativa_c'] ?? ''); ?>"
                required
            >
        </div>


        <div class="input-alternativa-container">
            <span class="badge-letra">D</span>

            <input
                type="text"
                name="alternativa_d"
                class="input-alternativa"
                placeholder="Alternativa D"
                value="<?= htmlspecialchars($questaoEditar['alternativa_d'] ?? ''); ?>"
                required
            >
        </div>


        <div class="input-alternativa-container">
            <span class="badge-letra">E</span>

            <input
                type="text"
                name="alternativa_e"
                class="input-alternativa"
                placeholder="Alternativa E"
                value="<?= htmlspecialchars($questaoEditar['alternativa_e'] ?? ''); ?>"
                required
            >
        </div>

    </div>
</div>

           <div class="form-group">
    <label for="resposta_correta">Resposta Correta:</label>

    <div class="correta-container">

        <select
            id="resposta_correta"
            name="resposta_correta"
            class="input-green select-correta"
            required
        >

            <option value="">Selecione</option>

            <option
                value="A"
                <?= ($questaoEditar && $questaoEditar['resposta_correta'] === 'A') ? 'selected' : ''; ?>
            >
                A
            </option>

            <option
                value="B"
                <?= ($questaoEditar && $questaoEditar['resposta_correta'] === 'B') ? 'selected' : ''; ?>
            >
                B
            </option>

            <option
                value="C"
                <?= ($questaoEditar && $questaoEditar['resposta_correta'] === 'C') ? 'selected' : ''; ?>
            >
                C
            </option>

            <option
                value="D"
                <?= ($questaoEditar && $questaoEditar['resposta_correta'] === 'D') ? 'selected' : ''; ?>
            >
                D
            </option>

            <option
                value="E"
                <?= ($questaoEditar && $questaoEditar['resposta_correta'] === 'E') ? 'selected' : ''; ?>
            >
                E
            </option>

        </select>

        <span class="dica-correta">
            Selecione a alternativa correta.
        </span>

    </div>
</div>

            <div class="btn-submit-container">
                <button type="submit" class="btn-submit">
    <?= $questaoEditar ? 'Salvar Alterações' : 'Cadastrar Questão'; ?>
</button>
            </div>

        </form>
    </div>

    <section class="questoes-section container">
        <h2 class="questoes-title">Questões Cadastradas</h2>

        <span class="questoes-count">
            <?php echo count($questoes); ?>
            <?php echo count($questoes) == 1 ? 'questão' : 'questões'; ?>
        </span>

        <form method="GET" action="exercicios.php" class="search-container">
            <input
                type="text"
                name="buscar_id"
                class="search-input"
                placeholder="Busque por ID"
                value="<?php echo isset($_GET['buscar_id']) ? htmlspecialchars($_GET['buscar_id']) : ''; ?>"
            >
            <button type="submit" class="search-icon">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <?php if (empty($questoes)): ?>

            <div class="empty-content text-center py-5">
                <h3>Nenhuma questão cadastrada</h3>
                <p>Cadastre a primeira questão utilizando o formulário acima.</p>
            </div>

        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($questoes as $questao): ?>

                    <div class="col-md-6">
                        <article class="questao-card">

                            <div class="questao-header">
                                <span class="questao-badge">
                                    <?php echo htmlspecialchars($questao['materia'] ?? 'Biologia'); ?>
                                </span>

                                <span class="questao-id">
                                    ID: <?php echo htmlspecialchars($questao['id']); ?>
                                </span>
                            </div>

                            <div class="questao-body">
                                <p class="questao-enunciado">
                                    <?php echo htmlspecialchars($questao['enunciado']); ?>
                                </p>

                                <div class="questao-actions">
                                    <a
                                        href="exercicios.php?editar=<?php echo $questao['id']; ?>"
                                        class="btn-questao-editar"
                                    >
                                        Editar
                                    </a>

                                    <a
    href="../controllers/QuestaoController.php?acao=excluir&id=<?= $questao['id']; ?>"
    class="btn-questao-excluir"
    onclick="return confirm('Tem certeza que deseja excluir esta questão?');"
>
    Excluir
</a>
                                </div>
                            </div>

                        </article>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </section>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script>
    const materiaSelect = document.getElementById('materia_id');
    const conteudoSelect = document.getElementById('conteudo_id');
    const conteudos = <?= json_encode($conteudos); ?>;

    materiaSelect.addEventListener('change', function () {
        const materiaId = this.value;
        conteudoSelect.innerHTML = '';

        if (!materiaId) {
            conteudoSelect.disabled = true;

            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Primeiro selecione a matéria';

            conteudoSelect.appendChild(option);
            return;
        }

        conteudoSelect.disabled = false;

        const optionInicial = document.createElement('option');
        optionInicial.value = '';
        optionInicial.textContent = 'Selecione o conteúdo';

        conteudoSelect.appendChild(optionInicial);

        conteudos
            .filter(conteudo => conteudo.materia_id == materiaId)
            .forEach(conteudo => {
                const option = document.createElement('option');
                option.value = conteudo.id;
                option.textContent = conteudo.titulo;
                conteudoSelect.appendChild(option);
            });
    });



<?php if ($questaoEditar): ?>

    const conteudoEditar = <?= json_encode(
        $questaoEditar['conteudo_id']
    ); ?>;

    const materiaEditar = <?= json_encode(
        $questaoEditar['materia_id']
    ); ?>;

    materiaSelect.value = materiaEditar;

    conteudoSelect.innerHTML = '';

    conteudoSelect.disabled = false;

    const opcaoInicial = document.createElement('option');

    opcaoInicial.value = '';

    opcaoInicial.textContent = 'Selecione o conteúdo';

    conteudoSelect.appendChild(opcaoInicial);


    conteudos
        .filter(conteudo => conteudo.materia_id == materiaEditar)
        .forEach(conteudo => {

            const option = document.createElement('option');

            option.value = conteudo.id;

            option.textContent = conteudo.titulo;

            if (conteudo.id == conteudoEditar) {

                option.selected = true;

            }

            conteudoSelect.appendChild(option);

        });

<?php endif; ?>



</script>

</body>
</html>
