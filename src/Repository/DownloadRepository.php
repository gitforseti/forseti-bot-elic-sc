<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 22/04/19
 * Time: 13:05
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\ControleCarga;

class DownloadRepository
{

    public function controleCarga($nu_licitacao, $flag)
    {
        try{
            $controleCarga = ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
            $controleCarga->download = $flag;
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('Etc/GMT+3'));
            $controleCarga->dt_download = $date;
            $controleCarga->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do download: ', ['exception' => $e->getMessage()]);
        }
    }
}