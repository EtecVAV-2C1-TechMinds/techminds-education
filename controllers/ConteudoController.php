<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTENT CONTROLLER
========================================= */

require_once __DIR__ . '/../models/Conteudo.php';


/* =========================================
   CREATE CONTENT MODEL
========================================= */

$conteudoModel = new Conteudo();


/* =========================================
   GET ACTION
========================================= */

$acao = $_GET['acao'] ?? '';


/* =========================================
   CREATE
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../admin/dashboard.php');

        exit;
    }


    $materia_id = $_POST['materia_id'] ?? '';

    $titulo = trim($_POST['titulo'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');


    /* Validate fields */

    if (
        empty($materia_id) ||
        empty($titulo) ||
        empty($descricao)
    ) {

        header(
            'Location: ../admin/dashboard.php?erro=preencha'
        );

        exit;
    }


    /* Create content */

    try {

        $resultado = $conteudoModel->criar(
            (int) $materia_id,
            $titulo,
            $descricao
        );


        if ($resultado) {

            header(
                'Location: ../admin/dashboard.php?sucesso=criado'
            );

            exit;
        }


        header(
            'Location: ../admin/dashboard.php?erro=criar'
        );

        exit;

    } catch (PDOException $e) {

        header(
            'Location: ../admin/dashboard.php?erro=criar'
        );

        exit;
    }
}


/* =========================================
   UPDATE
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../admin/dashboard.php');

        exit;
    }


    $id = (int) ($_POST['id'] ?? 0);

    $materia_id = $_POST['materia_id'] ?? '';

    $titulo = trim($_POST['titulo'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');


    /* Validate fields */

    if (
        $id <= 0 ||
        empty($materia_id) ||
        empty($titulo) ||
        empty($descricao)
    ) {

        header(
            'Location: ../admin/dashboard.php?erro=preencha'
        );

        exit;
    }


    /* Update content */

    try {

        $resultado = $conteudoModel->atualizar(
            $id,
            (int) $materia_id,
            $titulo,
            $descricao
        );


        if ($resultado) {

            header(
                'Location: ../admin/dashboard.php?sucesso=editado'
            );

            exit;
        }


        header(
            'Location: ../admin/dashboard.php?erro=editar'
        );

        exit;

    } catch (PDOException $e) {

        header(
            'Location: ../admin/dashboard.php?erro=editar'
        );

        exit;
    }
}


/* =========================================
   DELETE
========================================= */

if ($acao === 'excluir') {

    $id = (int) ($_GET['id'] ?? 0);


    if ($id <= 0) {

        header(
            'Location: ../admin/dashboard.php?erro=excluir'
        );

        exit;
    }


    try {

        $resultado = $conteudoModel->excluir($id);


        if ($resultado) {

            header(
                'Location: ../admin/dashboard.php?sucesso=excluido'
            );

            exit;
        }


        header(
            'Location: ../admin/dashboard.php?erro=excluir'
        );

        exit;

    } catch (PDOException $e) {

        header(
            'Location: ../admin/dashboard.php?erro=excluir'
        );

        exit;
    }
}


/* =========================================
   INVALID ACTION
========================================= */

header('Location: ../admin/dashboard.php');

exit;

?>
