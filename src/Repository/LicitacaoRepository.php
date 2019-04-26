<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:25
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;

class LicitacaoRepository
{
    use ForsetiLoggerTrait;

    public function insert($licitacao, $orgao, $modalidade, $situacao)
    {
        try {
            return Licitacao::firstOrCreate([
                'nu_licitacao' => $licitacao->codigo,
                'nm_processo' => $licitacao->processo,
                'nu_processo' => null, // verificar o que é isso
                'nu_edital' => null,
                'nCdAnexo' => $licitacao->nCdAnexo,
                'nCdModulo' => $licitacao->nCdModulo,
                'nCdSituacao' => $licitacao->nCdSituacao,
                'tmpTipoMuralProcesso' => $licitacao->tmpTipoMuralProcesso,
                'id_orgao' => $orgao['id_orgao'],
                'id_modalidade' => $modalidade['id_modalidade'],
                'id_situacao' => $situacao['id_situacao'],
                'url_publica' => null, // verificar o que é isso
                'nm_objeto' => null,
                'dt_edital' => null,
                'dt_abertura_proposta' => null, // lembrar de alterar para abertura
                'dt_fim_proposta' => null,
                'dt_disputa' => null // verificar o que é isso
            ]);
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }
    public function update($licitacao, $orgao, $modalidade, $situacao)
    {
        try{
            $licitacaoRepository = Licitacao::find($licitacao->codigo);
            $licitacaoRepository->nm_processo = $licitacao->processo;
            $licitacaoRepository->nCdAnexo = $licitacao->nCdAnexo;
            $licitacaoRepository->nCdModulo = $licitacao->nCdModulo;
            $licitacaoRepository->nCdSituacao = $licitacao->nCdSituacao;
            $licitacaoRepository->tmpTipoMuralProcesso = $licitacao->tmpTipoMuralProcesso;
            $licitacaoRepository->id_orgao = $orgao['id_orgao'];
            $licitacaoRepository->id_modalidade = $modalidade['id_modalidade'];
            $licitacaoRepository->id_situacao = $situacao['id_situacao'];
            $licitacaoRepository->save();
            return $licitacaoRepository;
        }catch (\Exception $e) {
            $this->error('erro ao atualizar flag do item no banco: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateDetalhe($nu_licitacao, $detalhe)
    {
        try {
            $licitacao = Licitacao::find($nu_licitacao);
            $licitacao->nu_edital = $detalhe->edital;
            $licitacao->nm_objeto = $detalhe->objeto;
            $licitacao->dt_abertura_proposta = $detalhe->aberturaPropostas;
            $licitacao->dt_fim_proposta = $detalhe->terminoPropostas;
            $licitacao->save();
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }

}