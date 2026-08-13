<?php

require_once __DIR__ . '/../config/conexao.php';

class Questao
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /* =========================================
       BUSCAR TODAS AS QUESTÕES COM NOME DA MATÉRIA
    ========================================= */
    public function listar()
    {
        $sql = "
            SELECT
                q.id,
                q.materia_id,
                q.conteudo_id,
                q.enunciado,
                q.alternativa_a,
                q.alternativa_b,
                q.alternativa_c,
                q.alternativa_d,
                q.alternativa_e,
                q.resposta_correta,
                m.nome AS materia
            FROM questoes q
            LEFT JOIN materias m ON q.materia_id = m.id
            ORDER BY q.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       BUSCAR QUESTÃO POR ID
    ========================================= */
    public function buscarPorId($id)
    {
        $sql = "
            SELECT
                q.id,
                q.materia_id,
                q.conteudo_id,
                q.enunciado,
                q.alternativa_a,
                q.alternativa_b,
                q.alternativa_c,
                q.alternativa_d,
                q.alternativa_e,
                q.resposta_correta,
                m.nome AS materia
            FROM questoes q
            LEFT JOIN materias m ON q.materia_id = m.id
            WHERE q.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* =========================================
       BUSCAR QUESTÕES POR ID
    ========================================= */
    public function listarPorId($id)
    {
        $sql = "
            SELECT
                q.id,
                q.materia_id,
                q.conteudo_id,
                q.enunciado,
                q.alternativa_a,
                q.alternativa_b,
                q.alternativa_c,
                q.alternativa_d,
                q.alternativa_e,
                q.resposta_correta,
                m.nome AS materia
            FROM questoes q
            LEFT JOIN materias m ON q.materia_id = m.id
            WHERE q.id = :id
            ORDER BY q.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       CADASTRAR NOVA QUESTÃO
    ========================================= */
    public function criar(
        $materia_id,
        $conteudo_id,
        $enunciado,
        $alternativa_a,
        $alternativa_b,
        $alternativa_c,
        $alternativa_d,
        $alternativa_e,
        $resposta_correta
    ) {

        $sql = "
            INSERT INTO questoes (
                materia_id,
                conteudo_id,
                enunciado,
                alternativa_a,
                alternativa_b,
                alternativa_c,
                alternativa_d,
                alternativa_e,
                resposta_correta
            )
            VALUES (
                :materia_id,
                :conteudo_id,
                :enunciado,
                :alternativa_a,
                :alternativa_b,
                :alternativa_c,
                :alternativa_d,
                :alternativa_e,
                :resposta_correta
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':materia_id' => $materia_id,
            ':conteudo_id' => $conteudo_id,
            ':enunciado' => $enunciado,
            ':alternativa_a' => $alternativa_a,
            ':alternativa_b' => $alternativa_b,
            ':alternativa_c' => $alternativa_c,
            ':alternativa_d' => $alternativa_d,
            ':alternativa_e' => $alternativa_e,
            ':resposta_correta' => $resposta_correta
        ]);

        return $this->pdo->lastInsertId();
    }


    /* =========================================
       EDITAR QUESTÃO
    ========================================= */
    public function editar(
        $id,
        $materia_id,
        $conteudo_id,
        $enunciado,
        $alternativa_a,
        $alternativa_b,
        $alternativa_c,
        $alternativa_d,
        $alternativa_e,
        $resposta_correta
    ) {

        $sql = "
            UPDATE questoes
            SET
                materia_id = :materia_id,
                conteudo_id = :conteudo_id,
                enunciado = :enunciado,
                alternativa_a = :alternativa_a,
                alternativa_b = :alternativa_b,
                alternativa_c = :alternativa_c,
                alternativa_d = :alternativa_d,
                alternativa_e = :alternativa_e,
                resposta_correta = :resposta_correta
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':materia_id' => $materia_id,
            ':conteudo_id' => $conteudo_id,
            ':enunciado' => $enunciado,
            ':alternativa_a' => $alternativa_a,
            ':alternativa_b' => $alternativa_b,
            ':alternativa_c' => $alternativa_c,
            ':alternativa_d' => $alternativa_d,
            ':alternativa_e' => $alternativa_e,
            ':resposta_correta' => $resposta_correta
        ]);
    }


    /* =========================================
       EXCLUIR QUESTÃO
    ========================================= */
    public function excluir($id)
    {
        $sql = "
            DELETE FROM questoes
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }


    /* =========================================
       BUSCAR QUESTÕES POR CONTEÚDO
    ========================================= */
    public function listarPorConteudo($conteudo_id)
    {
        $sql = "
            SELECT
                q.id,
                q.materia_id,
                q.conteudo_id,
                q.enunciado,
                q.alternativa_a,
                q.alternativa_b,
                q.alternativa_c,
                q.alternativa_d,
                q.alternativa_e,
                q.resposta_correta
            FROM questoes q
            WHERE q.conteudo_id = :conteudo_id
            ORDER BY q.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':conteudo_id' => $conteudo_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
