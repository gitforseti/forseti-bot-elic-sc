<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 08:40
 */

use DI\ContainerBuilder;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/eloquent.php';



set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');


$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/config/config.php');
$builder->addDefinitions(__DIR__ . '/app/factory-def.php');

$container = $builder->build();
// log crawler
putenv('FORSETI_LOGGER_STREAM=' . $container->get('log.path_crawler'));
// log downloads
putenv('PATH_ANEXO=' . $container->get('app.path_anexo'));
//sentry configs
putenv('FORSETI_SENTRY_DNS='. $container->get('sentry_key'));
putenv('FORSETI_SENTRY_LOGGER_LEVEL='.\Monolog\Logger::ERROR);