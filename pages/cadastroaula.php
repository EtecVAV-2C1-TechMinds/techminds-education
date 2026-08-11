<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN - CADASTRO DE AULAS
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$conteudos = $aulaModel->listarConteudos();

// Define o título que o header.php vai carregar
$title = "Cadastrar Vídeo Aulas | TechMinds Education";

// Includes padrão da aplicação
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<!-- Estilos da Tela de Cadastro de Aulas (Design Fiel ao Protótipo) -->
<style>
    :root {
        --green-dark: #233703;
        --green-banner: #8A9E48;
        --green-input: #6B783E;
        --green-btn: #6B783E;
        --bg-light: #EBEBEB;
    }

    body {
        background-color: var(--bg-light) !important;
    }

    /* BANNER */
    .banner {
        background-color: var(--green-banner);
        color: var(--green-dark);
        text-align: center;
        padding: 30px 20px;
    }

    .banner h1 {
        font-weight: 800;
        font-size: 2rem;
        line-height: 1.1;
        margin-bottom: 5px;
        color: #273708;
    }

    .banner p {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
    }

    /* MAIN CONTENT */
    .content {
        padding: 30px 20px;
        max-width: 500px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333333;
        font-size: 0.95rem;
    }

    /* INPUTS & SELECTS FORMATO PÍLULA */
    .form-control, 
    select.form-control,
    textarea.form-control {
        background-color: var(--green-input) !important;
        border: none !important;
        border-radius: 20px !important;
        color: #ffffff !important;
        padding: 10px 18px !important;
        width: 100%;
        outline: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
    }

    .form-control::placeholder,
    textarea.form-control::placeholder {
        color: #e0e0e0 !important;
    }

    .form-control:focus {
        background-color: var(--green-input) !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(107, 120, 62, 0.4) !important;
    }

    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 20px !important;
    }

    select.form-control option {
        background-color: #ffffff;
        color: #333333;
    }

    /* ÁREA DE UPLOAD DO VÍDEO */
    .upload-container {
        text-align: center;
        margin: 20px 0 25px 0;
    }

    .upload-image-icon {
        width: 110px;
        height: auto;
        display: inline-block;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .btn-upload-label {
        background-color: var(--green-btn);
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 8px 35px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.12);
        display: inline-block;
        cursor: pointer;
        transition: transform 0.2s, opacity 0.2s;
    }

    .btn-upload-label:hover {
        opacity: 0.95;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .file-selected-info {
        margin-top: 8px;
        font-size: 0.85rem;
        color: var(--green-dark);
        font-weight: 600;
    }

    /* BOTÃO SUBMIT */
    .btn-submit {
        background-color: var(--green-btn);
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 8px 35px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-top: 10px;
        transition: opacity 0.2s;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }
</style>


<!-- Script para garantir a troca do título da aba do navegador -->
<script>
    document.title = "Cadastrar Vídeo Aulas | TechMinds Education";
</script>


<!-- =========================================
     CABEÇALHO
========================================= -->

<section class="banner">

    <h1>
        Cadastrar<br>
        Vídeo Aulas
    </h1>

    <p>
        Área do administrador
    </p>

</section>


<!-- =========================================
     CONTEÚDO
========================================= -->

<main class="content">

    <div class="form-wrapper">


        <!-- =========================================
             MENSAGENS DE ERRO
        ========================================== -->

        <?php if (isset($_GET['erro'])): ?>

            <div class="alert alert-danger rounded-4">

                <?php

                switch ($_GET['erro']) {

                    case 'preencha':
                        echo 'Preencha todos os campos obrigatórios.';
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

                    default:
                        echo 'Ocorreu um erro.';
                }

                ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             MENSAGENS DE SUCESSO
        ========================================== -->

        <?php if (isset($_GET['sucesso'])): ?>

            <div class="alert alert-success rounded-4">

                <?php

                switch ($_GET['sucesso']) {

                    case 'criado':
                        echo 'Aula cadastrada com sucesso!';
                        break;

                    case 'editado':
                        echo 'Aula editada com sucesso!';
                        break;

                    case 'excluido':
                        echo 'Aula excluída com sucesso!';
                        break;

                    default:
                        echo 'Operação realizada com sucesso.';
                }

                ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             FORMULÁRIO
        ========================================== -->

        <form
            action="../controllers/AulaController.php?acao=criar"
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- CONTEÚDO -->

            <div class="form-group">

                <label for="conteudo_id">
                    Conteúdo/Matéria:
                </label>

                <select
                    id="conteudo_id"
                    name="conteudo_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Selecione o conteúdo
                    </option>


                    <?php foreach ($conteudos as $conteudo): ?>

                        <option
                            value="<?= (int) $conteudo['id']; ?>"
                        >

                            <?= htmlspecialchars(
                                $conteudo['titulo']
                            ); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- TÍTULO -->

            <div class="form-group">

                <label for="titulo">
                    Título da aula:
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    class="form-control"
                    placeholder="Digite o título da aula"
                    required
                >

            </div>


            <!-- DESCRIÇÃO -->

            <div class="form-group">

                <label for="descricao">
                    Descrição:
                </label>

                <textarea
                    id="descricao"
                    name="descricao"
                    class="form-control"
                    rows="3"
                    placeholder="Digite uma descrição para a aula"
                    required
                ></textarea>

            </div>


            <!-- VÍDEO -->

            <div class="form-group">

                <label for="video">
                    Vídeo:
                </label>

                <div class="upload-container">

                    <!-- Imagem da seta de Upload -->
                    <label for="video_file">
                        <img 
                            src="../assets/img/upload_icon.png" 
                            alt="Upload Vídeo" 
                            class="upload-image-icon"
                        >
                    </label>

                    <br>

                    <!-- Botão Faça Upload -->
                    <label for="video_file" class="btn-upload-label">
                        Faça Upload
                    </label>

                    <!-- Input oculto para carregar o arquivo do computador -->
                    <input
                        type="file"
                        id="video_file"
                        name="video_file"
                        accept="video/*"
                        style="display: none;"
                        onchange="exibirNomeArquivo(this)"
                    >

                    <!-- Input mantido para compatibilidade com inserção de URL se necessário -->
                    <input
                        type="text"
                        id="video"
                        name="video"
                        class="form-control mt-3"
                        placeholder="Ou cole o link do vídeo"
                    >

                    <div id="file-info" class="file-selected-info"></div>

                </div>

            </div>


            <!-- MATERIAL -->

            <div class="form-group">

                <label for="material">
                    Material complementar:
                </label>

                <input
                    type="text"
                    id="material"
                    name="material"
                    class="form-control"
                    placeholder="Link ou arquivo do material"
                >

            </div>


            <!-- ORDEM -->

            <div class="form-group">

                <label for="ordem">
                    Ordem da aula:
                </label>

                <input
                    type="number"
                    id="ordem"
                    name="ordem"
                    class="form-control"
                    style="max-width: 120px;"
                    value="1"
                    min="1"
                >

            </div>


            <!-- BOTÃO -->

            <button
                type="submit"
                class="btn-submit"
            >

                Adicionar

            </button>


        </form>

    </div>

</main>

<script>
    function exibirNomeArquivo(input) {
        const infoDiv = document.getElementById('file-info');
        if (input.files && input.files[0]) {
            infoDiv.textContent = 'Arquivo: ' + input.files[0].name;
        } else {
            infoDiv.textContent = '';
        }
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
