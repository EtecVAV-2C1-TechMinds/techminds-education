<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTENT MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';


class Conteudo
{

    /* =========================================
       DATABASE CONNECTION
    ========================================== */

    private $conn;


    /* =========================================
       CONSTRUCTOR
    ========================================== */

    public function __construct()
    {
        global $pdo;

        $this->conn = $pdo;
    }


    /* =========================================
       LIST ALL CONTENTS
    ========================================== */

    public function listar()
    {

        $sql = "
            SELECT
                c.id,
                c.materia_id,
                c.titulo,
                c.descricao,
                c.ativo,
                c.data_criacao,
                m.nome AS materia

            FROM conteudos c

            INNER JOIN materias m
                ON c.materia_id = m.id

            ORDER BY
                c.materia_id ASC,
                c.id ASC
        ";


        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       FIND CONTENT BY ID
    ========================================== */

    public function buscarPorId($id)
    {

        $sql = "
            SELECT
                c.id,
                c.materia_id,
                c.titulo,
                c.descricao,
                c.ativo,
                c.data_criacao,
                m.nome AS materia

            FROM conteudos c

            INNER JOIN materias m
                ON c.materia_id = m.id

            WHERE c.id = :id

            LIMIT 1
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute([
            ':id' => $id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* =========================================
       CREATE CONTENT
    ========================================== */

    public function criar(
        $materia_id,
        $titulo,
        $descricao
    )
    {

        $sql = "
            INSERT INTO conteudos
            (
                materia_id,
                titulo,
                descricao
            )

            VALUES
            (
                :materia_id,
                :titulo,
                :descricao
            )
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([

            ':materia_id' => $materia_id,

            ':titulo' => $titulo,

            ':descricao' => $descricao

        ]);
    }


    /* =========================================
       UPDATE CONTENT
    ========================================== */

    public function atualizar(
        $id,
        $materia_id,
        $titulo,
        $descricao
    )
    {

        $sql = "
            UPDATE conteudos

            SET
                materia_id = :materia_id,
                titulo = :titulo,
                descricao = :descricao

            WHERE id = :id
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([

            ':id' => $id,

            ':materia_id' => $materia_id,

            ':titulo' => $titulo,

            ':descricao' => $descricao

        ]);
    }


    /* =========================================
       DELETE CONTENT
    ========================================== */

    public function excluir($id)
    {

        $sql = "
            DELETE FROM conteudos

            WHERE id = :id
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([
            ':id' => $id
        ]);
    }


    /* =========================================
       LIST ACTIVE SUBJECTS
    ========================================== */

    public function listarMaterias()
    {

        $sql = "
            SELECT
                id,
                nome,
                descricao

            FROM materias

            WHERE ativo = 1

            ORDER BY nome ASC
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       LIST ACTIVE CONTENTS BY SUBJECT
    ========================================== */

    public function listarPorMateria($materia_id)
    {

        $sql = "
            SELECT
                c.id,
                c.materia_id,
                c.titulo,
                c.descricao,
                c.ativo,
                c.data_criacao

            FROM conteudos c

            WHERE c.materia_id = :materia_id

            AND c.ativo = 1

            ORDER BY
                c.titulo ASC,
                c.id ASC
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute([
            ':materia_id' => $materia_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
