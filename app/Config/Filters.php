<?php

namespace Config;

use App\Filters\AdminFilter;
use App\Filters\AuthFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'authFilter'    => AuthFilter::class,
        'adminFilter'   => AdminFilter::class,
    ];

    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            'secureheaders',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
