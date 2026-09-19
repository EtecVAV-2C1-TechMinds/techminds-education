<?php

/* =========================================
   TECHMINDS EDUCATION
   SIMULADO MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';

class Simulado
{
    private $pdo;

    public function __construct()
    {
        global $pdo;

        $this->pdo = $pdo;
    }


    /* =========================================
       LISTAR SIMULADOS ATIVOS
    ========================================= */

    public function listarAtivos()
    {
        $sql = "
            SELECT
                s.id,
                s.titulo,
                s.descricao,
                s.tempo_minutos,
                COUNT(sq.id) AS total_questoes
            FROM simulados s
            LEFT JOIN simulado_questoes sq
                ON sq.simulado_id = s.id
            WHERE s.ativo = 1
            GROUP BY s.id, s.titulo, s.descricao, s.tempo_minutos
            ORDER BY s.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       LISTAR TODOS OS SIMULADOS (ADMIN)
    ========================================= */

    public function listarTodos()
    {
        $sql = "
            SELECT
                s.id,
                s.titulo,
                s.descricao,
                s.tempo_minutos,
                s.ativo,
                COUNT(sq.id) AS total_questoes
            FROM simulados s
            LEFT JOIN simulado_questoes sq
                ON sq.simulado_id = s.id
            GROUP BY s.id, s.titulo, s.descricao, s.tempo_minutos, s.ativo
            ORDER BY s.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       BUSCAR SIMULADO POR ID
    ========================================= */

    public function buscarPorId($id)
    {
        $sql = "
            SELECT
                id,
                titulo,
                descricao,
                tempo_minutos,
                ativo
            FROM simulados
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* =========================================
       LISTAR QUESTÕES DE UM SIMULADO (EM ORDEM)
    ========================================= */

    public function listarQuestoes($simulado_id)
    {
        $sql = "
            SELECT
                q.id,
                q.enunciado,
                q.alternativa_a,
                q.alternativa_b,
                q.alternativa_c,
                q.alternativa_d,
                q.alternativa_e,
                q.resposta_correta,
                sq.ordem
            FROM simulado_questoes sq
            INNER JOIN questoes q
                ON sq.questao_id = q.id
            WHERE sq.simulado_id = :simulado_id
            ORDER BY sq.ordem ASC, q.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':simulado_id' => $simulado_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       CRIAR SIMULADO
    ========================================= */

    public function criar($titulo, $descricao, $tempo_minutos)
    {
        $sql = "
            INSERT INTO simulados
            (
                titulo,
                descricao,
                tempo_minutos
            )
            VALUES
            (
                :titulo,
                :descricao,
                :tempo_minutos
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':tempo_minutos' => $tempo_minutos
        ]);

        return $this->pdo->lastInsertId();
    }


    /* =========================================
       EDITAR SIMULADO
    ========================================= */

    public function editar($id, $titulo, $descricao, $tempo_minutos, $ativo)
    {
        $sql = "
            UPDATE simulados
            SET
                titulo = :titulo,
                descricao = :descricao,
                tempo_minutos = :tempo_minutos,
                ativo = :ativo
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':tempo_minutos' => $tempo_minutos,
            ':ativo' => $ativo
        ]);
    }


    /* =========================================
       ADICIONAR QUESTÃO A UM SIMULADO
    ========================================= */

    public function adicionarQuestao($simulado_id, $questao_id, $ordem)
    {
        $sql = "
            INSERT INTO simulado_questoes
            (
                simulado_id,
                questao_id,
                ordem
            )
            VALUES
            (
                :simulado_id,
                :questao_id,
                :ordem
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':simulado_id' => $simulado_id,
            ':questao_id' => $questao_id,
            ':ordem' => $ordem
        ]);
    }


    /* =========================================
       VERIFICAR SE UMA QUESTÃO JÁ ESTÁ NO SIMULADO
    ========================================= */

    public function questaoJaAdicionada($simulado_id, $questao_id)
    {
        $sql = "
            SELECT id
            FROM simulado_questoes
            WHERE simulado_id = :simulado_id
            AND questao_id = :questao_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':simulado_id' => $simulado_id,
            ':questao_id' => $questao_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }


    /* =========================================
       PRÓXIMA ORDEM DISPONÍVEL NO SIMULADO
    ========================================= */

    public function proximaOrdem($simulado_id)
    {
        $sql = "
            SELECT COALESCE(MAX(ordem), 0) + 1 AS proxima
            FROM simulado_questoes
            WHERE simulado_id = :simulado_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':simulado_id' => $simulado_id
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($resultado['proxima'] ?? 1);
    }


    /* =========================================
       REMOVER QUESTÃO DE UM SIMULADO
    ========================================= */

    public function removerQuestao($simulado_id, $questao_id)
    {
        $sql = "
            DELETE FROM simulado_questoes
            WHERE simulado_id = :simulado_id
            AND questao_id = :questao_id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':simulado_id' => $simulado_id,
            ':questao_id' => $questao_id
        ]);
    }


    /* =========================================
       EXCLUIR SIMULADO
    ========================================= */

    public function excluir($id)
    {
        $sql = "
            DELETE FROM simulados
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}