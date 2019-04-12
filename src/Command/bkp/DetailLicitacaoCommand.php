<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:55
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Carga\Bll\Repository\Modalidade;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;
use Forseti\Carga\Bll\Repository\Licitacao;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forseti\Bot\Bll\PageObject\DetailLicitacaoPageObject;
use Forseti\Carga\Bll\Repository\Orgao;
use Forseti\Carga\Bll\Repository\Situacao;

class DetailLicitacaoCommand extends Command
{
    use ForsetiLoggerTrait;

    private $idPortal;
    private $licitacaoRepository;
    private $orgaoRepository;
    private $situacaoRepository;
    private $modalidadeRepository;

    protected function configure()
    {
        $this->setName('licitacao:detalhes')
            ->setDefinition([
                new InputArgument('idPortal', InputArgument::REQUIRED, 'id portal'),

            ])

            ->setDescription('captura os detalhes da licitacao.')
            ->setHelp('necessário informar id da licitacao no portal - id coletado no xml retornado da pesquisa de licitações - ex de id: 0d177db7-9810-4a4e-af6e-adc2d29318cd');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->idPortal = $input->getArgument('idPortal');
        $this->licitacaoRepository = new Licitacao();
        $this->orgaoRepository = new Orgao();
        $this->situacaoRepository = new Situacao();
        $this->modalidadeRepository = new Modalidade();
        $this->licitacaoRepository = new Licitacao();

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->info("Iniciando");

        $po = new DetailLicitacaoPageObject();

        $details = $po->getDetail($this->idPortal);

        $orgao = $this->orgaoRepository->add($details);
        $situacao = $this->situacaoRepository->add($details);
        $modalidade = $this->modalidadeRepository->add($details);

        $this->licitacaoRepository->firstLicitacao($this->idPortal);

        $this->licitacaoRepository->update(
            $this->idPortal,
            $details->getNProcessAdm(),
            $details->getEditalNumber(),
            $orgao->id_orgao,
            $modalidade->id_modalidade,
            $situacao->id_situacao,
            $details->getProductOrService(),
            $details->getImpeachmentEndTime(),
            $details->getObservation(),
            $details->getPublicationTimeStart(),
            $details->getPublicationTimeStart(),
            $details->getProposalReceivingStart(),
            $details->getProposalAnalysisStart(),
            $details->getDateDisputeStart()
        );

        $this->info("Finalizando");
    }

}