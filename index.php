<?php

use Bramus\Router\Router;

require 'vendor/autoload.php';

require 'autoload.php';

/**
 * ARCHIVOS DE CONFIGURACION
 */
require 'config/app.php';
require 'src/Http/lib/helpers.php';

$router = new Router;
require 'router/web.php';
$router->run();
 