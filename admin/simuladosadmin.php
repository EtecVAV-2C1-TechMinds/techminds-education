<?php
require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';

$dadosFormulario = $_SESSION['simulado_form'] ?? [];
unset($_SESSION['simulado_form']);

$title = "Gerenciar Simulados | " . NOME_SISTEMA;

$simuladoModel = new Simulado();

$idEditar = (int) ($_GET['editar'] ?? 0);
$simuladoEditar = null;

if ($idEditar > 0) {
    $simuladoEditar = $simuladoModel->buscarPorId($idEditar);

    if (!$simuladoEditar) {
        header('Location: ' . URL_SISTEMA . '/admin/simuladosadmin.php?erro=nao_encontrado');
        exit;
    }
}

$simulados = $simuladoModel->listarTodos();

/* =========================================
   CARREGAR GABARITO
========================================= */

$gabaritoAtual = [];

if ($simuladoEditar) {
    $gabaritoAtual = $simuladoModel->buscarGabarito($simuladoEditar['id']);
}

// Recupera respostas anteriores caso o formulário tenha apresentado erro.
if (!empty($dadosFormulario['gabarito']) && is_array($dadosFormulario['gabarito'])) {
    $gabaritoAtual = array_merge(
        $gabaritoAtual,
        $dadosFormulario['gabarito']
    );
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<style>
    .simulados-page {
        background: #f1f1f1;
        min-height: 70vh;
        padding: 40px 20px 60px;
    }

    .simulados-container {
        max-width: 1050px;
        margin: 0 auto;
    }

    .simulados-hero {
        background: var(--green-main, #5d7034);
        color: white;
        border-radius: 20px;
        padding: 30px 35px;
        margin-bottom: 25px;
    }

    .simulados-hero h1 {
        font-size: 27px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .simulados-hero p {
        margin: 0;
    }

    .simulado-card {
        background: white;
        border-radius: 18px;
        padding: 25px;
        margin-bottom: 22px;
        box-shadow: 0 5px 16px rgba(0, 0, 0, .07);
    }

    .simulado-card h2 {
        color: var(--green-dark, #233703);
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 20px;
    }

    .campo {
        margin-bottom: 18px;
    }

    .campo label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: #444;
    }

    .campo input,
    .campo textarea {
        display: block;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d5d5d5;
        border-radius: 10px;
        padding: 12px 14px;
        font-family: inherit;
        font-size: 14px;
        background: white;
    }

    .campo textarea {
        min-height: 100px;
        resize: vertical;
    }

    .campo input:focus,
    .campo textarea:focus {
        outline: none;
        border-color: var(--green-main, #5d7034);
    }

    .linha-form {
        display: grid;
        grid-template-columns: 1fr 200px;
        gap: 20px;
    }

    .ajuda {
        display: block;
        color: #777;
        font-size: 13px;
        margin-top: 7px;
    }

    .pdf-atual {
        background: #f4f5f1;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
        overflow-wrap: anywhere;
    }

    .pdf-atual a {
        color: var(--green-dark, #233703);
        font-weight: 600;
    }

    .checkbox-ativo {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 15px 0;
        color: #444;
    }

    .checkbox-ativo input {
        width: auto;
    }

    .botoes {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-verde,
    .btn-cinza,
    .btn-pdf,
    .btn-excluir {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-verde,
    .btn-pdf {
        background: var(--green-main, #5d7034);
        color: white;
    }

    .btn-verde:hover,
    .btn-pdf:hover {
        color: white;
        opacity: .88;
    }

    .btn-cinza {
        background: #e8e8e8;
        color: #333;
    }

    .btn-cinza:hover {
        background: #ddd;
        color: #333;
    }

    .btn-excluir {
        background: #b3261e;
        color: white;
    }

    .btn-excluir:hover {
        color: white;
        opacity: .88;
    }

    .mensagem {
        border-radius: 10px;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .mensagem-sucesso {
        background: #dff4e8;
        color: #176b3a;
    }

    .mensagem-erro {
        background: #fbe1e1;
        color: #9c1c1c;
    }

    .simulado-item {
        border: 1px solid #e1e1e1;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 12px;
        background: #fafafa;
    }

    .simulado-item:last-child {
        margin-bottom: 0;
    }

    .simulado-item-topo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .simulado-item h3 {
        margin: 0 0 6px;
        color: var(--green-dark, #233703);
        font-size: 17px;
    }

    .simulado-item p {
        margin: 0 0 10px;
        color: #777;
        font-size: 13px;
    }

    .info-simulado {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        font-size: 12px;
        color: #666;
    }

    .status-ativo {
        color: #16803c;
        font-weight: 700;
    }

    .status-inativo {
        color: #b3261e;
        font-weight: 700;
    }

    .sem-registros {
        text-align: center;
        color: #777;
        padding: 20px;
    }

    /* =========================================
       GABARITO ADMINISTRATIVO
    ========================================= */

    .gabarito-admin {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        grid-template-rows: repeat(15, auto);
        grid-auto-flow: column;
        gap: 10px 15px;
        margin-top: 15px;
        padding: 15px;
        background: #fafafa;
        border: 1px solid #e1e1e1;
        border-radius: 12px;
    }

    .questao-admin {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 9px 12px;
        background: white;
        border: 1px solid #e1e1e1;
        border-radius: 9px;
        min-width: 0;
    }

    .numero-questao {
        font-size: 14px;
        font-weight: 700;
        color: var(--green-dark, #233703);
    }

    .alternativas-admin {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .alternativa-gabarito {
        cursor: pointer;
    }

    .alternativa-gabarito input {
        display: none;
    }

    .alternativa-gabarito span {
        width: 27px;
        height: 27px;
        border: 1.5px solid var(--green-main, #6B783E);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: var(--green-main, #6B783E);
        transition: .2s;
    }

    .alternativa-gabarito input:checked + span {
        background: var(--green-main, #6B783E);
        color: white;
    }

    /* =========================================
       RESPONSIVIDADE
    ========================================= */

    @media (max-width: 700px) {

        .gabarito-admin {
            grid-template-columns: minmax(0, 1fr);
            grid-template-rows: none;
            grid-auto-flow: row;
            gap: 8px;
            padding: 10px;
        }

        .questao-admin {
            padding: 10px 12px;
        }

        .alternativas-admin {
            gap: 7px;
        }

        .alternativa-gabarito span {
            width: 28px;
            height: 28px;
        }

        .simulados-page {
            padding: 25px 12px 40px;
        }

        .simulados-hero {
            padding: 25px 20px;
        }

        .simulados-hero h1 {
            font-size: 23px;
        }

        .simulado-card {
            padding: 18px;
        }

        .linha-form {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .simulado-item-topo {
            flex-direction: column;
            align-items: stretch;
        }

        .botoes {
            width: 100%;
        }

        .botoes a {
            flex: 1;
        }
    }
</style>

<main class="simulados-page">
    <div class="simulados-container">

        <div class="simulados-hero">
            <h1>Gerenciar Simulados</h1>
            <p>Cadastre simulados, envie os PDFs e gerencie os arquivos. Ao editar um simulado, não é preciso fazer o upload do arquivo novamente.</p>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem mensagem-sucesso">
                <?php
                $mensagens = [
                    'criado' => 'Simulado cadastrado com sucesso!',
                    'editado' => 'Simulado atualizado com sucesso!',
                    'excluido' => 'Simulado excluído com sucesso!'
                ];

                echo htmlspecialchars(
                    $mensagens[$_GET['sucesso']] ?? 'Operação realizada com sucesso!'
                );
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem mensagem-erro">
                <?php
                $erros = [
                    'pdf' => 'Selecione um arquivo PDF válido.',
                    'upload' => 'Não foi possível enviar o arquivo.',
                    'nao_encontrado' => 'Simulado não encontrado.',
                    'gabarito' => 'Preencha todas as 45 respostas corretas do gabarito.',
                    'criar' => 'Não foi possível cadastrar o simulado.',
                    'editar' => 'Não foi possível atualizar o simulado.',
                    'excluir' => 'Não foi possível excluir o simulado.',
                    'preencha' => 'Preencha os campos obrigatórios.',
                    'adicionar' => 'Não foi possível adicionar as questões.',
                    'remover' => 'Não foi possível remover a questão.'
                ];

                echo htmlspecialchars(
                    $erros[$_GET['erro']] ?? 'Ocorreu um erro. Verifique os dados e tente novamente.'
                );
                ?>
            </div>
        <?php endif; ?>

        <!-- CADASTRAR / EDITAR -->

        <section class="simulado-card">

            <h2>
                <?= $simuladoEditar ? 'Editar simulado' : 'Cadastrar novo simulado' ?>
            </h2>

            <form
                action="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=<?= $simuladoEditar ? 'editar' : 'criar' ?>"
                method="POST"
                enctype="multipart/form-data"
            >

                <?php if ($simuladoEditar): ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $simuladoEditar['id'] ?>"
                    >
                <?php endif; ?>

                <div class="linha-form">

                    <div class="campo">
                        <label for="titulo">Título</label>

                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            required
                            maxlength="150"
                            value="<?= htmlspecialchars(
                                $simuladoEditar['titulo']
                                ?? $dadosFormulario['titulo']
                                ?? ''
                            ) ?>"
                            placeholder="Ex.: Simulado de Biologia"
                        >
                    </div>

                    <div class="campo">
                        <label for="tempo_minutos">Tempo (minutos)</label>

                        <input
                            type="number"
                            id="tempo_minutos"
                            name="tempo_minutos"
                            min="1"
                            value="<?= htmlspecialchars(
                                (string) (
                                    $simuladoEditar['tempo_minutos']
                                    ?? $dadosFormulario['tempo_minutos']
                                    ?? ''
                                )
                            ) ?>"
                            placeholder="Ex.: 150"
                        >
                    </div>

                    <div class="checkbox-ativo">
    <input
        type="checkbox"
        name="ativo"
        id="ativo"
        value="1"
        <?= !empty($simuladoEditar['ativo']) || (!$simuladoEditar && !isset($dadosFormulario['ativo']))
            ? 'checked'
            : '' ?>
    >

    <label for="ativo">Simulado ativo</label>
</div>

                </div>

                <!-- DESCRIÇÃO -->

                <div class="campo">
                    <label for="descricao">Descrição</label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        placeholder="Digite uma descrição para o simulado..."
                    ><?= htmlspecialchars(
                        $simuladoEditar['descricao']
                        ?? $dadosFormulario['descricao']
                        ?? ''
                    ) ?></textarea>
                </div>

                <!-- PDF -->

                <div class="campo">

                    <label for="pdf">Arquivo do simulado (PDF)</label>

                    <input
                        type="file"
                        name="pdf"
                        id="pdf"
                        accept=".pdf,application/pdf"
                    >

                    <small class="ajuda">
                        Envie um arquivo PDF. Tamanho máximo: 10 MB.
                    </small>

                    <?php if ($simuladoEditar && !empty($simuladoEditar['pdf_path'])): ?>

                        <div class="pdf-atual">
                            PDF atual:

                            <a
                                href="<?= URL_SISTEMA . '/' . htmlspecialchars($simuladoEditar['pdf_path']) ?>"
                                target="_blank"
                                rel="noopener"
                            >
                                Visualizar PDF
                            </a>
                        </div>

                    <?php endif; ?>

                </div>

                <!-- GABARITO -->

                <div class="campo">

                    <label>Gabarito do Simulado</label>

                    <span class="ajuda">
                        Selecione a alternativa correta correspondente a cada questão do simulado.
                    </span>

                    <div class="gabarito-admin">

                        <?php for ($i = 1; $i <= 45; $i++): ?>

                            <div class="questao-admin">

                                <span class="numero-questao">
                                    <?= $i ?>.
                                </span>

                                <div class="alternativas-admin">

                                    <?php foreach (['A', 'B', 'C', 'D', 'E'] as $letra): ?>

                                        <label class="alternativa-gabarito">

                                            <input
                                                type="radio"
                                                name="gabarito[<?= $i ?>]"
                                                value="<?= $letra ?>"
                                                <?= (($gabaritoAtual[$i] ?? '') === $letra) ? 'checked' : '' ?>
                                            >

                                            <span><?= $letra ?></span>

                                        </label>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                        <?php endfor; ?>

                    </div>

                </div>

                <!-- BOTÕES -->

                <div class="botoes">

                    <button type="submit" class="btn-verde">

                        <i class="fa-solid fa-floppy-disk"></i>

                        <?= $simuladoEditar
                            ? 'Salvar alterações'
                            : 'Cadastrar simulado' ?>

                    </button>

                    <?php if ($simuladoEditar): ?>

                        <a
                            href="<?= URL_SISTEMA ?>/admin/simuladosadmin.php"
                            class="btn-cinza"
                        >
                            Cancelar
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </section>

        <!-- SIMULADOS CADASTRADOS -->

        <section class="simulado-card">

            <h2>Simulados cadastrados</h2>

            <?php if (empty($simulados)): ?>

                <div class="sem-registros">
                    Nenhum simulado cadastrado ainda.
                </div>

            <?php else: ?>

                <?php foreach ($simulados as $simulado): ?>

                    <article class="simulado-item">

                        <div class="simulado-item-topo">

                            <div>

                                <h3>
                                    <?= htmlspecialchars($simulado['titulo']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($simulado['descricao'] ?? '') ?>
                                </p>

                                <div class="info-simulado">

                                    <span>
                                        <strong>Tempo:</strong>

                                        <?= !empty($simulado['tempo_minutos'])
                                            ? (int) $simulado['tempo_minutos'] . ' min'
                                            : 'Sem limite' ?>
                                    </span>

                                    <span>
                                        <strong>PDF:</strong>

                                        <?= !empty($simulado['pdf_path'])
                                            ? 'Cadastrado'
                                            : 'Não cadastrado' ?>
                                    </span>

                                    <span>
                                        <strong>Status:</strong>

                                        <?php if (!empty($simulado['ativo'])): ?>
                                            <span class="status-ativo">Ativo</span>
                                        <?php else: ?>
                                            <span class="status-inativo">Inativo</span>
                                        <?php endif; ?>

                                    </span>

                                </div>

                            </div>

                            <div class="botoes">

                                <?php if (!empty($simulado['pdf_path'])): ?>

                                    <a
                                        class="btn-pdf"
                                        href="<?= URL_SISTEMA . '/' . ltrim(htmlspecialchars($simulado['pdf_path']), '/') ?>"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        <i class="fa-solid fa-file-pdf"></i>
                                        Abrir PDF
                                    </a>

                                <?php endif; ?>

                                <a
                                    href="<?= URL_SISTEMA ?>/admin/simuladosadmin.php?editar=<?= (int) $simulado['id'] ?>"
                                    class="btn-cinza"
                                >
                                    Editar
                                </a>

                                <a
                                    href="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=excluir&id=<?= (int) $simulado['id'] ?>"
                                    class="btn-excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir este simulado?')"
                                >
                                    Excluir
                                </a>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
