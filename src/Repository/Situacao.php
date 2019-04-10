<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 19/02/19
 * Time: 11:39
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Bot\Bll\Parser\DetailLicitacaoParser;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;
use Forseti\Carga\Bll\Model\Situacao as SituacaoModel;

class Situacao
{
    use ForsetiLoggerTrait;

    public  function add(DetailLicitacaoParser $details)
    {

        try {

            $situacao = SituacaoModel::firstOrCreate([

                'nm_situacao' => $details->getStatus()

            ]);

            return $situacao;

        } catch (\Exception $e) {

            $this->error('Erro ao cadastrar a situação: ',['exception' => $e->getMessage()]);
        }
    }
}