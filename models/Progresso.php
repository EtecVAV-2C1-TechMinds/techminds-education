<?php

/* =========================================
   TECHMINDS EDUCATION
   PROGRESS MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';

class Progresso
{
    private $pdo;

    public function __construct()
    {
        global $pdo;

        $this->pdo = $pdo;
    }


    /* =========================================
       VERIFICAR SE A AULA FOI CONCLUÍDA
    ========================================= */

    public function aulaConcluida($usuario_id, $aula_id)
    {
        $sql = "
            SELECT id
            FROM aulas_concluidas
            WHERE usuario_id = :usuario_id
            AND aula_id = :aula_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':aula_id' => $aula_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }


    /* =========================================
       MARCAR AULA COMO CONCLUÍDA
    ========================================= */

    public function concluirAula($usuario_id, $aula_id)
    {
        $sql = "
            INSERT IGNORE INTO aulas_concluidas
            (
                usuario_id,
                aula_id
            )
            VALUES
            (
                :usuario_id,
                :aula_id
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':aula_id' => $aula_id
        ]);
    }


    /* =========================================
       DESMARCAR AULA COMO CONCLUÍDA
    ========================================= */

    public function desfazerConclusao($usuario_id, $aula_id)
    {
        $sql = "
            DELETE FROM aulas_concluidas
            WHERE usuario_id = :usuario_id
            AND aula_id = :aula_id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':aula_id' => $aula_id
        ]);
    }


    /* =========================================
       CONTAR AULAS CONCLUÍDAS POR CONTEÚDO
    ========================================= */

    public function contarConcluidasPorConteudo($usuario_id, $conteudo_id)
    {
        $sql = "
            SELECT COUNT(ac.id) AS total
            FROM aulas_concluidas ac
            INNER JOIN aulas a
                ON ac.aula_id = a.id
            WHERE ac.usuario_id = :usuario_id
            AND a.conteudo_id = :conteudo_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':conteudo_id' => $conteudo_id
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($resultado['total'] ?? 0);
    }


    /* =========================================
       TOTAL DE AULAS CONCLUÍDAS PELO ALUNO
    ========================================= */

    public function totalAulasConcluidas($usuario_id)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM aulas_concluidas
            WHERE usuario_id = :usuario_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($resultado['total'] ?? 0);
    }


    /* =========================================
       TOTAL DE AULAS ATIVAS DISPONÍVEIS NO SISTEMA
    ========================================= */

    public function totalAulasDisponiveis()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM aulas
            WHERE ativo = 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($resultado['total'] ?? 0);
    }


    /* =========================================
       SALVAR RESPOSTA DE UMA QUESTÃO
    ========================================= */

    public function salvarResposta($usuario_id, $questao_id, $alternativa_escolhida, $correta)
    {
        $sql = "
            INSERT INTO respostas_questoes
            (
                usuario_id,
                questao_id,
                alternativa_escolhida,
                correta
            )
            VALUES
            (
                :usuario_id,
                :questao_id,
                :alternativa_escolhida,
                :correta
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':questao_id' => $questao_id,
            ':alternativa_escolhida' => $alternativa_escolhida,
            ':correta' => $correta ? 1 : 0
        ]);
    }


    /* =========================================
       RESUMO GERAL DE DESEMPENHO DO ALUNO
    ========================================= */

    public function resumoGeral($usuario_id)
    {
        $sql = "
            SELECT
                COUNT(*) AS total_respondidas,
                SUM(correta) AS total_corretas
            FROM respostas_questoes
            WHERE usuario_id = :usuario_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total_respondidas' => (int) ($resultado['total_respondidas'] ?? 0),
            'total_corretas' => (int) ($resultado['total_corretas'] ?? 0)
        ];
    }


    /* =========================================
       DESEMPENHO POR MATÉRIA
    ========================================= */

    public function resumoPorMateria($usuario_id)
    {
        $sql = "
            SELECT
                m.id,
                m.nome,
                COUNT(rq.id) AS total_respondidas,
                SUM(rq.correta) AS total_corretas
            FROM respostas_questoes rq
            INNER JOIN questoes q
                ON rq.questao_id = q.id
            INNER JOIN materias m
                ON q.materia_id = m.id
            WHERE rq.usuario_id = :usuario_id
            GROUP BY m.id, m.nome
            ORDER BY m.nome ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       ÚLTIMAS QUESTÕES RESPONDIDAS (HISTÓRICO)
    ========================================= */

    public function ultimasRespostas($usuario_id, $limite = 5)
    {
        $limite = (int) $limite;

        $sql = "
            SELECT
                rq.correta,
                rq.data_resposta,
                q.enunciado,
                m.nome AS materia
            FROM respostas_questoes rq
            INNER JOIN questoes q
                ON rq.questao_id = q.id
            INNER JOIN materias m
                ON q.materia_id = m.id
            WHERE rq.usuario_id = :usuario_id
            ORDER BY rq.data_resposta DESC
            LIMIT {$limite}
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       SALVAR RESULTADO DE UM SIMULADO
    ========================================= */

    public function salvarResultadoSimulado($usuario_id, $simulado_id, $total_questoes, $acertos)
    {
        $sql = "
            INSERT INTO simulados_resultados
            (
                usuario_id,
                simulado_id,
                total_questoes,
                acertos
            )
            VALUES
            (
                :usuario_id,
                :simulado_id,
                :total_questoes,
                :acertos
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':simulado_id' => $simulado_id,
            ':total_questoes' => $total_questoes,
            ':acertos' => $acertos
        ]);
    }


    /* =========================================
       HISTÓRICO DE SIMULADOS DO ALUNO
    ========================================= */

    public function historicoSimulados($usuario_id, $limite = 5)
    {
        $limite = (int) $limite;

        $sql = "
            SELECT
                sr.total_questoes,
                sr.acertos,
                sr.data_realizacao,
                s.titulo
            FROM simulados_resultados sr
            INNER JOIN simulados s
                ON sr.simulado_id = s.id
            WHERE sr.usuario_id = :usuario_id
            ORDER BY sr.data_realizacao DESC
            LIMIT {$limite}
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}