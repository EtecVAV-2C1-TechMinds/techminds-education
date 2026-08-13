<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - CADASTRO DE AULAS
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();
$conteudos = $aulaModel->listarConteudos();

$title = "Cadastrar Vídeo Aulas | TechMinds Education";

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

$bannerTitulo = "Cadastrar Vídeo Aula";
$bannerSubtitulo = "Painel Administrativo TechMinds";
include(__DIR__ . '/../includes/banner.php');

?>

<style>
    :root {
        --green-primary: #6B783E;
        --green-dark: #233703;
        --green-banner: #8A9E48;
        --bg-light: #F4F6F8;
        --text-color: #2D3748;
        --border-color: #E2E8F0;
    }

    body {
        background-color: var(--bg-light) !important;
        color: var(--text-color);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* BANNER */
    .banner {
        background-color: var(--green-banner);
        color: #ffffff;
        text-align: center;
        padding: 40px 20px;
    }

    .banner h1 {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 8px;
        color: var(--green-dark);
    }

    .banner p {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
    }

    /* MAIN CONTENT */
    .content {
        padding: 40px 20px;
        max-width: 580px;
        margin: 0 auto;
    }

    /* CARD DO FORMULÁRIO */
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #4A5568;
        font-size: 0.875rem;
    }

    /* INPUTS & SELECTS */
    .form-control, 
    select.form-control,
    textarea.form-control {
        width: 100%;
        background-color: #F8FAFC !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 10px !important;
        color: var(--text-color) !important;
        padding: 12px 16px !important;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease-in-out;
    }

    .form-control::placeholder,
    textarea.form-control::placeholder {
        color: #A0AEC0 !important;
    }

    .form-control:focus {
        background-color: #ffffff !important;
        border-color: var(--green-primary) !important;
        box-shadow: 0 0 0 3px rgba(107, 120, 62, 0.15) !important;
    }

    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236B783E'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 20px !important;
        padding-right: 40px !important;
    }

    /* ÁREA DE UPLOAD LIMPA E MODERNA */
    .upload-box {
        border: 2px dashed #CBD5E0;
        border-radius: 12px;
        padding: 24px 16px;
        text-align: center;
        background-color: #F8FAFC;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .upload-box:hover {
        border-color: var(--green-primary);
        background-color: #F1F5F9;
    }

    .upload-icon {
        width: 44px;
        height: 44px;
        margin-bottom: 8px;
        opacity: 0.7;
    }

    .upload-text {
        font-size: 0.875rem;
        color: #4A5568;
        margin: 0;
    }

    .upload-text span {
        color: var(--green-primary);
        font-weight: 600;
        text-decoration: underline;
    }

    .file-selected-info {
        margin-top: 10px;
        font-size: 0.85rem;
        color: var(--green-dark);
        font-weight: 600;
        word-break: break-all;
    }

    /* SEPARADOR "OU" */
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 16px 0;
        color: #A0AEC0;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--border-color);
    }

    .divider span {
        padding: 0 10px;
    }

    /* BOTÃO SUBMIT */
    .btn-submit {
        width: 100%;
        background-color: var(--green-primary);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 14px 20px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-submit:hover {
        background-color: var(--green-dark);
    }

    .btn-submit:active {
        transform: scale(0.99);
    }
    /* =========================================
   BOTÃO GERENCIAR AULAS
========================================= */

.admin-navigation {
    margin-bottom: 20px;
    display: flex;
    justify-content: flex-end;
}

.btn-manage-aulas {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    background-color: #ffffff;
    color: var(--green-dark);

    border: 1px solid var(--green-primary);
    border-radius: 10px;

    padding: 10px 16px;

    font-size: 0.9rem;
    font-weight: 600;

    text-decoration: none;

    transition: all 0.2s ease;
}

.btn-manage-aulas:hover {
    background-color: var(--green-primary);
    color: #ffffff;
}
</style>

<script>
    document.title = "Cadastrar Vídeo Aulas | TechMinds Education";
</script>

<!-- CABEÇALHO -->
<section class="banner">
    <h1>Cadastrar Vídeo Aula</h1>
    <p>Painel Administrativo TechMinds</p>
</section>

<!-- CONTEÚDO -->
<main class="content">

    <!-- =========================================
         NAVEGAÇÃO ADMINISTRATIVA
    ========================================== -->

    <div class="admin-navigation">

        <a href="../admin/aulas.php" class="btn-manage-aulas">
            ← Ver aulas cadastradas
        </a>

    </div>


    <div class="form-card">

        <!-- MENSAGENS DE ERRO -->
        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger rounded-3 mb-4">
                <?php
                switch ($_GET['erro']) {

    case 'preencha':
        echo 'Preencha todos os campos obrigatórios.';
        break;

    case 'conteudo':
        echo 'Selecione o conteúdo / matéria da aula.';
        break;

    case 'titulo':
        echo 'Digite o título da aula.';
        break;

    case 'descricao':
        echo 'Digite a descrição da aula.';
        break;

    case 'criar':
        echo 'Não foi possível cadastrar a aula.';
        break;

    case 'editar':
        echo 'Não foi possível editar a aula.';
        break;

    case 'excluir':
        echo 'Não foi possível excluir a aula.';
        break;

    case 'video':
        echo 'Não foi possível enviar o vídeo. Verifique o formato e o tamanho do arquivo.';
        break;

    default:
        echo 'Ocorreu um erro ao processar a requisição.';
        break;

                }
                ?>
            </div>
        <?php endif; ?>

        <!-- MENSAGENS DE SUCESSO -->
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success rounded-3 mb-4">
                <?php
                switch ($_GET['sucesso']) {
                    case 'criado': echo 'Aula cadastrada com sucesso!'; break;
                    case 'editado': echo 'Aula editada com sucesso!'; break;
                    case 'excluido': echo 'Aula excluída com sucesso!'; break;
                    default: echo 'Operação realizada com sucesso.';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- FORMULÁRIO -->
        <form action="../controllers/AulaController.php?acao=criar" method="POST" enctype="multipart/form-data">

            <!-- CONTEÚDO -->
            <div class="form-group">
                <label for="conteudo_id">Conteúdo / Matéria</label>
                <select id="conteudo_id" name="conteudo_id" class="form-control" required>
                    <option value="" disabled selected>Selecione a matéria correspondente</option>
                    <?php foreach ($conteudos as $conteudo): ?>
                        <option value="<?= (int) $conteudo['id']; ?>">
                            <?= htmlspecialchars($conteudo['titulo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- TÍTULO -->
            <div class="form-group">
                <label for="titulo">Título da Aula</label>
                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Introdução às Variáveis" required>
            </div>

            <!-- DESCRIÇÃO -->
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3" placeholder="Resumo dos tópicos abordados nesta aula" required></textarea>
            </div>

            <!-- VÍDEO (UPLOAD / LINK) -->
            <div class="form-group">
                <label>Arquivo de Vídeo ou Link</label>
                
                <!-- Caixa de Dropzone/Upload -->
                <label for="video_file" class="upload-box">
                    <img src="../assets/img/upload_icon.png" alt="Upload" class="upload-icon" onerror="this.style.display='none'">
                    <p class="upload-text"><span>Clique para enviar</span> ou arraste o arquivo até aqui</p>
                    <input type="file" id="video_file" name="video_file" accept="video/*" style="display: none;" onchange="exibirNomeArquivo(this)">
                </label>
                <div id="file-info" class="file-selected-info"></div>

                <div class="divider"><span>ou</span></div>

                <!-- Input para URL -->
                <input type="text" id="video" name="video" class="form-control" placeholder="Cole a URL do vídeo (YouTube, Vimeo, etc.)">
            </div>

            <!-- MATERIAL COMPLEMENTAR -->
            <div class="form-group">
                <label for="material">Material Complementar</label>
                <input type="text" id="material" name="material" class="form-control" placeholder="Link de slides, PDF ou repositório no GitHub">
            </div>

            <!-- ORDEM DA AULA -->
            <div class="form-group">
                <label for="ordem">Ordem de Exibição</label>
                <input type="number" id="ordem" name="ordem" class="form-control" style="max-width: 140px;" value="1" min="1">
            </div>

            <!-- BOTÃO SUBMIT -->
            <button type="submit" class="btn-submit">
                Cadastrar Aula
            </button>

        </form>
    </div>
</main>

<script>
    function exibirNomeArquivo(input) {
        const infoDiv = document.getElementById('file-info');
        if (input.files && input.files[0]) {
            infoDiv.textContent = '✔ Arquivo selecionado: ' + input.files[0].name;
        } else {
            infoDiv.textContent = '';
        }
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
