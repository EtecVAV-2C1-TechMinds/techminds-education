<?php

/* =========================================
   TECHMINDS EDUCATION
   HELPERS - SESSÃO E AUTENTICAÇÃO
========================================= */


/* =========================================
   VERIFICAR SE O USUÁRIO ESTÁ LOGADO
========================================= */

function estaLogado(): bool
{
    return !empty($_SESSION[SESSION_USUARIO]);
}


/* =========================================
   VERIFICAR SE O USUÁRIO É ADMIN
========================================= */

function isAdmin(): bool
{
    if (!estaLogado()) {
        return false;
    }

    return ($_SESSION[SESSION_TIPO] ?? null) === TIPO_ADMIN;
}


/* =========================================
   PEGAR O ID DO USUÁRIO LOGADO
   Retorna 0 se ninguém estiver logado.
========================================= */

function usuarioLogadoId(): int
{
    return (int) ($_SESSION[SESSION_USUARIO] ?? 0);
}


/* =========================================
   PEGAR O NOME DO USUÁRIO LOGADO
========================================= */

function usuarioLogadoNome(): string
{
    return $_SESSION['usuario_nome'] ?? 'Visitante';
}


/* =========================================
   REDIRECIONAR PARA OUTRA PÁGINA DO SISTEMA
   Usa sempre caminho absoluto (URL_SISTEMA).
========================================= */

function redirecionar(string $caminho): void
{
    header('Location: ' . URL_SISTEMA . '/' . ltrim($caminho, '/'));
    exit;
}