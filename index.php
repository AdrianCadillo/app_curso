<?php

use Bramus\Router\Router;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

require 'autoload.php';

Dotenv::createImmutable(__DIR__)->load();

/**
 * ARCHIVOS DE CONFIGURACION
 */
require 'src/Http/lib/helpers.php';
require 'config/app.php';
require 'config/database.php';

$router = new Router;
require 'router/web.php';
$router->run();
 