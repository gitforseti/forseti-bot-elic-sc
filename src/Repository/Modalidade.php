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
use Forseti\Carga\Bll\Model\Modalidade as ModalidadeModel;

class Modalidade
{
    use ForsetiLoggerTrait;

    public  function add(DetailLicitacaoParser $details)
    {
        try {

            $modalidade = ModalidadeModel::firstOrCreate([

                'nm_completo' => $details->getModality(),
                'nm_abreviado' => $details->getModality()

            ]);

            return $modalidade;

        } catch (\Exception $e) {

            $this->error('Erro ao cadastrar a modalidade: ',['exception' => $e->getMessage()]);
        }
    }
}