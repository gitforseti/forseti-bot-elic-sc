<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 15/04/19
 * Time: 15:49
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\PageObject\AnexosPageObject;
use Forseti\Bot\ElicSC\PageObject\DownloadPageObject;
use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;

class DownloadCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:download')
            ->setDefinition([

            ])
            ->setDescription('Captura os anexos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute()
    {
        $this->info("Iniciando");

        $codigo = 3142;
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'downloads')) {
            mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'downloads');
        }
        $licitacoesPageObject = new LicitacoesPageObject();
        $licitacoesIterator = $licitacoesPageObject
            ->withCodigo($codigo)
            ->getParser()
            ->getIterator();
        foreach ($licitacoesIterator as $licitacao) {
            $anexosPageObject = new AnexosPageObject();
            $anexosIterator = $anexosPageObject->getParser($licitacao->nCdAnexo)->getIterator();
            foreach ($anexosIterator as $anexo) {
                $downloadPageObject = new DownloadPageObject();
                $diretorioLicitacao = __DIR__ . DIRECTORY_SEPARATOR . 'downloads' . DIRECTORY_SEPARATOR . $anexo->codigo;
                if (!is_dir($diretorioLicitacao)) {
                    mkdir($diretorioLicitacao);
                }
                $downloadPageObject->download($diretorioLicitacao, $anexo);
            }
        }
        $this->info("Finalizando");
    }
}