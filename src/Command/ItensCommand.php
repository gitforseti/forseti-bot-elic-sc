<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 10/04/19
 * Time: 15:44
 */

namespace Forseti\Carga\ElicSC\Command;


use Forseti\Bot\ElicSC\PageObject\ItensPageObject;
use Forseti\Carga\ElicSC\Model\Item;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Repository\ItensRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ItensCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:itens')
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

        $licitacoes->each(function ($licitacao) {
            $itensPageObject = new ItensPageObject();
            $itensIterator = $itensPageObject->getParser($licitacao->nu_licitacao, $licitacao->nCdModulo)->getIterator();
            try {
                $itens = Item::where('nu_licitacao', $licitacao->nu_licitacao);
                $itens->delete();
                ItensRepository::updateFlag($licitacao->nu_licitacao, false);
                foreach ($itensIterator as $item) {
                    ItensRepository::insert($licitacao->nu_licitacao, $item);
                }
                ItensRepository::updateFlag($licitacao->nu_licitacao, true);
            } catch (\Exception $e) {
                $this->error('erro no ItensCommand: ', ['exception' => $e->getMessage()]);

            }
        });
        $this->info("Finalizando");
        $output->writeln("Finalizando");
    }
}