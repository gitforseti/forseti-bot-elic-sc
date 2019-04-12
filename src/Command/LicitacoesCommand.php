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
use Forseti\Bot\ElicSC\PageObject\AnexosPageObject;
use Forseti\Bot\ElicSC\PageObject\DetalhePageObject;
use Forseti\Bot\ElicSC\PageObject\LicitacoesPageObject;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Model\Modalidade;
use Forseti\Carga\ElicSC\Model\Orgao;
use Forseti\Carga\ElicSC\Model\Situacao;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use function GuzzleHttp\Psr7\_caseless_remove;
use Symfony\Component\Console\Command\Command;

class LicitacoesCommand extends Command
{
    use ForsetiLoggerTrait;
    private $licitacao;

    protected function configure()
    {
        $this->setName('licitacao:licitacao')
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
            ->withCodigo(3142)
            ->withModalidade(ModalidadeEnum::PREGAO_ELETRONICO)
            ->getParser()
            ->getIterator();
        foreach ($licitacaoIterator as $licitacao) {
            $detalhePageObject = new DetalhePageObject();
            $detalhe = $detalhePageObject->getParser($licitacao->codigo, $licitacao->nCdModulo, $licitacao->nCdSituacao, $licitacao->tmpTipoMuralProcesso)->getObject();

            $anexosPageObject = new AnexosPageObject();
            $anexoIterator = $anexosPageObject->getParser($licitacao->nCdAnexo)->getIterator();

            foreach ($anexoIterator as $anexo) { // pega o primeiro anexo com nome de dital e grava data
                if (strpos($anexo->descricao, 'dital')) {
                    $dtEdital = $anexo->data;
                    break;
                }
            }
            Licitacao::insert($licitacao, $detalhe, $dtEdital);
        }
        $this->info("Finalizando");
    }

}
