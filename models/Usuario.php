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
    ========================================== */

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
                data_cadastro,
                foto
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
       FIND USER BY ID
    ========================================== */

    public function buscarPorId(
        int $id
    ): ?array {

        $sql = "
            SELECT
                id,
                nome,
                email,
                tipo,
                ativo,
                data_cadastro,
                foto
            FROM usuarios
            WHERE id = :id
            LIMIT 1
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            ':id' => $id

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


    /* =========================================
       UPDATE NAME AND EMAIL
    ========================================== */

    public function atualizarDados(
        int $id,
        string $nome,
        string $email
    ): bool {

        $sql = "
            UPDATE usuarios
            SET
                nome = :nome,
                email = :email
            WHERE id = :id
        ";


        $stmt = $this->pdo->prepare($sql);


        return $stmt->execute([

            ':nome' => $nome,

            ':email' => $email,

            ':id' => $id

        ]);
    }


    /* =========================================
       UPDATE PHOTO
    ========================================== */

    public function atualizarFoto(
        int $id,
        string $foto
    ): bool {

        $sql = "
            UPDATE usuarios
            SET foto = :foto
            WHERE id = :id
        ";


        $stmt = $this->pdo->prepare($sql);


        return $stmt->execute([

            ':foto' => $foto,

            ':id' => $id

        ]);
    }


    /* =========================================
       LISTAR TODOS OS ALUNOS (ADMIN)
    ========================================== */

    public function listarAlunos()
    {

        $sql = "
            SELECT
                id,
                nome,
                email,
                tipo,
                ativo,
                data_cadastro
            FROM usuarios
            WHERE tipo = :tipo
            ORDER BY nome ASC
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            ':tipo' => TIPO_ALUNO

        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* =========================================
       ATIVAR / DESATIVAR CONTA (ADMIN)
    ========================================== */

    public function atualizarStatus(
        int $id,
        int $ativo
    ): bool {

        $sql = "
            UPDATE usuarios
            SET ativo = :ativo
            WHERE id = :id
        ";


        $stmt = $this->pdo->prepare($sql);


        return $stmt->execute([

            ':ativo' => $ativo,

            ':id' => $id

        ]);
    }


    /* =========================================
       BUSCAR HASH DA SENHA ATUAL (P/ CONFERIR)
    ========================================== */

    public function buscarSenhaHash(int $id): ?string
    {
        $sql = "SELECT senha FROM usuarios WHERE id = :id LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch();

        return $resultado['senha'] ?? null;
    }


    /* =========================================
       ATUALIZAR SENHA
    ========================================== */

    public function atualizarSenha(int $id, string $novaSenha): bool
    {
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':senha' => $hash, ':id' => $id]);
    }

}