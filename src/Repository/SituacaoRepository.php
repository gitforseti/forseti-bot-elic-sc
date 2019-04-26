<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 26/04/19
 * Time: 12:18
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\Situacao;

class SituacaoRepository
{
    public function insert($licitacao)
    {
        try {
            return Situacao::firstOrCreate([
                'nm_situacao' => $licitacao->situacao
            ]);
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }

}