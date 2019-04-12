<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 10/04/19
 * Time: 15:44
 */

namespace Forseti\Carga\ElicSC\Command;


use Forseti\Carga\ElicSC\Model\Orgao;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;
use Symfony\Component\Console\Command\Command;

class ItensCommand extends Command
{
    use ForsetiLoggerTrait;
    private $orgao;

    protected function configure()
    {
        $this->setName('licitacao:itens')
            ->setDefinition([

            ])
            ->setDescription('Captura os orgaos da licitacao.')
            ->setHelp('help aqui');
    }

    protected function execute()
    {
        $this->info("Iniciando");

        $licitacoesPageObject = new LicitacoesPageObject();
        $licitacoesIterator = $licitacoesPageObject
            ->withCodigo(3131)
            ->getParser()
            ->getIterator();
        foreach ($licitacoesIterator as $licitacao) {
            $itensPageObject = new ItensPageObject();
            $itensIterator = $itensPageObject->getParser($licitacao->codigo, $licitacao->nCdModulo)->getIterator();
            foreach ($itensIterator as $item) {

                $this->assertEquals(1.0, $item->quantidade);
                $this->assertEquals('Peça', $item->unidadeMedida);
                $this->assertEquals(220281.66, $item->valorReferencia);
                $this->assertEquals('Ativo', $item->situacao);
            }
        }

        $this->info("Finalizando");
    }
}