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
use Forseti\Carga\ElicSC\Repository\AnexosRepository;
use Forseti\Carga\ElicSC\Repository\DownloadRepository;
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
            ->setDescription('Faz download dos anexos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Iniciando");


        $anexos = null;
        if($input->getArgument('nu_licitacao')){
            $anexos = Anexo::where('nu_licitacao',$input->getArgument('nu_licitacao'));
        }else{
            $anexos = Anexo::all();
        }
        $anexos->each(function ($anexo) {
            try {
                $config = require __DIR__ . "/../../config/config.php";
                $diretorioLicitacao = $config['app.path_anexo'].DIRECTORY_SEPARATOR. $anexo->nu_licitacao;
                if (!is_dir($diretorioLicitacao)) {
                    mkdir($diretorioLicitacao);
                }
                $pathCompleto = $diretorioLicitacao.DIRECTORY_SEPARATOR.$anexo->nm_arquivo;
                $downloadPageObject = new DownloadPageObject();
                $downloadPageObject->download(
                    $pathCompleto,
                    $anexo->nm_path
                );
                AnexosRepository::updateNmPath($anexo->id_anexo, $pathCompleto);
                DownloadRepository::controleCarga($anexo->nu_licitacao, true);
            } catch (\Exception $e) {
                $this->error('erro no DownloadCommand: ', ['exception' => $e->getMessage()]);

            }
        });

        $output->writeln("Finalizando");
    }
}