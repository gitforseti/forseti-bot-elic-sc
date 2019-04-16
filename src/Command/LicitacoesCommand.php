<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 10/04/19
 * Time: 15:44
 */

namespace Forseti\Carga\ElicSC\Command;


use Forseti\Bot\ElicSC\Enums\Modalidade as ModalidadeEnum;
use Forseti\Bot\ElicSC\Enums\Situacao\PregaoEletronico;
use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Repository\LicitacoesRepository;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;

class LicitacoesCommand extends Command
{
    use ForsetiLoggerTrait;

    protected function configure()
    {
        $this->setName('licitacao:licitacoes')
            ->setDefinition([

            ])
            ->setDescription('Captura os orgaos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute()
    {
        $this->info("Iniciando");

        $detalhe = null;
        $dtEdital = null;

        $licitacoesPageObject = new LicitacoesPageObject();
        $licitacaoIterator = $licitacoesPageObject
            ->withCodigo(3143)
            ->withModalidade(ModalidadeEnum::PREGAO_ELETRONICO)
            ->getParser()
            ->getIterator();
        foreach ($licitacaoIterator as $licitacao) {
            $orgao = LicitacoesRepository::insertOrgao($licitacao);
            $modalidade = LicitacoesRepository::insertModalidade($licitacao);
            $situacao = LicitacoesRepository::insertSituacao($licitacao);
            LicitacoesRepository::insertLicitacao($licitacao, $orgao, $modalidade, $situacao);
            LicitacoesRepository::updateLicitacao($licitacao, $orgao, $modalidade, $situacao); //se ela já estiver criada recebe um update
        }
        $this->info("Finalizando");
    }

}
