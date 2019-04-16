<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 11:53
 */

require_once __DIR__ . '/../Bootstrap.php';

use Forseti\Carga\ElicSC\Command\AnexosCommand;
use Forseti\Carga\ElicSC\Command\DetalheCommand;
use Forseti\Carga\ElicSC\Command\DownloadCommand;
use Forseti\Carga\ElicSC\Command\ItensCommand;
use Forseti\Carga\ElicSC\Command\LicitacoesCommand;
use Symfony\Component\Console\Application;

$app = new Application('Carga - Elic-SC','1.0.0');

$app->add($container->get(AnexosCommand::class));
$app->add($container->get(DetalheCommand::class));
$app->add($container->get(DownloadCommand::class));
$app->add($container->get(ItensCommand::class));
$app->add($container->get(LicitacoesCommand::class));


$app->run();
