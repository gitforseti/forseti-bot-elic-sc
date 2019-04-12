<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:03
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Carga\Bll\Repository\Licitacao;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forseti\Bot\Bll\PageObject\SearchLicitacaoPageObject;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;

class SearchLicitacaoCommand extends Command
{

    use ForsetiLoggerTrait;

    private $dateIni = '';
    private $dateFim = '';
    private $licitacaoRepository;


    protected function configure()
    {
        $this->setName('licitacao:captura')
            ->setDefinition([
                new InputArgument('dateIni', InputArgument::OPTIONAL, 'Data inicial'),
                new InputArgument('dateFim', InputArgument::OPTIONAL, 'Data final'),
            ])
            ->setDescription('captura id da licitação no portal para as próximas etapas do processamento.')
            ->setHelp('formato das datas: Y-m-d - Se nenhuma data for informada, serão capturadas as licitações do dia');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->dateIni = $input->getArgument('dateIni');
        $this->dateFim = $input->getArgument('dateFim');
        $this->licitacaoRepository = new Licitacao();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info("Iniciando");

        $po = new SearchLicitacaoPageObject();

        //sem parametro de data, ira pegar as do dia
        $idsPortal = $po->getLicitacaoByDate($this->dateIni, $this->dateFim)->getListLicitacaoIterator();

        $count = 0;
        foreach ($idsPortal as $idPortal) {

            $this->licitacaoRepository->idPortalSave($idPortal);

            $count += 1;
        }

        $output->writeln("Busca finalizada\n Total de licitações encontradas: ". $count);

        $this->info($count . " Licitações foram encontradas");
        $this->info("Finalizando");
    }
}