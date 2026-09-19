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