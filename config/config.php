<?php

/* =========================================
   TECHMINDS EDUCATION
   GENERAL CONFIGURATION
========================================= */

/* System name */
define('NOME_SISTEMA', 'TechMinds Education');

/* System URL */
define('URL_SISTEMA', '/techminds-education');

/* Development environment */
define('AMBIENTE', 'development');

/* Debug */
define('DEBUG', true);

/* Timezone */
date_default_timezone_set('America/Sao_Paulo');

/* Error display based on environment */
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

/* Load constants and DB connection in the right order */
require_once __DIR__ . '/constantes.php';
require_once __DIR__ . '/conexao.php';

/* Load helper and utility functions */
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/functions.php';