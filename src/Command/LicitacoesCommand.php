<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 10/04/19
 * Time: 15:44
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Repository\ControleCargaRepository;
use Forseti\Carga\ElicSC\Repository\LicitacaoRepository;
use Forseti\Carga\ElicSC\Repository\ModalidadeRepository;
use Forseti\Carga\ElicSC\Repository\OrgaoRepository;
use Forseti\Carga\ElicSC\Repository\SituacaoRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LicitacoesCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:licitacoes')
            ->setDefinition([
                new InputArgument('nu_licitacao', InputArgument::OPTIONAL, 'Número da Licitação')
            ])
            ->setDescription('Captura a licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Iniciando");

        $licitacoesPageObject = new LicitacoesPageObject();
        if($input->getArgument('nu_licitacao')){
            $licitacoesPageObject->withCodigo($input->getArgument('nu_licitacao'));
        }
        $licitacaoIterator = $licitacoesPageObject
            ->getParser()
            ->getIterator();
        foreach ($licitacaoIterator as $licitacao) {
            try{
                $orgao = OrgaoRepository::insert($licitacao);
                $modalidade = ModalidadeRepository::insert($licitacao);
                $situacao = SituacaoRepository::insert($licitacao);
                LicitacaoRepository::insert($licitacao, $orgao, $modalidade, $situacao);
                LicitacaoRepository::update($licitacao, $orgao, $modalidade, $situacao); //se ela já estiver criada recebe um update
                ControleCargaRepository::updateLicitacao($licitacao->codigo, true);
            }catch (\Exception $e) {
                $this->error('erro no LicitacoesCommand: ', ['exception' => $e->getMessage()]);
            }
        }

        $output->writeln("Finalizando");
    }

}
