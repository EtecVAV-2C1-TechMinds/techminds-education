<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTATO MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';

class Contato
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function salvar($nome, $email, $assunto, $mensagem)
    {
        $sql = "
            INSERT INTO mensagens_contato (nome, email, assunto, mensagem)
            VALUES (:nome, :email, :assunto, :mensagem)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':assunto' => $assunto,
            ':mensagem' => $mensagem
        ]);
    }

    public function listar()
    {
        $sql = "SELECT * FROM mensagens_contato ORDER BY lida ASC, data_envio DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       CONTAR MENSAGENS NÃO LIDAS
    ========================================= */

    public function contarNaoLidas()
    {
        $sql = "SELECT COUNT(*) AS total FROM mensagens_contato WHERE lida = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }


    /* =========================================
       MARCAR MENSAGEM COMO LIDA
    ========================================= */

    public function marcarComoLida($id)
    {
        $sql = "UPDATE mensagens_contato SET lida = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


    /* =========================================
       EXCLUIR MENSAGEM
    ========================================= */

    public function excluir($id)
    {
        $sql = "DELETE FROM mensagens_contato WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}