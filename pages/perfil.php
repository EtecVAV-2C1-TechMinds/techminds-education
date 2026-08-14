<?php

/* =========================================
   TECHMINDS EDUCATION
   PERFIL DO USUÁRIO
========================================= */


/* =========================================
   INICIAR SESSÃO
========================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/* =========================================
   VERIFICAR LOGIN
========================================= */

if (empty($_SESSION['usuario_logado']) || empty($_SESSION['usuario_id'])) {

    header('Location: login.php');

    exit;
}


/* =========================================
   CONEXÃO E MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Usuario.php';


$usuarioModel = new Usuario();

$usuarioId = (int) $_SESSION['usuario_id'];


/* =========================================
   BUSCAR USUÁRIO
========================================= */

$usuario = $usuarioModel->buscarPorId($usuarioId);


if (!$usuario) {

    session_destroy();

    header('Location: login.php');

    exit;
}


/* =========================================
   MENSAGENS
========================================= */

$mensagem = '';

$tipoMensagem = '';


/* =========================================
   PROCESSAR FORMULÁRIOS
========================================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    /* =====================================
       EDITAR DADOS
    ====================================== */

    if (
        isset($_POST['acao']) &&
        $_POST['acao'] === 'editar_dados'
    ) {

        $nome = trim($_POST['nome'] ?? '');

        $email = trim($_POST['email'] ?? '');


        /* Validar nome */

        if ($nome === '') {

            $mensagem = 'Digite seu nome completo.';

            $tipoMensagem = 'erro';

        }


        /* Validar e-mail */

        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $mensagem = 'Digite um e-mail válido.';

            $tipoMensagem = 'erro';

        }


        else {

            /* Verificar e-mail duplicado */

            $outroUsuario =
                $usuarioModel->buscarPorEmail($email);


            if (
                $outroUsuario &&
                (int) $outroUsuario['id'] !== $usuarioId
            ) {

                $mensagem =
                    'Este e-mail já está cadastrado.';

                $tipoMensagem = 'erro';

            }


            else {

                $atualizado =
                    $usuarioModel->atualizarDados(
                        $usuarioId,
                        $nome,
                        $email
                    );


                if ($atualizado) {

                    /* Atualizar sessão */

                    $_SESSION['usuario_nome'] = $nome;

                    $_SESSION['usuario_email'] = $email;


                    /* Buscar dados novamente */

                    $usuario =
                        $usuarioModel->buscarPorId(
                            $usuarioId
                        );


                    $mensagem =
                        'Dados atualizados com sucesso!';

                    $tipoMensagem = 'sucesso';

                }

                else {

                    $mensagem =
                        'Não foi possível atualizar os dados.';

                    $tipoMensagem = 'erro';

                }

            }

        }

    }


    /* =====================================
       UPLOAD DA FOTO
    ====================================== */

    elseif (
        isset($_POST['acao']) &&
        $_POST['acao'] === 'foto'
    ) {


        if (
            isset($_FILES['foto']) &&
            $_FILES['foto']['error'] === UPLOAD_ERR_OK
        ) {

            $arquivo = $_FILES['foto'];


            /* =================================
               TAMANHO
            ================================= */

            if ($arquivo['size'] > 2 * 1024 * 1024) {

                $mensagem =
                    'A foto deve ter no máximo 2 MB.';

                $tipoMensagem = 'erro';

            }


            else {


                /* =================================
                   VERIFICAR TIPO
                ================================= */

                $tipo =
                    mime_content_type(
                        $arquivo['tmp_name']
                    );


                $tiposPermitidos = [

                    'image/jpeg',
                    'image/png',
                    'image/webp'

                ];


                if (!in_array(
                    $tipo,
                    $tiposPermitidos,
                    true
                )) {

                    $mensagem =
                        'Formato de imagem inválido. Use JPG, PNG ou WEBP.';

                    $tipoMensagem = 'erro';

                }


                else {


                    /* =================================
                       DEFINIR EXTENSÃO
                    ================================= */

                    switch ($tipo) {

                        case 'image/jpeg':
                            $extensao = 'jpg';
                            break;

                        case 'image/png':
                            $extensao = 'png';
                            break;

                        case 'image/webp':
                            $extensao = 'webp';
                            break;

                    }


                    /* =================================
                       NOME DO ARQUIVO
                    ================================= */

                    $nomeArquivo =
                        'perfil_' .
                        $usuarioId .
                        '_' .
                        uniqid() .
                        '.' .
                        $extensao;


                    /* =================================
                       CAMINHO DA PASTA
                    ================================= */

                    $pasta =
                        dirname(__DIR__) .
                        DIRECTORY_SEPARATOR .
                        'uploads' .
                        DIRECTORY_SEPARATOR .
                        'perfil' .
                        DIRECTORY_SEPARATOR;


                    /* =================================
                       CRIAR PASTA
                    ================================= */

                    if (!is_dir($pasta)) {

                        if (!mkdir($pasta, 0777, true)) {

                            $mensagem =
                                'Não foi possível criar a pasta de uploads.';

                            $tipoMensagem = 'erro';

                        }

                    }


                    /* =================================
                       ENVIAR FOTO
                    ================================= */

                    if ($tipoMensagem !== 'erro') {


                        $caminhoCompleto =
                            $pasta .
                            $nomeArquivo;


                        if (
                            move_uploaded_file(
                                $arquivo['tmp_name'],
                                $caminhoCompleto
                            )
                        ) {


                            /* =================================
                               CAMINHO SALVO NO BANCO
                            ================================= */

                            $caminhoBanco =
                                'uploads/perfil/' .
                                $nomeArquivo;


                            /* =================================
                               ATUALIZAR BANCO
                            ================================= */

                            $atualizou =
                                $usuarioModel->atualizarFoto(
                                    $usuarioId,
                                    $caminhoBanco
                                );


                            if ($atualizou) {

                                $usuario =
                                    $usuarioModel->buscarPorId(
                                        $usuarioId
                                    );


                                $mensagem =
                                    'Foto atualizada com sucesso!';

                                $tipoMensagem = 'sucesso';

                            }

                            else {

                                $mensagem =
                                    'A foto foi enviada, mas não foi possível salvar no banco.';

                                $tipoMensagem = 'erro';

                            }

                        }

                        else {

                            $mensagem =
                                'Não foi possível enviar a foto.';

                            $tipoMensagem = 'erro';

                        }

                    }

                }

            }

        }

        else {

            $mensagem =
                'Selecione uma imagem para enviar.';

            $tipoMensagem = 'erro';

        }

    }

}

?>


<?php include('../includes/header.php'); ?>


<?php include('../includes/navbar.php'); ?>


<style>

/* =========================================
   PERFIL
========================================= */

.profile-page {

    background-color: #eaeaea;

    min-height: calc(100vh - 140px);

    padding: 55px 20px 70px;

}


/* =========================================
   CARD
========================================= */

.profile-card {

    background-color: #ffffff;

    border: 2px solid #8b5cf6;

    border-radius: 8px;

    width: 100%;

    max-width: 850px;

    margin: 0 auto;

    padding: 32px;

    display: grid;

    grid-template-columns: 220px 1fr;

    gap: 28px;

    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.05);

}


/* =========================================
   FOTO
========================================= */

.avatar-section {

    background-color: #f4f4f4;

    border-radius: 16px;

    padding: 25px 15px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    min-height: 280px;

}


.avatar-preview {

    width: 125px;

    height: 125px;

    border-radius: 50%;

    background-color: #eeeeee;

    margin-bottom: 20px;

    overflow: hidden;

    display: flex;

    justify-content: center;

    align-items: center;

}


.avatar-preview img {

    width: 100%;

    height: 100%;

    object-fit: cover;

}


.avatar-placeholder {

    font-size: 55px;

    color: #56358c;

}


/* =========================================
   UPLOAD
========================================= */

.upload-form {

    width: 100%;

}


.upload-box {

    cursor: pointer;

    display: flex;

    flex-direction: column;

    align-items: center;

    color: #555555;

    transition: opacity 0.2s;

}


.upload-box:hover {

    opacity: 0.7;

}


.upload-icon {

    width: 38px;

    height: 38px;

    margin-bottom: 8px;

}


.upload-box span {

    font-size: 0.78rem;

    color: #666666;

}


/* =========================================
   INFORMAÇÕES
========================================= */

.info-section {

    display: flex;

    flex-direction: column;

}


.info-section h2 {

    font-size: 1.45rem;

    color: #222222;

    margin-bottom: 18px;

    font-weight: 700;

}


/* =========================================
   MENSAGEM
========================================= */

.message {

    padding: 11px 15px;

    border-radius: 8px;

    margin-bottom: 15px;

    font-size: 0.85rem;

}


.message-sucesso {

    background-color: #edf5df;

    color: #536233;

}


.message-erro {

    background-color: #fce8e8;

    color: #9b2c2c;

}


/* =========================================
   CAIXA DOS DADOS
========================================= */

.student-info {

    border: 1px solid #d8d8d8;

    border-radius: 12px;

    padding: 8px 18px;

    background-color: #fafafa;

    box-shadow:
        0 2px 6px rgba(0, 0, 0, 0.04);

}


/* =========================================
   CAMPO
========================================= */

.field-group {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding: 14px 0;

}


.field-group + .field-group {

    border-top: 1px solid #e5e5e5;

}


.field-content {

    display: flex;

    flex-direction: column;

    gap: 5px;

    min-width: 0;

}


.field-label {

    font-size: 0.76rem;

    color: #777777;

}


.field-value {

    font-size: 0.95rem;

    color: #333333;

    font-weight: 600;

    word-break: break-word;

}


/* =========================================
   BOTÃO EDITAR
========================================= */

.btn-edit {

    background-color: #ab8233;

    color: #ffffff;

    border: none;

    padding: 8px 22px;

    border-radius: 20px;

    font-weight: bold;

    font-size: 0.82rem;

    cursor: pointer;

    white-space: nowrap;

    transition: 0.2s;

}


.btn-edit:hover {

    background-color: #936e29;

}


/* =========================================
   ÁREA DO ALUNO
========================================= */

.btn-student-area {

    display: block;

    background-color: #ab8233;

    color: #ffffff;

    border: none;

    padding: 12px;

    border-radius: 25px;

    font-weight: bold;

    font-size: 0.95rem;

    width: 100%;

    margin-top: 18px;

    text-align: center;

    text-decoration: none;

    transition: 0.2s;

}


.btn-student-area:hover {

    background-color: #936e29;

    color: #ffffff;

}


/* =========================================
   MODAL
========================================= */

.modal-overlay {

    position: fixed;

    inset: 0;

    background-color: rgba(0, 0, 0, 0.5);

    display: none;

    align-items: center;

    justify-content: center;

    padding: 20px;

    z-index: 9999;

}


.modal-overlay.active {

    display: flex;

}


.modal-box {

    width: 100%;

    max-width: 480px;

    background-color: #ffffff;

    border-radius: 14px;

    padding: 30px;

    box-shadow:
        0 8px 30px rgba(0, 0, 0, 0.2);

}


.modal-box h3 {

    color: #333333;

    margin-bottom: 20px;

}


.modal-label {

    display: block;

    font-size: 0.85rem;

    color: #555555;

    margin-bottom: 6px;

}


.modal-input {

    width: 100%;

    padding: 11px 13px;

    border: 1px solid #cccccc;

    border-radius: 8px;

    margin-bottom: 16px;

    outline: none;

}


.modal-input:focus {

    border-color: #ab8233;

}


.modal-buttons {

    display: flex;

    justify-content: flex-end;

    gap: 10px;

}


.btn-cancel {

    background-color: #dddddd;

    color: #333333;

    border: none;

    padding: 9px 20px;

    border-radius: 20px;

    font-weight: bold;

    cursor: pointer;

}


.btn-save {

    background-color: #ab8233;

    color: #ffffff;

    border: none;

    padding: 9px 20px;

    border-radius: 20px;

    font-weight: bold;

    cursor: pointer;

}


.btn-save:hover {

    background-color: #936e29;

}


/* =========================================
   RESPONSIVO
========================================= */

@media (max-width: 700px) {

    .profile-card {

        grid-template-columns: 1fr;

    }


    .avatar-section {

        min-height: 240px;

    }

}


@media (max-width: 500px) {

    .profile-card {

        padding: 20px;

    }


    .field-group {

        align-items: flex-start;

    }


    .btn-edit {

        padding: 7px 15px;

    }

}

</style>


<!-- =========================================
     PÁGINA DO PERFIL
========================================= -->

<main class="profile-page">


    <div class="profile-card">


        <!-- =====================================
             FOTO
        ====================================== -->

        <div class="avatar-section">


            <div class="avatar-preview">

                <?php if (!empty($usuario['foto'])): ?>

                    <img
                        src="../<?= htmlspecialchars($usuario['foto']) ?>"
                        alt="Foto de perfil"
                    >

                <?php else: ?>

                    <span class="avatar-placeholder">
                        👤
                    </span>

                <?php endif; ?>

            </div>


            <form
                method="POST"
                enctype="multipart/form-data"
                class="upload-form"
            >

                <input
                    type="hidden"
                    name="acao"
                    value="foto"
                >


                <label
                    for="file-upload"
                    class="upload-box"
                >

                    <svg
                        class="upload-icon"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 10l7-7m0 0l7 7m-7-7v18"
                        ></path>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 21H5"
                        ></path>

                    </svg>


                    <span>
                        Faça upload da foto de perfil
                    </span>

                </label>


                <input
                    id="file-upload"
                    name="foto"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    style="display: none;"
                    onchange="this.form.submit();"
                >

            </form>

        </div>



        <!-- =====================================
             DADOS
        ====================================== -->

        <div class="info-section">


            <h2>

                Seja bem-vindo(a),
                <?= htmlspecialchars($usuario['nome']) ?>!

            </h2>


            <?php if ($mensagem !== ''): ?>

                <div
                    class="message
                    <?= $tipoMensagem === 'sucesso'
                        ? 'message-sucesso'
                        : 'message-erro' ?>"
                >

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>



            <div class="student-info">


                <!-- NOME -->

                <div class="field-group">

                    <div class="field-content">

                        <span class="field-label">
                            Nome Completo
                        </span>

                        <span class="field-value">

                            <?= htmlspecialchars(
                                $usuario['nome']
                            ) ?>

                        </span>

                    </div>


                    <button
                        type="button"
                        class="btn-edit"
                        onclick="abrirModal()"
                    >

                        Editar

                    </button>

                </div>



                <!-- EMAIL -->

                <div class="field-group">

                    <div class="field-content">

                        <span class="field-label">
                            E-mail
                        </span>

                        <span class="field-value">

                            <?= htmlspecialchars(
                                $usuario['email']
                            ) ?>

                        </span>

                    </div>


                    <button
                        type="button"
                        class="btn-edit"
                        onclick="abrirModal()"
                    >

                        Editar

                    </button>

                </div>


            </div>



            <!-- ÁREA DO ALUNO -->
<a
    href="conteudo.php"
    class="btn-student-area"
>
    Área do aluno
</a>


        </div>

    </div>

</main>



<!-- =========================================
     MODAL EDITAR
========================================= -->

<div
    id="modalEditar"
    class="modal-overlay"
>


    <div class="modal-box">


        <h3>
            Editar meus dados
        </h3>


        <form method="POST">


            <input
                type="hidden"
                name="acao"
                value="editar_dados"
            >


            <label
                class="modal-label"
                for="nome"
            >

                Nome Completo

            </label>


            <input
                type="text"
                id="nome"
                name="nome"
                class="modal-input"
                value="<?= htmlspecialchars(
                    $usuario['nome']
                ) ?>"
                maxlength="100"
                required
            >


            <label
                class="modal-label"
                for="email"
            >

                E-mail

            </label>


            <input
                type="email"
                id="email"
                name="email"
                class="modal-input"
                value="<?= htmlspecialchars(
                    $usuario['email']
                ) ?>"
                maxlength="150"
                required
            >


            <div class="modal-buttons">


                <button
                    type="button"
                    class="btn-cancel"
                    onclick="fecharModal()"
                >

                    Cancelar

                </button>


                <button
                    type="submit"
                    class="btn-save"
                >

                    Salvar alterações

                </button>


            </div>


        </form>

    </div>

</div>



<script>

/* =========================================
   ABRIR MODAL
========================================= */

function abrirModal() {

    document
        .getElementById('modalEditar')
        .classList
        .add('active');

}


/* =========================================
   FECHAR MODAL
========================================= */

function fecharModal() {

    document
        .getElementById('modalEditar')
        .classList
        .remove('active');

}


/* =========================================
   FECHAR CLICANDO FORA
========================================= */

document
    .getElementById('modalEditar')
    .addEventListener(
        'click',
        function(event) {

            if (event.target === this) {

                fecharModal();

            }

        }
    );

</script>


<?php include('../includes/footer.php'); ?>
