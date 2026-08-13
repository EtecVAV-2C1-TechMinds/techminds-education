<?php

/* =========================================
   TECHMINDS EDUCATION
   CLASS CONTROLLER
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$acao = $_GET['acao'] ?? '';

/* =========================================
   FUNÇÃO PARA FAZER UPLOAD DO VÍDEO
========================================= */

function processarUploadVideo(): ?string
{
    /*
     * Se nenhum arquivo foi enviado,
     * retorna null.
     */

    if (
        !isset($_FILES['video_file']) ||
        $_FILES['video_file']['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }


    /* =========================================
       VERIFICAR ERRO DO UPLOAD
    ========================================== */

    if ($_FILES['video_file']['error'] !== UPLOAD_ERR_OK) {

        header(
            'Location: ../pages/cadastroaula.php?erro=video'
        );

        exit;

    }


    $arquivo = $_FILES['video_file'];


    /* =========================================
       VERIFICAR EXTENSÃO
    ========================================== */

    $extensao = strtolower(
        pathinfo(
            $arquivo['name'],
            PATHINFO_EXTENSION
        )
    );


    $extensoesPermitidas = [
        'mp4',
        'webm',
        'ogg',
        'mov'
    ];


    if (!in_array(
        $extensao,
        $extensoesPermitidas,
        true
    )) {

        header(
            'Location: ../pages/cadastroaula.php?erro=video'
        );

        exit;

    }


    /* =========================================
       CRIAR NOME ÚNICO
    ========================================== */

    $nomeArquivo =
        uniqid('aula_', true) .
        '.' .
        $extensao;


    /* =========================================
       PASTA DOS VÍDEOS
    ========================================== */

    $pastaVideos =
        __DIR__ .
        '/../assets/videos/';


    /*
     * Cria a pasta caso ela ainda não exista.
     */

    if (!is_dir($pastaVideos)) {

        mkdir(
            $pastaVideos,
            0777,
            true
        );

    }


    /* =========================================
       DESTINO
    ========================================== */

    $destino =
        $pastaVideos .
        $nomeArquivo;


    /* =========================================
       MOVER ARQUIVO
    ========================================== */

    if (!move_uploaded_file(
        $arquivo['tmp_name'],
        $destino
    )) {

        header(
            'Location: ../pages/cadastroaula.php?erro=video'
        );

        exit;

    }


    /*
     * Caminho que será salvo no banco.
     */

    return '../assets/videos/' . $nomeArquivo;
}


/* =========================================
   CREATE
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header(
            'Location: ../pages/cadastroaula.php'
        );

        exit;

    }


    /* =========================================
       RECEBER DADOS
    ========================================== */

    $conteudo_id =
        (int) ($_POST['conteudo_id'] ?? 0);

    $titulo =
        trim($_POST['titulo'] ?? '');

    $descricao =
        trim($_POST['descricao'] ?? '');

    $video =
        trim($_POST['video'] ?? '');

    $material =
        trim($_POST['material'] ?? '');

    $ordem =
        (int) ($_POST['ordem'] ?? 1);


    /* =========================================
       VALIDATION
    ========================================== */

    if ($conteudo_id <= 0) {

        header(
            'Location: ../pages/cadastroaula.php?erro=conteudo'
        );

        exit;

    }


    if ($titulo === '') {

        header(
            'Location: ../pages/cadastroaula.php?erro=titulo'
        );

        exit;

    }


    if ($descricao === '') {

        header(
            'Location: ../pages/cadastroaula.php?erro=descricao'
        );

        exit;

    }


    if ($ordem <= 0) {

        $ordem = 1;

    }


    /* =========================================
       UPLOAD DO VÍDEO
    ========================================== */

    $videoUpload =
        processarUploadVideo();


    /*
     * Se foi enviado um arquivo,
     * ele terá prioridade sobre a URL.
     */

    if ($videoUpload !== null) {

        $video = $videoUpload;

    }


    /* =========================================
       CREATE
    ========================================== */

    try {

        $resultado =
            $aulaModel->criar(
                $conteudo_id,
                $titulo,
                $descricao,
                $video !== ''
                    ? $video
                    : null,
                $material !== ''
                    ? $material
                    : null,
                $ordem
            );


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=criado'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=criar'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=criar'
        );

        exit;

    }

}


/* =========================================
   UPDATE
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header(
            'Location: ../pages/cadastroaula.php'
        );

        exit;

    }


    /* =========================================
       RECEBER DADOS
    ========================================== */

    $id =
        (int) ($_POST['id'] ?? 0);

    $conteudo_id =
        (int) ($_POST['conteudo_id'] ?? 0);

    $titulo =
        trim($_POST['titulo'] ?? '');

    $descricao =
        trim($_POST['descricao'] ?? '');

    $video =
        trim($_POST['video'] ?? '');

    $material =
        trim($_POST['material'] ?? '');

    $ordem =
        (int) ($_POST['ordem'] ?? 1);


    /* =========================================
       VALIDATION
    ========================================== */

    if (
        $id <= 0 ||
        $conteudo_id <= 0 ||
        $titulo === '' ||
        $descricao === ''
    ) {

        header(
            'Location: ../pages/cadastroaula.php?erro=preencha'
        );

        exit;

    }


    if ($ordem <= 0) {

        $ordem = 1;

    }


    /* =========================================
       UPLOAD DO NOVO VÍDEO
    ========================================== */

    $videoUpload =
        processarUploadVideo();


    /*
     * Se o administrador enviou
     * um novo vídeo, substitui a URL
     * que estava no campo.
     *
     * Se não enviou arquivo e não colocou
     * URL, o vídeo ficará vazio.
     */

    if ($videoUpload !== null) {

        $video = $videoUpload;

    }


    /* =========================================
       UPDATE
    ========================================== */

    try {

        $resultado =
            $aulaModel->atualizar(
                $id,
                $conteudo_id,
                $titulo,
                $descricao,
                $video !== ''
                    ? $video
                    : null,
                $material !== ''
                    ? $material
                    : null,
                $ordem
            );


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=editado'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=editar'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=editar'
        );

        exit;

    }

}


/* =========================================
   DELETE
========================================= */

if ($acao === 'excluir') {

    $id =
        (int) ($_GET['id'] ?? 0);


    if ($id <= 0) {

        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;

    }


    try {

        $resultado =
            $aulaModel->excluir($id);


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=excluido'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;

    }

}


/* =========================================
   INVALID ACTION
========================================= */

header(
    'Location: ../pages/cadastroaula.php'
);

exit;

?>
