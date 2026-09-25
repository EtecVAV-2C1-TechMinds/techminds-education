<?php

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';

$title = "Gerenciar Simulados | " . NOME_SISTEMA;

$simuladoModel = new Simulado();

/* =========================================
   VERIFICAR SE ESTÁ EDITANDO UM SIMULADO
========================================= */

$idEditar = (int) ($_GET['editar'] ?? 0);

$simuladoEditar = null;

if ($idEditar > 0) {
    $simuladoEditar = $simuladoModel->buscarPorId($idEditar);
}

/* =========================================
   VERIFICAR SE ESTÁ GERENCIANDO QUESTÕES
========================================= */

$idSimulado = (int) ($_GET['id'] ?? 0);

$simuladoSelecionado = null;
$questoesSelecionadas = [];
$idsSelecionados = [];

if ($idSimulado > 0) {

    $simuladoSelecionado = $simuladoModel->buscarPorId($idSimulado);

    if ($simuladoSelecionado) {

        $questoesSelecionadas =
            $simuladoModel->listarQuestoes($idSimulado);

        $idsSelecionados =
            $simuladoModel->listarIdsQuestoes($idSimulado);
    }
}

/* =========================================
   LISTAR TODOS OS SIMULADOS
========================================= */
$simulados = $simuladoModel->listarTodos();
/* =========================================
   LISTAR TODAS AS QUESTÕES
========================================= */

$questoesTodas = $simuladoModel->listarParaSimulado();

$questoesDisponiveis = [];

foreach ($questoesTodas as $questao) {

    if (
        !in_array(
            $questao['id'],
            $idsSelecionados
        )
    ) {

        $questoesDisponiveis[] = $questao;

    }
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

?>

<style>

    .simulados-page {
        background-color: #f1f1f1;
        min-height: calc(100vh - 80px);
        padding: 50px 20px 70px;
    }

    .simulados-container {
        max-width: 1050px;
        margin: 0 auto;
    }

    /* =========================================
       HERO
    ========================================= */

    .simulados-hero {
        background-color: var(--green-main);
        color: white;
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 30px;
    }

    .simulados-hero h1 {
        margin: 0 0 8px;
        font-size: 27px;
        font-weight: 700;
    }

    .simulados-hero p {
        margin: 0;
        color: rgba(255,255,255,0.88);
    }

    /* =========================================
       CARDS
    ========================================= */

    .simulado-card {
        background-color: white;
        border-radius: 18px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 16px rgba(0,0,0,.07);
    }

    .simulado-card h2 {
        margin: 0 0 20px;
        color: var(--green-dark);
        font-size: 20px;
        font-weight: 700;
    }

    /* =========================================
       FORMULÁRIO
    ========================================= */

    .campo {
        margin-bottom: 18px;
    }

    .campo label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: #444;
    }

    .campo input,
    .campo textarea,
    .campo select {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d5d5d5;
        border-radius: 10px;
        padding: 12px 14px;
        font-family: inherit;
        font-size: 14px;
        background-color: white;
    }

    .campo textarea {
        min-height: 100px;
        resize: vertical;
    }

    .campo input:focus,
    .campo textarea:focus,
    .campo select:focus {
        outline: none;
        border-color: var(--green-main);
    }

    .linha-form {
        display: grid;
        grid-template-columns: 1fr 200px;
        gap: 20px;
    }

    /* =========================================
       BOTÕES
    ========================================= */

    .botoes {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .btn-verde {
        display: inline-block;
        background-color: var(--green-main);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-verde:hover {
        color: white;
        opacity: .9;
    }

    .btn-cinza {
        display: inline-block;
        background-color: #e8e8e8;
        color: #444;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-cinza:hover {
        color: #444;
        background-color: #ddd;
    }

    .btn-excluir {
        display: inline-block;
        background-color: #b3261e;
        color: white;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-excluir:hover {
        color: white;
        opacity: .9;
    }

    /* =========================================
       MENSAGENS
    ========================================= */

    .mensagem {
        border-radius: 10px;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .mensagem-sucesso {
        background-color: #dff4e8;
        color: #176b3a;
    }

    .mensagem-erro {
        background-color: #fbe1e1;
        color: #9c1c1c;
    }

    /* =========================================
       LISTA DE SIMULADOS
    ========================================= */

    .simulado-item {
        border: 1px solid #e1e1e1;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 12px;
        background-color: #fafafa;
    }

    .simulado-item:last-child {
        margin-bottom: 0;
    }

    .simulado-item-topo {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
    }

    .simulado-item h3 {
        margin: 0 0 6px;
        color: var(--green-dark);
        font-size: 17px;
    }

    .simulado-item p {
        margin: 0 0 10px;
        color: #777;
        font-size: 13px;
    }

    .info-simulado {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        font-size: 12px;
        color: #666;
    }

    .status-ativo {
        color: #16803c;
        font-weight: 700;
    }

    .status-inativo {
        color: #b3261e;
        font-weight: 700;
    }

    /* =========================================
       QUESTÕES
    ========================================= */

    .questoes-selecao {
        border: 1px solid #e1e1e1;
        border-radius: 14px;
        padding: 18px;
        background-color: #fafafa;
    }

    .questoes-selecao h3 {
        color: var(--green-dark);
        font-size: 16px;
        margin: 0 0 7px;
    }

    .questoes-selecao p {
        color: #777;
        font-size: 13px;
        margin: 0 0 15px;
    }

    .questao-select {
        width: 100%;
        min-height: 45px;
        border: 1px solid #d5d5d5;
        border-radius: 10px;
        padding: 10px;
        background-color: white;
        font-family: inherit;
    }

    .questao-selecionada {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 10px;
        background-color: white;
    }

    .questao-selecionada strong {
        display: block;
        color: var(--green-dark);
        font-size: 13px;
        margin-bottom: 5px;
    }

    .questao-selecionada span {
        color: #555;
        font-size: 13px;
    }

    .questao-selecionada a {
        float: right;
        color: #b3261e;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .sem-registros {
        text-align: center;
        color: #777;
        padding: 20px;
    }

    /* =========================================
       CHECKBOX
    ========================================= */

    .checkbox-ativo {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 15px 0;
        color: #444;
        font-size: 14px;
    }

    .checkbox-ativo input {
        width: auto;
    }

    @media (max-width: 700px) {

        .simulados-page {
            padding: 30px 15px 50px;
        }

        .simulados-hero {
            padding: 28px 22px;
        }

        .simulados-hero h1 {
            font-size: 23px;
        }

        .linha-form {
            grid-template-columns: 1fr;
        }

        .simulado-item-topo {
            flex-direction: column;
        }
    }
    /* =========================================================
   ÁREA DE ADICIONAR QUESTÕES
   ========================================================= */

.simulado-questoes-box {
    border: 1px solid #ddd;
    border-radius: 15px;
    padding: 20px;
    margin-top: 20px;
    background: #fff;
}


.simulado-questoes-box h2 {
    margin: 0 0 8px;
    font-size: 20px;
}


.simulado-ajuda {
    margin: 0 0 20px;
    color: #777;
    font-size: 14px;
}


/* =========================================================
   BOTÕES DE SELEÇÃO
   ========================================================= */

.acoes-questoes {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}


.btn-selecionar,
.btn-desmarcar {
    border: none;
    padding: 9px 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
}


.btn-selecionar {
    background: var(--green-main);
    color: white;
}


.btn-desmarcar {
    background: #eee;
    color: #333;
}


.btn-selecionar:hover,
.btn-desmarcar:hover {
    opacity: 0.85;
}


/* =========================================================
   LISTA DE QUESTÕES
   ========================================================= */

.lista-questoes {
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
}


.questoes-materia {
    background: var(--green-main);
    color: white;
    padding: 12px 15px;
    font-weight: bold;
    font-size: 16px;
}


.questoes-conteudo {
    background: #f5f5f5;
    padding: 10px 15px;
    font-weight: 600;
    color: #333;
    border-bottom: 1px solid #ddd;
}


/* =========================================================
   CADA QUESTÃO
   ========================================================= */

.questao-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background 0.2s;
}


.questao-checkbox:last-child {
    border-bottom: none;
}


.questao-checkbox:hover {
    background: #f8f8f8;
}


.questao-checkbox input {
    width: 18px;
    height: 18px;
    cursor: pointer;
    flex-shrink: 0;
}


.questao-id {
    font-weight: bold;
    color: var(--green-main);
    min-width: 55px;
}


.questao-enunciado {
    color: #555;
    font-size: 14px;
}


/* =========================================================
   BOTÃO ADICIONAR
   ========================================================= */

.btn-adicionar-questoes {
    margin-top: 20px;
    border: none;
    background: var(--green-main);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
}


.btn-adicionar-questoes:hover {
    opacity: 0.9;
}


/* =========================================================
   NENHUMA QUESTÃO
   ========================================================= */

.nenhuma-questao {
    padding: 20px;
    text-align: center;
    color: #777;
}

    

</style>

<main class="simulados-page">

    <div class="simulados-container">

        <!-- =====================================
             CABEÇALHO
        ====================================== -->

        <div class="simulados-hero">

            <h1>Gerenciar Simulados</h1>

            <p>
                Crie simulados, edite suas informações e selecione as questões.
            </p>

        </div>


        <!-- =====================================
             MENSAGENS
        ====================================== -->

        <?php if (isset($_GET['sucesso'])): ?>

            <div class="mensagem mensagem-sucesso">

                <?php if ($_GET['sucesso'] === 'criado'): ?>

                    Simulado criado com sucesso!

                <?php elseif ($_GET['sucesso'] === 'editado'): ?>

                    Simulado atualizado com sucesso!

                <?php elseif ($_GET['sucesso'] === 'excluido'): ?>

                    Simulado excluído com sucesso!

                <?php elseif ($_GET['sucesso'] === 'questoes_adicionadas'): ?>

    Questões adicionadas ao simulado com sucesso!

<?php elseif ($_GET['sucesso'] === 'removida'): ?>

    Questão removida do simulado!

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <?php if (isset($_GET['erro'])): ?>

            <div class="mensagem mensagem-erro">

                Ocorreu um erro. Verifique os dados e tente novamente.

            </div>

        <?php endif; ?>


        <!-- =====================================
             CRIAR / EDITAR SIMULADO
        ====================================== -->

        <div class="simulado-card">

            <h2>
                <?= $simuladoEditar ? 'Editar simulado' : 'Cadastrar novo simulado' ?>
            </h2>

            <form
                method="POST"
                action="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=<?= $simuladoEditar ? 'editar' : 'criar' ?>"
            >

                <?php if ($simuladoEditar): ?>

                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $simuladoEditar['id'] ?>"
                    >

                <?php endif; ?>


                <div class="linha-form">

                    <div class="campo">

                        <label for="titulo">
                            Título
                        </label>

                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            required
                            value="<?= htmlspecialchars($simuladoEditar['titulo'] ?? '') ?>"
                            placeholder="Ex.: Simulado de Biologia Nível 1"
                        >

                    </div>


                    <div class="campo">

                        <label for="tempo_minutos">
                            Tempo (minutos)
                        </label>

                        <input
                            type="number"
                            id="tempo_minutos"
                            name="tempo_minutos"
                            min="1"
                            value="<?= htmlspecialchars($simuladoEditar['tempo_minutos'] ?? '') ?>"
                            placeholder="Ex.: 60"
                        >

                    </div>

                </div>


                <div class="campo">

                    <label for="descricao">
                        Descrição
                    </label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        placeholder="Digite uma descrição para o simulado..."
                    ><?= htmlspecialchars($simuladoEditar['descricao'] ?? '') ?></textarea>

                </div>


                <?php if ($simuladoEditar): ?>

                    <label class="checkbox-ativo">

                        <input
                            type="checkbox"
                            name="ativo"
                            value="1"
                            <?= !empty($simuladoEditar['ativo']) ? 'checked' : '' ?>
                        >

                        Simulado ativo para os alunos

                    </label>

                <?php endif; ?>


                <div class="botoes">

                    <button type="submit" class="btn-verde">

                        <?= $simuladoEditar ? 'Salvar alterações' : 'Criar simulado' ?>

                    </button>


                    <?php if ($simuladoEditar): ?>

                        <a
                            href="<?= URL_SISTEMA ?>/admin/simuladosadmin.php"
                            class="btn-cinza"
                        >
                            Cancelar
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </div>


        <!-- =====================================
             GERENCIAR QUESTÕES
        ====================================== -->

        <?php if ($simuladoSelecionado): ?>

            <div class="simulado-card">

                <h2>
                    Questões do simulado:
                    <?= htmlspecialchars($simuladoSelecionado['titulo']) ?>
                </h2>


                <div class="simulado-questoes-box">

    <h2>Adicionar questões</h2>

    <p class="simulado-ajuda">
        Selecione uma ou várias questões para adicionar ao simulado.
    </p>


    <form
        method="POST"
        action="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=adicionar_questoes"
        id="formAdicionarQuestoes"
    >

        <input
            type="hidden"
            name="simulado_id"
            value="<?= (int) $simuladoSelecionado['id'] ?>"
        >


        <!-- =====================================================
             BOTÕES DE SELEÇÃO
             ===================================================== -->

        <div class="acoes-questoes">

            <button
                type="button"
                class="btn-selecionar"
                onclick="selecionarTodasQuestoes()"
            >
                Selecionar todas
            </button>


            <button
                type="button"
                class="btn-desmarcar"
                onclick="desmarcarTodasQuestoes()"
            >
                Desmarcar todas
            </button>

        </div>



        <!-- =====================================================
             LISTA DE QUESTÕES
             ===================================================== -->

        <div class="lista-questoes">


            <?php

            $materiaAtual = '';
            $conteudoAtual = '';

            $temQuestoesDisponiveis = false;


            foreach ($questoesDisponiveis as $questao):


                $materia = $questao['materia']
                    ?? 'Sem matéria';


                $conteudo = $questao['conteudo']
                    ?? 'Sem conteúdo';


                /*
                 * Se mudou a matéria,
                 * cria um novo título.
                 */

                if ($materia !== $materiaAtual):

                    $materiaAtual = $materia;

                    $conteudoAtual = '';

            ?>

                    <div class="questoes-materia">

                        <?= htmlspecialchars($materia) ?>

                    </div>

            <?php

                endif;


                /*
                 * Se mudou o conteúdo,
                 * cria o título do conteúdo.
                 */

                if ($conteudo !== $conteudoAtual):

                    $conteudoAtual = $conteudo;

            ?>

                    <div class="questoes-conteudo">

                        <?= htmlspecialchars($conteudo) ?>

                    </div>

            <?php

                endif;


                $temQuestoesDisponiveis = true;


                /*
                 * Mostra somente o começo
                 * do enunciado.
                 */

                $enunciado = trim(
                    $questao['enunciado'] ?? ''
                );


                if (mb_strlen($enunciado) > 100) {

                    $enunciado =
                        mb_substr(
                            $enunciado,
                            0,
                            100
                        ) . '...';
                }


            ?>


                <label class="questao-checkbox">

                    <input
                        type="checkbox"
                        name="questoes[]"
                        value="<?= (int) $questao['id'] ?>"
                        class="checkbox-questao"
                    >


                    <span class="questao-id">

                        #<?= (int) $questao['id'] ?>

                    </span>


                    <span class="questao-enunciado">

                        <?= htmlspecialchars($enunciado) ?>

                    </span>

                </label>


            <?php endforeach; ?>


            <?php if (!$temQuestoesDisponiveis): ?>

                <div class="nenhuma-questao">

                    Todas as questões disponíveis
                    já foram adicionadas a este simulado.

                </div>

            <?php endif; ?>


        </div>



        <!-- =====================================================
             BOTÃO ADICIONAR
             ===================================================== -->

        <?php if ($temQuestoesDisponiveis): ?>

            <button
                type="submit"
                class="btn-adicionar-questoes"
            >

                Adicionar questões selecionadas

            </button>

        <?php endif; ?>


    </form>

</div>


                <br>


                <h3 style="color:var(--green-dark); font-size:16px;">

                    Questões adicionadas
                    (<?= count($questoesSelecionadas) ?>)

                </h3>


                <?php if (empty($questoesSelecionadas)): ?>

                    <div class="sem-registros">

                        Nenhuma questão foi adicionada a este simulado ainda.

                    </div>

                <?php else: ?>

                    <?php foreach ($questoesSelecionadas as $numero => $questao): ?>

                        <div class="questao-selecionada">

                            <a
                                href="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=remover_questao&simulado_id=<?= (int) $simuladoSelecionado['id'] ?>&questao_id=<?= (int) $questao['id'] ?>"
                                onclick="return confirm('Deseja remover esta questão do simulado?')"
                            >
                                Remover
                            </a>

                            <strong>
                                Questão <?= $numero + 1 ?>
                            </strong>

                            <span>
                                <?= htmlspecialchars($questao['enunciado']) ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================
             LISTA DE SIMULADOS
        ====================================== -->

        <div class="simulado-card">

            <h2>
                Simulados cadastrados
            </h2>


            <?php if (empty($simulados)): ?>

                <div class="sem-registros">

                    Nenhum simulado cadastrado ainda.

                </div>

            <?php else: ?>

                <?php foreach ($simulados as $simulado): ?>

                    <div class="simulado-item">

                        <div class="simulado-item-topo">

                            <div>

                                <h3>
                                    <?= htmlspecialchars($simulado['titulo']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($simulado['descricao'] ?? '') ?>
                                </p>

                                <div class="info-simulado">

                                    <span>
                                        <strong>
                                            Questões:
                                        </strong>

                                        <?= (int) $simulado['total_questoes'] ?>
                                    </span>


                                    <span>

                                        <strong>
                                            Tempo:
                                        </strong>

                                        <?= $simulado['tempo_minutos']
                                            ? (int) $simulado['tempo_minutos'] . ' min'
                                            : 'Sem limite'
                                        ?>

                                    </span>


                                    <span>

                                        <strong>
                                            Status:
                                        </strong>

                                        <?php if ($simulado['ativo']): ?>

                                            <span class="status-ativo">
                                                Ativo
                                            </span>

                                        <?php else: ?>

                                            <span class="status-inativo">
                                                Inativo
                                            </span>

                                        <?php endif; ?>

                                    </span>

                                </div>

                            </div>


                            <div class="botoes">

                                <a
                                    href="<?= URL_SISTEMA ?>/admin/simuladosadmin.php?id=<?= (int) $simulado['id'] ?>"
                                    class="btn-verde"
                                >
                                    Questões
                                </a>


                                <a
                                    href="<?= URL_SISTEMA ?>/admin/simuladosadmin.php?editar=<?= (int) $simulado['id'] ?>"
                                    class="btn-cinza"
                                >
                                    Editar
                                </a>


                                <a
                                    href="<?= URL_SISTEMA ?>/controllers/SimuladoController.php?acao=excluir&id=<?= (int) $simulado['id'] ?>"
                                    class="btn-excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir este simulado?')"
                                >
                                    Excluir
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script>

function selecionarTodasQuestoes() {

    const checkboxes =
        document.querySelectorAll('.checkbox-questao');


    checkboxes.forEach(function(checkbox) {

        checkbox.checked = true;

    });

}


function desmarcarTodasQuestoes() {

    const checkboxes =
        document.querySelectorAll('.checkbox-questao');


    checkboxes.forEach(function(checkbox) {

        checkbox.checked = false;

    });

}

</script>

<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento de Layout.
Finalidade: Sugestão de sintaxe e estruturas condicionais em JavaScript para manipular elementos da página.
Validação: Scripts auditados linha por linha, ajustados manualmente para evitar conflitos e validados nos eventos da página.
*/
?>
