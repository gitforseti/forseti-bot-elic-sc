<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 08:40
 */

$config = require_once __DIR__ . '/config/config.php';
$dbConfig = $config ['mysql.options'];
return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/migrations/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'default',
        'default' =>
            [
                'adapter'   => $dbConfig['driver'],
                'host'      => $dbConfig['host'],
                'name'      => $dbConfig['database'],
                'user'      => $dbConfig['username'],
                'pass'      => $dbConfig['password'],
                'port'      => $dbConfig['port'],
                'charset'   => $dbConfig['charset'],
            ]
    ]
];