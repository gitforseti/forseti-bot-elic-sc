<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 26/04/19
 * Time: 12:18
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\Modalidade;

class ModalidadeRepository
{
    public function insert($licitacao)
    {
        try {
            return Modalidade::firstOrCreate([
                'nm_modalidade' => $licitacao->modalidade,
                'nm_abreviado' => null
            ]);
        }catch (\Exception $e) {
            $this->error('Erro ao inserir modalidade no banco: ', ['exception' => $e->getMessage()]);
        }
    }

}