<?php

require_once __DIR__ . '/../config/conexao.php';

class Progresso
{
    private $pdo;

    public function __construct($pdo)
    {
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
}
