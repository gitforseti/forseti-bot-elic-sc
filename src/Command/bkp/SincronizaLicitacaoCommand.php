<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:03
 */

namespace Forseti\Carga\ElicSC\Command;

use Forseti\Carga\Bll\Repository\Licitacao;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forseti\Elicitacao\Sync\Carga\SyncService;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;

class SincronizaLicitacaoCommand extends Command
{
    use ForsetiLoggerTrait;

    const FONTE_CAPTURA_LICITACAO = 'CAPTURA_LICITACAO';
    const FONTE_ANEXO = 'ANEXOS';
    const PROCESS_NAME_LICITACAO = 'CapturaLicitacao';
    const PROCESS_NAME_ANEXO = 'DownloadAnexo';
    const PROCESS_NOVAS_OPORTUNIDADES = 'DescobrirNovasOportunidades';
    const SYNC_PORTAL = 'Bll';

    private $sync;
    private $licitacoes;
    private $licitacaoRepository;

    public function __construct(SyncService $sync)
    {
        parent::__construct();
        $this->sync = $sync;
    }

    protected function configure()
    {
        $this->setName('licitacao:sincroniza')
            ->setDescription('Envia para o MongoDB as oportunidades processadas');
    }


    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->licitacaoRepository = new Licitacao();
        $this->licitacoes = Licitacao::toSync();

        if ($this->licitacoes->isEmpty()) {

            $output->writeln('<error>Nao existe licitacao para ser enviada ao MongoDB</error>');
            exit;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info("Iniciando");

        $this->sync->generatePackage();

        foreach ($this->licitacoes as $licitacao) {

            $this->sync->setFonte(self::FONTE_CAPTURA_LICITACAO);
            $this->situacaoToQueue($licitacao);
            $this->OrgaoToQueue($licitacao);
            $this->modalidadeToQueue($licitacao);
            $this->licitacaoToQueue($licitacao);
            $this->loteItemToQueue($licitacao);
        }

        //send pacote licitação
        $this->sync->send(self::SYNC_PORTAL, self::PROCESS_NAME_LICITACAO);

        $this->sync->generatePackage();

        foreach ($this->licitacoes as $licitacao) {

            $this->sync->setFonte(self::FONTE_ANEXO);
            $this->anexoToQueue($licitacao);
            $this->licitacaoRepository->addFlg($licitacao->id_portal, 'flg_sincronizada');
        }
        //send pacote Anexos
        $this->sync->send(self::SYNC_PORTAL, self::PROCESS_NAME_ANEXO);
        //send descobrir novas oportunidades
        $this->sync->send(self::SYNC_PORTAL, self::PROCESS_NOVAS_OPORTUNIDADES);

        $this->info("Finalizando");
    }

    private function situacaoToQueue($licitacao)
    {
        $situacao = $licitacao->situacao;

        $situacaoArray = collect($situacao->toArray())->except(['created_at', 'updated_at', 'id_situacao'])
            ->toArray();

        $this->sync->toQueue('situacao', $situacaoArray);
    }

    private function orgaoToQueue($licitacao)
    {
        $orgao = $licitacao->orgao;

        $orgaoArray = collect($orgao->toArray())->except(['created_at', 'updated_at'])
            ->toArray();

        $this->sync->toQueue('orgao', $orgaoArray);

    }

    private function modalidadeToQueue($licitacao)
    {
        $licitacao->modalidade->each(function ($modalidade) {
            $modalidadeArray = collect($modalidade->toArray())->except(['created_at', 'updated_at' ])
                ->put('id_modalidade', $modalidade->id_modalidade)
                ->put('nm_completo', $modalidade->nm_completo)
                ->toArray();

            $this->sync->toQueue('modalidade', $modalidadeArray);
        });
    }

    private function licitacaoToQueue($licitacao)
    {
        $licitacaoArray = collect($licitacao->toArray())
            ->except(['created_at', 'updated_at',
                'id_portal','flg_detalhes', 'flg_lote', 'flg_edital',
                'flg_processada', 'flg_sincronizada', 'situacao','orgao', 'modalidade'])
            ->put('nm_situacao', $licitacao->situacao->nm_situacao)
            ->put('nm_completo', $licitacao->modalidade->nm_completo)
            ->put('nm_orgao', $licitacao->orgao->nm_orgao)
            ->put('nm_cod_nativo_licitacao', $licitacao->id_portal)
            ->toArray();

        $this->sync->toQueue('licitacao', $licitacaoArray);
    }

    private function loteItemToQueue($licitacao)
    {
        $licitacao->item->each(function ($loteItem) use ($licitacao) {
            $loteArray = collect($loteItem->toArray())->except(['created_at', 'updated_at'])
                ->put('id_lote', $loteItem->id_lote)
                ->put('nm_lote', $loteItem->lote->nm_lote)
                ->put('nu_licitacao', $licitacao->nm_edital)
                ->put('nm_cod_nativo_licitacao', $licitacao->id_portal)
                ->toArray();

            $this->sync->toQueue('item', $loteArray);
        });
    }

    private function anexoToQueue($licitacao)
    {
        $licitacao->anexo->each(function ($anexo) use($licitacao) {
            $anexoArray = collect($anexo->toArray())
                ->except(['created_at', 'updated_at', 'id_tipo_anexo',
                           'id_licitacao', 'nm_arquivo_download'])
                ->put('nu_licitacao', $licitacao->nm_edital)
                ->put('nm_cod_nativo_licitacao', $licitacao->id_portal)
                ->toArray();

            $this->sync->toQueue('anexo', $anexoArray);
        });
    }
}