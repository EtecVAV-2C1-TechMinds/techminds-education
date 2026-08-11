<?php

/* =========================================
   TECHMINDS EDUCATION
   CLASS MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';


class Aula
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
       LIST ALL CLASSES
    ========================================== */

    public function listar()
    {

        $sql = "
            SELECT
                a.id,
                a.conteudo_id,
                a.titulo,
                a.descricao,
                a.video,
                a.material,
                a.ordem,
                a.ativo,
                a.data_criacao,
                c.titulo AS conteudo

            FROM aulas a

            INNER JOIN conteudos c
                ON a.conteudo_id = c.id

            ORDER BY
                a.conteudo_id ASC,
                a.ordem ASC,
                a.id ASC
        ";


        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       FIND CLASS BY ID
    ========================================== */

    public function buscarPorId($id)
    {

        $sql = "
            SELECT
                a.id,
                a.conteudo_id,
                a.titulo,
                a.descricao,
                a.video,
                a.material,
                a.ordem,
                a.ativo,
                a.data_criacao,
                c.titulo AS conteudo

            FROM aulas a

            INNER JOIN conteudos c
                ON a.conteudo_id = c.id

            WHERE a.id = :id
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute([
            ':id' => $id
        ]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* =========================================
       LIST CLASSES BY CONTENT
    ========================================== */

    public function listarPorConteudo($conteudo_id)
    {

        $sql = "
            SELECT
                id,
                conteudo_id,
                titulo,
                descricao,
                video,
                material,
                ordem,
                ativo,
                data_criacao

            FROM aulas

            WHERE conteudo_id = :conteudo_id

            AND ativo = 1

            ORDER BY ordem ASC, id ASC
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute([
            ':conteudo_id' => $conteudo_id
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       CREATE CLASS
    ========================================== */

    public function criar(
        $conteudo_id,
        $titulo,
        $descricao,
        $video = null,
        $material = null,
        $ordem = 1
    )
    {

        $sql = "
            INSERT INTO aulas
            (
                conteudo_id,
                titulo,
                descricao,
                video,
                material,
                ordem
            )

            VALUES
            (
                :conteudo_id,
                :titulo,
                :descricao,
                :video,
                :material,
                :ordem
            )
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([

            ':conteudo_id' => $conteudo_id,

            ':titulo' => $titulo,

            ':descricao' => $descricao,

            ':video' => $video,

            ':material' => $material,

            ':ordem' => $ordem

        ]);
    }


    /* =========================================
       UPDATE CLASS
    ========================================== */

    public function atualizar(
        $id,
        $conteudo_id,
        $titulo,
        $descricao,
        $video = null,
        $material = null,
        $ordem = 1
    )
    {

        $sql = "
            UPDATE aulas

            SET
                conteudo_id = :conteudo_id,
                titulo = :titulo,
                descricao = :descricao,
                video = :video,
                material = :material,
                ordem = :ordem

            WHERE id = :id
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([

            ':id' => $id,

            ':conteudo_id' => $conteudo_id,

            ':titulo' => $titulo,

            ':descricao' => $descricao,

            ':video' => $video,

            ':material' => $material,

            ':ordem' => $ordem

        ]);
    }


    /* =========================================
       DELETE CLASS
    ========================================== */

    public function excluir($id)
    {

        $sql = "
            DELETE FROM aulas

            WHERE id = :id
        ";


        $stmt = $this->conn->prepare($sql);


        return $stmt->execute([
            ':id' => $id
        ]);
    }


    /* =========================================
       LIST CONTENTS
    ========================================== */

    public function listarConteudos()
    {

        $sql = "
            SELECT
                id,
                titulo

            FROM conteudos

            WHERE ativo = 1

            ORDER BY titulo ASC
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
