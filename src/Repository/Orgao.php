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
use Forseti\Carga\Bll\Model\Orgao as OrgaoModel;

class Orgao
{
    use ForsetiLoggerTrait;

    public  function add(DetailLicitacaoParser $details)
    {

        try {

            $orgao = OrgaoModel::firstOrCreate([

                'nm_orgao' => $details->getOrganization(),
                'nm_cidade' => $details->getCity(),
                'nm_uf' => $details->getUf(),
                'nm_email' => $details->getOrgEmail()

            ]);

            return $orgao;

        } catch (\Exception $e) {

            $this->error('Erro ao cadastrar o orgão: ', ['exception' => $e->getMessage()]);
        }
    }

}