<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 11:52
 */

use Interop\Container\ContainerInterface;

return array(
    // Logger para SyncMongo e SyncElicitacao
    Monolog\Logger::class => function(ContainerInterface $c) {
        $logger = new \Monolog\Logger($c->get('log.sync_name'));
        $lineFormatter = new \Monolog\Formatter\LineFormatter(null, 'Y-m-d H:i:s.u', false, true);
        $stream = new \Monolog\Handler\StreamHandler(
            $c->get('log.path_sync'),
            \Monolog\Logger::INFO
        );
        $stream->setFormatter($lineFormatter);
        $logger->pushHandler($stream);
        if ($c->get('log.console')) {
            $stream = new \Monolog\Handler\StreamHandler(
                'php://stdout',
                \Monolog\Logger::INFO
            );
            $logger->pushHandler($stream);
            $stream->setFormatter($lineFormatter);
        }
        return $logger;
    },

    \Forseti\Elicitacao\Sync\Carga\SyncService::class => function(ContainerInterface $c) {
        return \Forseti\Elicitacao\Sync\Carga\SyncServiceFactory::create($c->get('elicitacao.config'));
    }
);