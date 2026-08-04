<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION (App overlay)
 * -------------------------------------------------------------------
 * This file only adds to the framework defaults already defined in
 * vendor/codeigniter4/framework. It must NOT be used to replace the
 * framework's own Autoload.php; merge these additions into your
 * project's existing app/Config/Autoload.php.
 */
class Autoload extends AutoloadConfig
{
    public $psr4 = [
        'App' => APPPATH,
    ];

    public $classmap = [];

    public $helpers = ['url', 'form', 'text', 'loan'];
}
