<?php

/* =========================================
   TECHMINDS EDUCATION
   USER MODEL
========================================= */

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../config/constantes.php';


class Usuario
{

    /* Database connection */

    private PDO $pdo;


    /* Constructor */

    public function __construct()
    {

        global $pdo;

        $this->pdo = $pdo;

    }


    /* =========================================
       CREATE USER
    ========================================= */

    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ): bool {

        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );


        $sql = "
            INSERT INTO usuarios
            (
                nome,
                email,
                senha,
                tipo,
                ativo
            )
            VALUES
            (
                :nome,
                :email,
                :senha,
                :tipo,
                :ativo
            )
        ";


        $stmt = $this->pdo->prepare($sql);


        return $stmt->execute([

            ':nome' => $nome,

            ':email' => $email,

            ':senha' => $senhaHash,

            ':tipo' => TIPO_ALUNO,

            ':ativo' => USUARIO_ATIVO

        ]);

    }


    /* =========================================
       FIND USER BY EMAIL
    ========================================== */

    public function buscarPorEmail(
        string $email
    ): ?array {

        $sql = "
            SELECT
                id,
                nome,
                email,
                senha,
                tipo,
                ativo,
                data_cadastro
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            ':email' => $email

        ]);


        $usuario = $stmt->fetch();


        if (!$usuario) {

            return null;

        }


        return $usuario;

    }


    /* =========================================
       CHECK IF EMAIL EXISTS
    ========================================== */

    public function emailExiste(
        string $email
    ): bool {

        $sql = "
            SELECT id
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            ':email' => $email

        ]);


        return $stmt->fetch() !== false;

    }

}
