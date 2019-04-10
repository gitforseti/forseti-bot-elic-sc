<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:55
 */

namespace Forseti\Carga\ElicSC\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forseti\Bot\Bll\DownloadManager\BllDownload;
use Forseti\Carga\Bll\Model\Anexo;
use Forseti\Carga\Bll\Repository\Licitacao;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;


class AnexoLicitacaoCommand extends Command
{
    use ForsetiLoggerTrait;

    private $idPortal;
    private $config;

    protected function configure()
    {
        $this->setName('licitacao:anexos')
            ->setDefinition([
                new InputArgument('idPortal', InputArgument::REQUIRED, 'id portal'),

            ])

            ->setDescription('captura os anexos da licitacao.')
            ->setHelp('necessário informar id da licitacao no portal - id coletado no xml retornado da pesquisa de licitações - ex de id: 0d177db7-9810-4a4e-af6e-adc2d29318cd');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->idPortal = $input->getArgument('idPortal');
        $this->config = require __DIR__ . "/../../config/config.php";
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->info("Iniciando");

        $download = new BllDownload();

        $filePath = $this->config['app.path_anexo'];

        $statusDownload = $download->downloadAnexo($this->idPortal, $filePath);

        $filesInfo = $download->getFileInfo($this->idPortal);

        $licitacao = Licitacao::firstLicitacao($this->idPortal);

        foreach ($filesInfo as $fileInfo) {

            try {

                Anexo::firstOrCreate([
                    'id_licitacao'           => $licitacao->id_licitacao,
                    'nm_anexo'               => $fileInfo['filename'],
                    'nm_arquivo_download'    => $fileInfo['serverFileName'],
                    'nm_caminho'             => $this->config['app.path_anexo'] .'/'.$licitacao->id_portal,
                    'nm_pasta'               => $licitacao->id_portal,
                    'dt_adicionado'          => $fileInfo['createdAt']
                ]);

            } catch (\Exception $e) {

                $this->error('erro ao inserir as informacoes do anexo', ['exception' => $e->getMessage()]);
            }
        }

        if(!isset($statusDownload['failed'])) {

            $licitacao = new Licitacao();

            $licitacao->addFlg($this->idPortal, 'flg_edital');
        }

        $this->info("Finalizando");
    }
}