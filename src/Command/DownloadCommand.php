<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 15/04/19
 * Time: 15:49
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\PageObject\DownloadPageObject;
use Forseti\Carga\ElicSC\Model\Anexo;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:download')
            ->setDefinition([
                new InputArgument('nu_licitacao', InputArgument::OPTIONAL, 'Número da Licitação')
            ])
            ->setDescription('Captura os anexos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info("Iniciando");
        $output->writeln("Iniciando");

        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'downloads')) {
            mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'downloads');
        }

        $anexos = null;
        if($input->getArgument('nu_licitacao')){
            $anexos = Anexo::where('nu_licitacao',$input->getArgument('nu_licitacao'));
        }else{
            $anexos = Anexo::all();
        }
        $anexos->each(function ($anexo) {
            try {
                $diretorioLicitacao = __DIR__ . DIRECTORY_SEPARATOR . 'downloads' . DIRECTORY_SEPARATOR . $anexo->nu_licitacao;
                if (!is_dir($diretorioLicitacao)) {
                    mkdir($diretorioLicitacao);
                }
                $downloadPageObject = new DownloadPageObject();
                $downloadPageObject->download(
                    $diretorioLicitacao.DIRECTORY_SEPARATOR.$anexo->nm_arquivo,
                    $anexo->nm_path
                );
            } catch (\Exception $e) {
                $this->error('erro no DownloadCommand: ', ['exception' => $e->getMessage()]);

            }
        });

        $this->info("Finalizando");
        $output->writeln("Finalizando");
    }
}