<?php

/* =========================================
   TECHMINDS EDUCATION
   MATERIA MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';

class Materia
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listar()
    {
        $sql = "SELECT id, nome, descricao, ativo FROM materias ORDER BY nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT id, nome, descricao, ativo FROM materias WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($nome, $descricao)
    {
        $sql = "INSERT INTO materias (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':nome' => $nome, ':descricao' => $descricao]);
    }

    public function editar($id, $nome, $descricao, $ativo)
    {
        $sql = "UPDATE materias SET nome = :nome, descricao = :descricao, ativo = :ativo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':ativo' => $ativo
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM materias WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}


/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Depuração de Código
Finalidade: Diagnóstico de erros de sintaxe e falhas de execução no PHP e JavaScript. 
Validação: Causas raiz identificadas com apoio da IA, correções aplicadas manualmente e sistema retestado para garantir a estabilidade. 
*/
