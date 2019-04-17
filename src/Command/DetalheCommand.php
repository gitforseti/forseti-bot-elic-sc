<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 15/04/19
 * Time: 16:14
 */

namespace Forseti\Carga\ElicSC\Command;


use Forseti\Bot\ElicSC\Enums\Modalidade;
use Forseti\Bot\ElicSC\PageObject\DetalhePageObject;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Repository\DetalheRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DetalheCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:detalhe')
            ->setDefinition([
                new InputArgument('nu_licitacao', InputArgument::OPTIONAL, 'Número da Licitação')
            ])
            ->setDescription('Captura os orgaos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info("Iniciando");
        $output->writeln("Iniciando");

        $licitacoes = null;
        if($input->getArgument('nu_licitacao')){
            $licitacoes = Licitacao::where('nu_licitacao',$input->getArgument('nu_licitacao'));
        }else{
            $licitacoes = Licitacao::all();
        }

        $licitacoes->each(function($licitacao)
        {
            $detalhePageObject = new DetalhePageObject();
            $detalhe = $detalhePageObject->getParser(
                $licitacao->nu_licitacao,
                $licitacao->nCdModulo,
                $licitacao->nCdSituacao,
                $licitacao->tmpTipoMuralProcesso
            )->getObject();
            DetalheRepository::updateOrgao($licitacao->id_orgao, $detalhe);
            DetalheRepository::updateDetalhe($licitacao->nu_licitacao, $detalhe);
        });

        $this->info("Finalizando");
        $output->writeln("Finalizando");
    }

}