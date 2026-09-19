<?php

/* =========================================
   TECHMINDS EDUCATION
   FUNCTIONS - UTILITÁRIOS GERAIS
========================================= */


/* =========================================
   FORMATAR DATA PARA O PADRÃO BRASILEIRO
   Recebe uma data no formato do banco (Y-m-d H:i:s)
   e devolve no formato dd/mm/aaaa.
========================================= */

function formatarData(?string $data): string
{
    if (empty($data)) {
        return '';
    }

    $timestamp = strtotime($data);

    if ($timestamp === false) {
        return '';
    }

    return date('d/m/Y', $timestamp);
}


/* =========================================
   CORTAR TEXTO LONGO (RESUMO)
   Útil em cards de conteúdo/aula que mostram
   só uma prévia da descrição.
========================================= */

function resumirTexto(?string $texto, int $limite = 120): string
{
    if (empty($texto)) {
        return '';
    }

    $texto = trim($texto);

    if (mb_strlen($texto) <= $limite) {
        return $texto;
    }

    return mb_substr($texto, 0, $limite) . '...';
}


/* =========================================
   CALCULAR PERCENTUAL DE ACERTOS
   Usado na tela de desempenho e no resultado
   de questões/simulados.
========================================= */

function calcularPercentual(int $acertos, int $total): float
{
    if ($total <= 0) {
        return 0;
    }

    return round(($acertos / $total) * 100, 1);
}


/* =========================================
   VERIFICAR SE UM LINK APONTA PARA UM PDF
   Usado na exibição de materiais de aula.
========================================= */

function ehArquivoPdf(?string $caminho): bool
{
    if (empty($caminho)) {
        return false;
    }

    return strtolower(pathinfo($caminho, PATHINFO_EXTENSION)) === 'pdf';
}