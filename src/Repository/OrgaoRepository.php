<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 26/04/19
 * Time: 12:18
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\Orgao;

class OrgaoRepository
{

    public function insert($licitacao)
    {
        try {
            return Orgao::firstOrCreate([
                'nm_sigla_orgao' => $licitacao->unidadeCompradoraAbreviado,
                'nm_orgao' => null
            ]);
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateDetalhe($id_orgao, $detalhe)
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