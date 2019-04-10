<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:55
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\Bll\PageObject\LoteLicitacaoPageObject;
use Forseti\Carga\Bll\Repository\Licitacao;
use Forseti\Carga\Bll\Repository\Lote;
use Forseti\Carga\Bll\Repository\LoteItem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forseti\Bot\Bll\PageObject\LoteItemLicitacaoPageObject;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;

class LoteItemLicitacaoCommand extends Command
{
    use ForsetiLoggerTrait;

    private $idPortal;
    private $loteRepository;
    private $loteItemRepository;
    private $licitacaoRepository;

    protected function configure()
    {
        $this->setName('licitacao:lotes')
            ->setDefinition([
                new InputArgument('idPortal', InputArgument::REQUIRED, 'id portal'),

            ])

            ->setDescription('captura os lotes da licitacao.')
            ->setHelp('necessário informar id da licitacao no portal - id coletado no xml retornado da pesquisa de licitações - ex de id: 0d177db7-9810-4a4e-af6e-adc2d29318cd');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->idPortal = $input->getArgument('idPortal');
        $this->loteRepository = new Lote();
        $this->loteItemRepository = new LoteItem();
        $this->licitacaoRepository = new Licitacao();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info("Iniciando");

        $po = new LoteLicitacaoPageObject();

        $parser = $po->getLotes($this->idPortal);

        $lotes = $parser->getLotesIterator();

        $poItemLote = new LoteItemLicitacaoPageObject();

        foreach ($lotes as $lote) {

            $licitacao = Licitacao::firstLicitacao($this->idPortal);

            $loteModel = $this->loteRepository->addLote($licitacao, $lote->number);

            $itemsLote = $poItemLote->getLoteItens($lote->idBatch)->getLoteItemsIterator();

            foreach ($itemsLote as $itemLote) {

                $this->loteItemRepository->addLoteItem($loteModel, $itemLote->number,$itemLote->description, $itemLote->quantity);
            }
            
            $this->licitacaoRepository->addFlg($this->idPortal,'flg_lote');
        }

        $this->info("Finalizando");
    }
}