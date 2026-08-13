<?php

/* =========================================
   TECHMINDS EDUCATION
   CLASS CONTROLLER
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$acao = $_GET['acao'] ?? '';


/* =========================================
   UPLOAD DE VÍDEO
========================================= */

function processarUploadVideo()
{
    /*
     * Se nenhum arquivo foi selecionado,
     * retorna null para permitir o uso de URL.
     */

    if (
        !isset($_FILES['video_file']) ||
        $_FILES['video_file']['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }


    /* =========================================
       CHECK UPLOAD ERROR
    ========================================== */

    if ($_FILES['video_file']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }


    $arquivo = $_FILES['video_file'];


    /* =========================================
       LIMIT SIZE
       100 MB
    ========================================== */

    $limite = 100 * 1024 * 1024;

    if ($arquivo['size'] > $limite) {
        return false;
    }


    /* =========================================
       VALIDATE MIME TYPE
    ========================================== */

    $tiposPermitidos = [
        'video/mp4',
        'video/webm',
        'video/ogg',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-matroska'
    ];


    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    $tipoArquivo = finfo_file(
        $finfo,
        $arquivo['tmp_name']
    );

    finfo_close($finfo);


    if (!in_array($tipoArquivo, $tiposPermitidos, true)) {
        return false;
    }


    /* =========================================
       CREATE VIDEO DIRECTORY
    ========================================== */

    $pastaVideos = __DIR__ . '/../assets/videos';


    if (!is_dir($pastaVideos)) {

        if (!mkdir($pastaVideos, 0755, true)) {
            return false;
        }

    }


    /* =========================================
       FILE EXTENSION
    ========================================== */

    $extensoes = [
        'video/mp4' => 'mp4',
        'video/webm' => 'webm',
        'video/ogg' => 'ogv',
        'video/quicktime' => 'mov',
        'video/x-msvideo' => 'avi',
        'video/x-matroska' => 'mkv'
    ];


    $extensao = $extensoes[$tipoArquivo] ?? 'mp4';


    /* =========================================
       UNIQUE FILE NAME
    ========================================== */

    $nomeArquivo =
        'aula_' .
        date('Ymd_His') .
        '_' .
        bin2hex(random_bytes(5)) .
        '.' .
        $extensao;


    $destino =
        $pastaVideos .
        DIRECTORY_SEPARATOR .
        $nomeArquivo;


    /* =========================================
       MOVE FILE
    ========================================== */

    if (!move_uploaded_file(
        $arquivo['tmp_name'],
        $destino
    )) {

        return false;

    }


    /* =========================================
       RETURN DATABASE PATH
    ========================================== */

    return 'assets/videos/' . $nomeArquivo;
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
        $conteudo_id <= 0 ||
        empty($titulo) ||
        empty($descricao)
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
       PROCESS VIDEO
    ========================================== */

    $uploadVideo =
        processarUploadVideo();


    if ($uploadVideo === false) {

        header(
            'Location: ../pages/cadastroaula.php?erro=video'
        );

        exit;

    }


    /*
     * Se foi enviado um arquivo,
     * usamos o caminho do arquivo.
     *
     * Caso contrário, usamos a URL digitada.
     */

    if ($uploadVideo !== null) {
        $video = $uploadVideo;
    }


    /* =========================================
       CREATE
    ========================================== */

    try {

        $resultado = $aulaModel->criar(
            $conteudo_id,
            $titulo,
            $descricao,
            $video !== '' ? $video : null,
            $material !== '' ? $material : null,
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
            'Location: ../admin/aulas.php'
        );

        exit;

    }


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
        empty($titulo) ||
        empty($descricao)
    ) {

        header(
            'Location: ../admin/aulas.php?erro=editar'
        );

        exit;

    }


    if ($ordem <= 0) {
        $ordem = 1;
    }


    /* =========================================
       PROCESS NEW VIDEO
    ========================================== */

    $uploadVideo =
        processarUploadVideo();


    if ($uploadVideo === false) {

        header(
            'Location: ../admin/aulas.php?erro=video'
        );

        exit;

    }


    /*
     * Se um novo vídeo foi enviado,
     * substituímos o vídeo anterior.
     */

    if ($uploadVideo !== null) {
        $video = $uploadVideo;
    }


    /* =========================================
       UPDATE
    ========================================== */

    try {

        $resultado = $aulaModel->atualizar(
            $id,
            $conteudo_id,
            $titulo,
            $descricao,
            $video !== '' ? $video : null,
            $material !== '' ? $material : null,
            $ordem
        );


        if ($resultado) {

            header(
                'Location: ../admin/aulas.php?sucesso=editado'
            );

            exit;

        }


        header(
            'Location: ../admin/aulas.php?erro=editar'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../admin/aulas.php?erro=editar'
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
            'Location: ../admin/aulas.php?erro=excluir'
        );

        exit;

    }


    try {

        $resultado =
            $aulaModel->excluir($id);


        if ($resultado) {

            header(
                'Location: ../admin/aulas.php?sucesso=excluido'
            );

            exit;

        }


        header(
            'Location: ../admin/aulas.php?erro=excluir'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../admin/aulas.php?erro=excluir'
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
