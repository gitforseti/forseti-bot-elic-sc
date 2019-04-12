<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 11:53
 */

require_once __DIR__ . '/../Bootstrap.php';

use Symfony\Component\Console\Application;

$app = new Application('Carga - Elic-SC','1.0.0');

$app->add($container->get(\Forseti\Carga\ElicSC\Command\ItensCommand::class));
$app->add($container->get(\Forseti\Carga\ElicSC\Command\LicitacoesCommand::class));


$app->run();
