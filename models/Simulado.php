
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

    public function getPDO()
{
    return $this->pdo;
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
                s.pdf_path,
                COUNT(sq.id) AS total_questoes
            FROM simulados s
            LEFT JOIN simulado_questoes sq
                ON sq.simulado_id = s.id
            WHERE s.ativo = 1
            GROUP BY
                s.id, s.titulo, s.descricao,
                s.tempo_minutos, s.pdf_path
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
                s.pdf_path,
                s.data_criacao,
                (
                    SELECT COUNT(*)
                    FROM simulado_questoes sq
                    WHERE sq.simulado_id = s.id
                ) AS total_questoes
            FROM simulados s
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
                ativo,
                pdf_path
            FROM simulados
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================================
       LISTAR QUESTÕES DE UM SIMULADO
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
       ID GERADO AUTOMATICAMENTE
    ========================================= */

    public function criar(
    $titulo,
    $descricao,
    $tempo_minutos,
    $pdf_path,
    $ativo
) {
    $sql = "
        INSERT INTO simulados
        (
            titulo,
            descricao,
            pdf_path,
            tempo_minutos,
            ativo
        )
        VALUES
        (
            :titulo,
            :descricao,
            :pdf_path,
            :tempo_minutos,
            :ativo
        )
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':pdf_path' => $pdf_path,
        ':tempo_minutos' => $tempo_minutos,
        ':ativo' => $ativo
    ]);

    return (int) $this->pdo->lastInsertId();
}

    /* =========================================
       EDITAR SIMULADO
    ========================================= */

    public function editar(
        $id,
        $titulo,
        $descricao,
        $tempo_minutos,
        $ativo,
        $pdf_path
    ) {
        $sql = "
            UPDATE simulados
            SET
                titulo = :titulo,
                descricao = :descricao,
                tempo_minutos = :tempo_minutos,
                ativo = :ativo,
                pdf_path = :pdf_path
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':tempo_minutos' => $tempo_minutos,
            ':ativo' => $ativo,
            ':pdf_path' => $pdf_path
        ]);
    }

    /* =========================================
       ADICIONAR QUESTÃO AO SIMULADO
    ========================================= */

    public function adicionarQuestao(
        $simulado_id,
        $questao_id,
        $ordem
    ) {
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
       VERIFICAR QUESTÃO JÁ ADICIONADA
    ========================================= */

    public function questaoJaAdicionada(
        $simulado_id,
        $questao_id
    ) {
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
       PRÓXIMA ORDEM DISPONÍVEL
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
       REMOVER QUESTÃO DO SIMULADO
    ========================================= */

    public function removerQuestao(
        $simulado_id,
        $questao_id
    ) {
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
       LISTAR QUESTÕES PARA SIMULADOS
    ========================================= */

    public function listarParaSimulado()
    {
        $sql = "
            SELECT
                q.id,
                q.materia_id,
                q.conteudo_id,
                q.enunciado,
                m.nome AS materia,
                c.titulo AS conteudo
            FROM questoes q
            LEFT JOIN materias m
                ON q.materia_id = m.id
            LEFT JOIN conteudos c
                ON q.conteudo_id = c.id
            ORDER BY
                m.nome ASC,
                c.titulo ASC,
                q.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================================
       LISTAR IDS DAS QUESTÕES SELECIONADAS
    ========================================= */

    public function listarIdsQuestoes($simulado_id)
    {
        $sql = "
            SELECT questao_id
            FROM simulado_questoes
            WHERE simulado_id = :simulado_id
            ORDER BY ordem ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':simulado_id' => $simulado_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /* =========================================
       REMOVER TODAS AS QUESTÕES DO SIMULADO
    ========================================= */

    public function removerTodasQuestoes($simulado_id)
    {
        $sql = "
            DELETE FROM simulado_questoes
            WHERE simulado_id = :simulado_id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':simulado_id' => $simulado_id
        ]);
    }

    /* =========================================
       SALVAR GABARITO
       SUBSTITUI O GABARITO ANTERIOR
    ========================================= */

    public function salvarGabarito($simulado_id, $respostas)
    {
        if (!is_array($respostas)) {
            throw new InvalidArgumentException('Gabarito inválido.');
        }

        foreach ($respostas as $numero => $alternativa) {
            if (
                !is_numeric($numero) ||
                (int) $numero < 1 ||
                (int) $numero > 45 ||
                !in_array(strtoupper($alternativa), ['A', 'B', 'C', 'D', 'E'], true)
            ) {
                throw new InvalidArgumentException('Resposta inválida no gabarito.');
            }
        }

        $iniciouTransacao = !$this->pdo->inTransaction();

        if ($iniciouTransacao) {
            $this->pdo->beginTransaction();
        }

        try {
            $stmtDel = $this->pdo->prepare("
                DELETE FROM simulado_gabarito
                WHERE simulado_id = :simulado_id
            ");

            $stmtDel->execute([
                ':simulado_id' => $simulado_id
            ]);

            $stmtIns = $this->pdo->prepare("
                INSERT INTO simulado_gabarito
                (
                    simulado_id,
                    numero_questao,
                    resposta_correta
                )
                VALUES
                (
                    :simulado_id,
                    :numero_questao,
                    :resposta_correta
                )
            ");

            foreach ($respostas as $numero => $alternativa) {
                $stmtIns->execute([
                    ':simulado_id' => $simulado_id,
                    ':numero_questao' => (int) $numero,
                    ':resposta_correta' => strtoupper($alternativa)
                ]);
            }

            if ($iniciouTransacao) {
                $this->pdo->commit();
            }

            return true;

        } catch (Throwable $e) {

            if ($iniciouTransacao && $this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    /* =========================================
       BUSCAR GABARITO
    ========================================= */

    public function buscarGabarito($simulado_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT
                numero_questao,
                resposta_correta
            FROM simulado_gabarito
            WHERE simulado_id = :simulado_id
            ORDER BY numero_questao ASC
        ");

        $stmt->execute([
            ':simulado_id' => $simulado_id
        ]);

        $gabarito = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gabarito[(int) $row['numero_questao']] =
                $row['resposta_correta'];
        }

        return $gabarito;
    }

    /* =========================================
       REGISTRAR RESULTADO DO ALUNO
    ========================================= */

    public function registrarResultado(
        $usuario_id,
        $simulado_id,
        $total_questoes,
        $acertos
    ) {
        $sql = "
            INSERT INTO simulados_resultados
            (
                usuario_id,
                simulado_id,
                total_questoes,
                acertos,
                data_realizacao
            )
            VALUES
            (
                :usuario_id,
                :simulado_id,
                :total_questoes,
                :acertos,
                NOW()
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':simulado_id' => $simulado_id,
            ':total_questoes' => $total_questoes,
            ':acertos' => $acertos
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /* =========================================
       BUSCAR RESULTADO
    ========================================= */

    public function buscarResultado($id, $usuario_id)
    {
        $sql = "
            SELECT
                r.*,
                s.titulo AS simulado_titulo
            FROM simulados_resultados r
            INNER JOIN simulados s
                ON s.id = r.simulado_id
            WHERE r.id = :id
            AND r.usuario_id = :usuario_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================================
       EXCLUIR SIMULADO
    ========================================= */

    public function excluir($id)
    {
        $iniciouTransacao = !$this->pdo->inTransaction();

        if ($iniciouTransacao) {
            $this->pdo->beginTransaction();
        }

        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM simulado_gabarito
                WHERE simulado_id = :id
            ");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("
                DELETE FROM simulado_questoes
                WHERE simulado_id = :id
            ");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("
                DELETE FROM simulados_resultados
                WHERE simulado_id = :id
            ");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("
                DELETE FROM simulados
                WHERE id = :id
            ");
            $stmt->execute([':id' => $id]);

            if ($iniciouTransacao) {
                $this->pdo->commit();
            }

            return true;

        } catch (Throwable $e) {

            if ($iniciouTransacao && $this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }
}
