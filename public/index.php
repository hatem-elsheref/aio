<?php

use Hatem\Aio\Kernel;
session_start();

// require autoloader
require_once __DIR__ . '\..\vendor\autoload.php';

// require MicroFramework Files
require_once __DIR__ . '\..\src\Kernel.php';

// load routes and configurations and others from here
$kernel = new Kernel();
$kernel->register();

// start applications
app()->registerMiddlewares();
app()->start();


