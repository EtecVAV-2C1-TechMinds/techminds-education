<?php

/* =========================================
   TECHMINDS EDUCATION
   SYSTEM CONSTANTS
========================================= */

/* =========================================
   USER TYPES
========================================= */
define('TIPO_ALUNO', 'aluno');
define('TIPO_ADMIN', 'admin');
define('TIPOS_VALIDOS', [TIPO_ALUNO, TIPO_ADMIN]);

/* =========================================
   USER STATUS
========================================= */
define('USUARIO_ATIVO', 1);
define('USUARIO_INATIVO', 0);

/* =========================================
   SESSION
========================================= */
define('SESSION_USUARIO', 'techminds_usuario');
define('SESSION_TIPO', 'techminds_tipo');
define('SESSION_TEMPO_VIDA', 3600); // 1 hora

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Integração Backend e Banco de Dados 
Finalidade: Suporte na construção do script de conexão entre o PHP e o banco de dados MySQL via phpMyAdmin.
Validação: Credenciais e rotas configuradas manualmente, conexão testada localmente no phpMyAdmin e validada em ambiente de desenvolvimento pelas alunas. 
*/
