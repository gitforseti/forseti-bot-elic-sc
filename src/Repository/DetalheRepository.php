<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 16/04/19
 * Time: 11:38
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Model\Orgao;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;

class DetalheRepository
{
    use ForsetiLoggerTrait;

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
    public function updateOrgao($id_orgao, $detalhe)
    {
        try {
            $orgao = Orgao::find($id_orgao);
            $orgao->nm_orgao = $detalhe->unidadeCompradora;
            $orgao->save();
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }

}