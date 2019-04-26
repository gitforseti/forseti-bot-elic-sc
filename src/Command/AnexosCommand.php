<?php

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\PageObject\AnexosPageObject;
use Forseti\Carga\ElicSC\Model\Anexo;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Repository\AnexoRepository;
use Forseti\Carga\ElicSC\Repository\ControleCargaRepository;
use Forseti\Carga\ElicSC\Repository\TipoAnexoRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 15/04/19
 * Time: 12:56
 */
class AnexosCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:anexos')
            ->setDefinition([
                new InputArgument('nu_licitacao', InputArgument::OPTIONAL, 'Número da Licitação')
            ])
            ->setDescription('Captura os anexos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Iniciando");

        $licitacoes = null;
        if($input->getArgument('nu_licitacao')){
            $licitacoes = Licitacao::where('nu_licitacao',$input->getArgument('nu_licitacao'));
        }else{
            $licitacoes = Licitacao::all();
        }
        $licitacoes->each(function ($licitacao) {
            try {
                $anexos = Anexo::where('nu_licitacao', $licitacao->nu_licitacao);
                $anexos->delete();
                ControleCargaRepository::updateAnexo($licitacao->nu_licitacao, false);

                $anexosPageObject = new AnexosPageObject();
                $anexosIterator = $anexosPageObject->getParser($licitacao->nCdAnexo)->getIterator();
                foreach ($anexosIterator as $anexo) {
                    $tipoAnexo = TipoAnexoRepository::insert($anexo);
                    AnexoRepository::insert($licitacao->nu_licitacao, $anexo, $tipoAnexo);
                }
                ControleCargaRepository::updateAnexo($licitacao->nu_licitacao, true);
            }catch(\Exception $e){
                $this->error('erro no AnexosCommand: ', ['exception' => $e->getMessage()]);
            }
        });

        $output->writeln("Finalizando");
    }
}