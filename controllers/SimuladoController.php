
<?php

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';

/* =========================================
   CONFIGURAÇÕES
========================================= */

$acao = $_GET['acao'] ?? '';

$simuladoModel = new Simulado();

define('TOTAL_QUESTOES_SIMULADO', 45);

function voltarAdmin($parametros = '')
{
    redirecionar('admin/simuladosadmin.php' . $parametros);
}

/* =========================================
   VALIDAR GABARITO
========================================= */

function validarGabarito($gabarito)
{
    if (!is_array($gabarito) || count($gabarito) !== TOTAL_QUESTOES_SIMULADO) {
        return false;
    }

    for ($i = 1; $i <= TOTAL_QUESTOES_SIMULADO; $i++) {

        if (
            !isset($gabarito[$i]) ||
            !in_array(strtoupper($gabarito[$i]), ['A', 'B', 'C', 'D', 'E'], true)
        ) {
            return false;
        }
    }

    return true;
}

/* =========================================
   ENVIAR PDF
========================================= */

function enviarPDF($arquivo)
{
    if (
        !isset($arquivo) ||
        $arquivo['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }

    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Erro ao enviar o PDF.');
    }

    $limite = 10 * 1024 * 1024;

    if ($arquivo['size'] > $limite) {
        throw new RuntimeException('O PDF deve ter no máximo 10 MB.');
    }

    $extensao = strtolower(
        pathinfo($arquivo['name'], PATHINFO_EXTENSION)
    );

    if ($extensao !== 'pdf') {
        throw new RuntimeException('Envie somente arquivos PDF.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);

    $mime = $finfo->file($arquivo['tmp_name']);

    if ($mime !== 'application/pdf') {
        throw new RuntimeException('Arquivo PDF inválido.');
    }

    // Verifica também a assinatura do arquivo
    $arquivoTemporario = fopen($arquivo['tmp_name'], 'rb');
    $assinatura = fread($arquivoTemporario, 5);
    fclose($arquivoTemporario);

    if ($assinatura !== '%PDF-') {
        throw new RuntimeException('O arquivo não possui formato PDF válido.');
    }

    $pasta = __DIR__ . '/../uploads/pdf-simulados/';

    if (!is_dir($pasta) || !is_writable($pasta)) {
        throw new RuntimeException('A pasta de PDFs não está disponível para gravação.');
    }

    $nomeArquivo = bin2hex(random_bytes(16)) . '.pdf';

    $destino = $pasta . $nomeArquivo;

    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        throw new RuntimeException('Não foi possível salvar o PDF.');
    }

    return 'uploads/pdf-simulados/' . $nomeArquivo;
}

/* =========================================
   REMOVER PDF ANTIGO
========================================= */

function removerPDF($caminho)
{
    if (empty($caminho)) {
        return;
    }

    $prefixo = 'uploads/pdf-simulados/';

    // Só remove arquivos da pasta de simulados
    if (strpos($caminho, $prefixo) !== 0) {
        return;
    }

    $arquivo = __DIR__ . '/../' . $caminho;

    if (is_file($arquivo)) {
        unlink($arquivo);
    }
}

/* =========================================
   CRIAR SIMULADO
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        voltarAdmin();
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);
$ativo = isset($_POST['ativo']) ? 1 : 0;

$gabarito = $_POST['gabarito'] ?? [];

    if ($titulo === '') {
        voltarAdmin('?erro=preencha');
    }

    if (!validarGabarito($gabarito)) {

    $_SESSION['simulado_form'] = [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'tempo_minutos' => $tempo_minutos,
        'ativo' => $ativo,
        'gabarito' => $gabarito
    ];

    voltarAdmin('?erro=gabarito');
}

    if (empty($_FILES['pdf'])) {
        voltarAdmin('?erro=pdf');
    }

    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }

    $caminhoPDF = null;

    try {

        $caminhoPDF = enviarPDF($_FILES['pdf']);

        if (!$caminhoPDF) {
            voltarAdmin('?erro=pdf');
        }


        $pdo = $simuladoModel->getPDO();

        if (!$pdo) {
            throw new RuntimeException('Conexão com banco não encontrada.');
        }

        $pdo->beginTransaction();

        $id = $simuladoModel->criar(
            $titulo,
            $descricao,
            $tempo_minutos,
            $caminhoPDF,
            $ativo
        );

        $simuladoModel->salvarGabarito(
            $id,
            $gabarito
        );

        $pdo->commit();

        voltarAdmin('?sucesso=criado');

    } catch (Throwable $e) {

        if (isset($pdo) && $pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }

        if ($caminhoPDF) {
            removerPDF($caminhoPDF);
        }

        error_log('Erro ao criar simulado: ' . $e->getMessage());

        voltarAdmin('?erro=criar');
    }
}

/* =========================================
   EDITAR SIMULADO
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        voltarAdmin();
    }

    $id = (int) ($_POST['id'] ?? 0);

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);

    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $gabarito = $_POST['gabarito'] ?? [];

    if ($id <= 0 || $titulo === '') {
        voltarAdmin('?erro=preencha');
    }

    if (!validarGabarito($gabarito)) {
        voltarAdmin('?erro=gabarito');
    }

    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }

    $simuladoAtual = $simuladoModel->buscarPorId($id);

    if (!$simuladoAtual) {
        voltarAdmin('?erro=nao_encontrado');
    }

    $pdfAntigo = $simuladoAtual['pdf_path'];

    $pdfNovo = null;

    try {

        // Se enviou outro PDF, faz o upload
        $pdfNovo = enviarPDF($_FILES['pdf'] ?? null);

        // Se não enviou outro, mantém o anterior
        $caminhoPDF = $pdfNovo ?? $pdfAntigo;

        $pdo = $simuladoModel->getPDO();

        if (!$pdo) {
            throw new RuntimeException('Conexão com banco não encontrada.');
        }

        $pdo->beginTransaction();

        $simuladoModel->editar(
            $id,
            $titulo,
            $descricao,
            $tempo_minutos,
            $ativo,
            $caminhoPDF
        );

        $simuladoModel->salvarGabarito(
            $id,
            $gabarito
        );

        $pdo->commit();

        // Remove o arquivo antigo somente depois de salvar tudo
        if ($pdfNovo && $pdfAntigo !== $pdfNovo) {
            removerPDF($pdfAntigo);
        }

        voltarAdmin('?sucesso=editado');

    } catch (Throwable $e) {

        if (isset($pdo) && $pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }

        if ($pdfNovo) {
            removerPDF($pdfNovo);
        }

        error_log('Erro ao editar simulado: ' . $e->getMessage());

        voltarAdmin('?erro=editar');
    }
}

/* =========================================
   EXCLUIR SIMULADO
========================================= */

if ($acao === 'excluir') {

    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        voltarAdmin('?erro=excluir');
    }

    try {

        $simulado = $simuladoModel->buscarPorId($id);

        if (!$simulado) {
            voltarAdmin('?erro=nao_encontrado');
        }

        $simuladoModel->excluir($id);

        removerPDF($simulado['pdf_path']);

        voltarAdmin('?sucesso=excluido');

    } catch (Throwable $e) {

        error_log('Erro ao excluir simulado: ' . $e->getMessage());

        voltarAdmin('?erro=excluir');
    }
}

/* =========================================
   ADICIONAR QUESTÕES
========================================= */

if ($acao === 'adicionar_questoes') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        voltarAdmin();
    }

    $simulado_id = (int) ($_POST['simulado_id'] ?? 0);
    $questoes = $_POST['questoes'] ?? [];

    if ($simulado_id <= 0) {
        voltarAdmin('?erro=preencha');
    }

    if (!is_array($questoes) || count($questoes) === 0) {
        voltarAdmin('?id=' . $simulado_id . '&erro=nenhuma_questao');
    }

    try {

        foreach ($questoes as $questao_id) {

            $questao_id = (int) $questao_id;

            if ($questao_id <= 0) {
                continue;
            }

            if (
                $simuladoModel->questaoJaAdicionada(
                    $simulado_id,
                    $questao_id
                )
            ) {
                continue;
            }

            $ordem = $simuladoModel->proximaOrdem($simulado_id);

            $simuladoModel->adicionarQuestao(
                $simulado_id,
                $questao_id,
                $ordem
            );
        }

        voltarAdmin('?id=' . $simulado_id . '&sucesso=questoes_adicionadas');

    } catch (Throwable $e) {

        error_log('Erro ao adicionar questões: ' . $e->getMessage());

        voltarAdmin('?id=' . $simulado_id . '&erro=adicionar');
    }
}

/* =========================================
   REMOVER QUESTÃO
========================================= */

if ($acao === 'remover_questao') {

    $simulado_id = (int) ($_GET['simulado_id'] ?? 0);
    $questao_id = (int) ($_GET['questao_id'] ?? 0);

    if ($simulado_id <= 0 || $questao_id <= 0) {
        voltarAdmin('?erro=remover');
    }

    try {

        $simuladoModel->removerQuestao(
            $simulado_id,
            $questao_id
        );

        voltarAdmin('?id=' . $simulado_id . '&sucesso=removida');

    } catch (Throwable $e) {

        error_log('Erro ao remover questão: ' . $e->getMessage());

        voltarAdmin('?id=' . $simulado_id . '&erro=remover');
    }
}

voltarAdmin();

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Suporte na verificação de $_SESSION em rotas protegidas (ex: painel administrativo). 
Validação: Lógica de bloqueio e liberação de páginas testada com usuários autenticados e deslogados, com validação pelas alunas. 
*/
