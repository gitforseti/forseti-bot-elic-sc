<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 10/04/19
 * Time: 15:44
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Repository\LicitacoesRepository;
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
                $orgao = LicitacoesRepository::insertOrgao($licitacao);
                $modalidade = LicitacoesRepository::insertModalidade($licitacao);
                $situacao = LicitacoesRepository::insertSituacao($licitacao);
                LicitacoesRepository::insertLicitacao($licitacao, $orgao, $modalidade, $situacao);
                LicitacoesRepository::updateLicitacao($licitacao, $orgao, $modalidade, $situacao); //se ela já estiver criada recebe um update
                LicitacoesRepository::controleCarga($licitacao->codigo, true);
            }catch (\Exception $e) {
                $this->error('erro no LicitacoesCommand: ', ['exception' => $e->getMessage()]);
            }
        }

        $output->writeln("Finalizando");
    }

}
