<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 11:53
 */

require_once __DIR__ . '/../Bootstrap.php';

use Symfony\Component\Console\Application;

$app = new Application('Carga - Bolsa de Licitações do Brasil','1.0.0');

$app->add($container->get(\Forseti\Carga\Bll\Command\SearchLicitacaoCommand::class));
$app->add($container->get(\Forseti\Carga\Bll\Command\DetailLicitacaoCommand::class));
$app->add($container->get(\Forseti\Carga\Bll\Command\LoteItemLicitacaoCommand::class));
$app->add($container->get(\Forseti\Carga\Bll\Command\AnexoLicitacaoCommand::class));
$app->add($container->get(\Forseti\Carga\Bll\Command\ProcessaLicitacaoCommand::class));
$app->add($container->get(\Forseti\Carga\Bll\Command\SincronizaLicitacaoCommand::class));


$app->run();
