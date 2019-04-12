<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 12/02/19
 * Time: 09:23
 */

namespace Forseti\Carga\ElicSC\Command;


use Forseti\Carga\Bll\Repository\Licitacao;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

require_once __DIR__ . '/../../config/config.php';

class ProcessaLicitacaoCommand extends Command
{

    use ForsetiLoggerTrait;

    private $application;
    private $licitacoesPendentes;

    protected function configure()
    {
        $this->setName('licitacao:processa')
            ->setDefinition([new InputOption('cancela-download', 'c', InputOption::VALUE_NONE, 'Cancela os downloads de anexo, para fins de teste')])
            ->setDescription('Processa as licitacoes do portal Bll, juntando as informações coletadas nos commands');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->application = $this->getApplication();
        $this->licitacoesPendentes = Licitacao::licitacaoToProcess();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $downloadCancelado = $input->getOption('cancela-download');

        if (count($this->licitacoesPendentes) == 0) {

            $output->writeln('<error>Não há licitações pendentes de processamento</error>');
            exit;
        }

        foreach ($this->licitacoesPendentes as $licitacaoToProcess) {

            $output->writeln('<info>Iniciando novo Processamento da licitacao com id_licitacao: '.$licitacaoToProcess->id_licitacao.'</info>');

            try {

                $this->licitacaoDetail($licitacaoToProcess['id_portal']);

                $this->licitacaoBatch($licitacaoToProcess['id_portal']);

                if (!$downloadCancelado) {

                    $this->licitacaoAnexo($licitacaoToProcess['id_portal']);
                }

                $licitacao =  new Licitacao();

                $licitacao->addFlg($licitacaoToProcess['id_portal'],'flg_processada');

                $output->writeln('<info>Finalizando Processamento</info>');

            } catch (\Exception $e) {

                $this->error('erro ao processar a licitacao: ',['exception' => $e->getMessage()]);

                $output->writeln('<error>Erro ao processar licitação' . $licitacaoToProcess->id_licitacao.'</error>');
                $output->writeln('<error>Erro ao processar licitação' . $e->getMessage().'</error>');
            }
        }

        $output->writeln('<info>Fim do processamento das licitacoes</info>');
    }

    private function licitacaoDetail($idPortal)
    {
        $command = $this->application->find('licitacao:detalhes');
        $args = ['command' => 'licitacao:detalhe-licitacao', 'idPortal' => $idPortal];
        $inputArgs = new ArrayInput($args);
        $command->run($inputArgs, new NullOutput());
    }

    private function licitacaoBatch($idPortal)
    {
        $command = $this->application->find('licitacao:lotes');
        $args = ['command' => 'licitacao:lote-licitacao ', 'idPortal' => $idPortal];
        $inputArgs = new ArrayInput($args);
        $command->run($inputArgs, new NullOutput());
    }

    private function licitacaoAnexo($idPortal)
    {
        $command = $this->application->find('licitacao:anexos');
        $args = ['command' => 'licitacao:anexos-licitacao ', 'idPortal' => $idPortal];
        $inputArgs = new ArrayInput($args);
        $command->run($inputArgs, new NullOutput());
    }
}
