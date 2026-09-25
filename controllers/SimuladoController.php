<?php

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';


$acao = $_GET['acao'] ?? '';



/* =========================================================
   CRIAR SIMULADO
   ========================================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/simuladosadmin.php');
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);

    if ($titulo === '') {
        redirecionar('admin/simuladosadmin.php?erro=preencha');
    }

    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }

    try {

        $simuladoModel = new Simulado();

        $idGerado = $simuladoModel->criar(
            $titulo,
            $descricao,
            $tempo_minutos
        );

        redirecionar(
            'admin/simuladosadmin.php?sucesso=criado&id=' . $idGerado
        );

    } catch (PDOException $e) {

        error_log(
            'Erro ao criar simulado: ' . $e->getMessage()
        );

        redirecionar(
            'admin/simuladosadmin.php?erro=criar'
        );
    }
}



/* =========================================================
   EDITAR SIMULADO
   ========================================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/simuladosadmin.php');
    }

    $id = (int) ($_POST['id'] ?? 0);

    $titulo = trim($_POST['titulo'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');

    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);

    $ativo = isset($_POST['ativo']) ? 1 : 0;


    if ($id <= 0 || $titulo === '') {

        redirecionar(
            'admin/simuladosadmin.php?erro=preencha'
        );
    }


    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }


    try {

        $simuladoModel = new Simulado();

        $simuladoModel->editar(
            $id,
            $titulo,
            $descricao,
            $tempo_minutos,
            $ativo
        );


        redirecionar(
            'admin/simuladosadmin.php?sucesso=editado&id=' . $id
        );

    } catch (PDOException $e) {

        error_log(
            'Erro ao editar simulado: ' . $e->getMessage()
        );

        redirecionar(
            'admin/simuladosadmin.php?erro=editar&id=' . $id
        );
    }
}



/* =========================================================
   EXCLUIR SIMULADO
   ========================================================= */

if ($acao === 'excluir') {

    $id = (int) ($_GET['id'] ?? 0);


    if ($id <= 0) {

        redirecionar(
            'admin/simuladosadmin.php?erro=excluir'
        );
    }


    try {

        $simuladoModel = new Simulado();

        $simuladoModel->excluir($id);


        redirecionar(
            'admin/simuladosadmin.php?sucesso=excluido'
        );

    } catch (PDOException $e) {

        error_log(
            'Erro ao excluir simulado: ' . $e->getMessage()
        );

        redirecionar(
            'admin/simuladosadmin.php?erro=excluir'
        );
    }
}



/* =========================================================
   ADICIONAR VÁRIAS QUESTÕES AO MESMO TEMPO
   ========================================================= */

if ($acao === 'adicionar_questoes') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        redirecionar(
            'admin/simuladosadmin.php'
        );
    }


    $simulado_id = (int) ($_POST['simulado_id'] ?? 0);

    $questoes = $_POST['questoes'] ?? [];


    if ($simulado_id <= 0) {

        redirecionar(
            'admin/simuladosadmin.php?erro=preencha'
        );
    }


    if (!is_array($questoes) || count($questoes) === 0) {

        redirecionar(
            'admin/simuladosadmin.php?id=' .
            $simulado_id .
            '&erro=nenhuma_questao'
        );
    }


    try {

        $simuladoModel = new Simulado();


        foreach ($questoes as $questao_id) {

            $questao_id = (int) $questao_id;


            if ($questao_id <= 0) {
                continue;
            }


            /*
             * Verifica se a questão já está
             * cadastrada no simulado.
             */

            if (
                $simuladoModel->questaoJaAdicionada(
                    $simulado_id,
                    $questao_id
                )
            ) {
                continue;
            }


            /*
             * Descobre a próxima posição
             * da questão no simulado.
             */

            $ordem = $simuladoModel->proximaOrdem(
                $simulado_id
            );


            /*
             * Adiciona a questão.
             */

            $simuladoModel->adicionarQuestao(
                $simulado_id,
                $questao_id,
                $ordem
            );
        }


        redirecionar(
            'admin/simuladosadmin.php?id=' .
            $simulado_id .
            '&sucesso=questoes_adicionadas'
        );


    } catch (PDOException $e) {

        error_log(
            'Erro ao adicionar questões ao simulado: ' .
            $e->getMessage()
        );


        redirecionar(
            'admin/simuladosadmin.php?id=' .
            $simulado_id .
            '&erro=adicionar'
        );
    }
}



/* =========================================================
   REMOVER QUESTÃO
   ========================================================= */

if ($acao === 'remover_questao') {

    $simulado_id = (int) (
        $_GET['simulado_id'] ?? 0
    );

    $questao_id = (int) (
        $_GET['questao_id'] ?? 0
    );


    if (
        $simulado_id <= 0 ||
        $questao_id <= 0
    ) {

        redirecionar(
            'admin/simuladosadmin.php?erro=remover'
        );
    }


    try {

        $simuladoModel = new Simulado();


        $simuladoModel->removerQuestao(
            $simulado_id,
            $questao_id
        );


        redirecionar(
            'admin/simuladosadmin.php?id=' .
            $simulado_id .
            '&sucesso=removida'
        );


    } catch (PDOException $e) {

        error_log(
            'Erro ao remover questão: ' .
            $e->getMessage()
        );


        redirecionar(
            'admin/simuladosadmin.php?id=' .
            $simulado_id .
            '&erro=remover'
        );
    }
}



/* =========================================================
   REDIRECIONAMENTO FINAL
   ========================================================= */

redirecionar(
    'admin/simuladosadmin.php'
);


/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Suporte na verificação de $_SESSION em rotas protegidas (ex: painel administrativo). 
Validação: Lógica de bloqueio e liberação de páginas testada com usuários autenticados e deslogados, com validação pelas alunas. 
*/
