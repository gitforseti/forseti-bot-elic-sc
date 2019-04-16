<?php

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Bot\ElicSC\Enums\Modalidade;
use Forseti\Bot\ElicSC\Enums\Situacao\PregaoEletronico;
use Forseti\Bot\ElicSC\PageObject\AnexosPageObject;
use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Model\Anexo;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Repository\AnexosRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;

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

            ])
            ->setDescription('Captura os anexos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute()
    {
        $this->info("Iniciando");

        $licitacoes = Licitacao::all();
        $licitacoes->each(function ($licitacao) {

            try {
                $anexos = Anexo::where('nu_licitacao', $licitacao->nu_licitacao);
                $anexos->delete();
                AnexosRepository::updateFlag($licitacao->nu_licitacao, false);

                $anexosPageObject = new AnexosPageObject();
                $anexosIterator = $anexosPageObject->getParser($licitacao->nCdAnexo)->getIterator();
                foreach ($anexosIterator as $anexo) {

                    $tipoAnexo = AnexosRepository::insertTipoAnexo($anexo);
                    AnexosRepository::insertAnexo($licitacao->nu_licitacao, $anexo, $tipoAnexo);
                    AnexosRepository::updateFlag($licitacao->nu_licitacao, true);
                }
            }catch(\Exception $e){
                $this->error('erro no AnexosCommand: ', ['exception' => $e->getMessage()]);
            }
        });


        $this->info("Finalizando");
    }
}