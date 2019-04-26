<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 26/04/19
 * Time: 11:46
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\ControleCarga;

class ControleCargaRepository
{
    public function getControleCarga($nu_licitacao)
    {
        try{
            return ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do item: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateLicitacao($nu_licitacao, $flag)
    {
        try{
            $controleCarga = ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
            $controleCarga->licitacao = $flag;
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('Etc/GMT+3'));
            $controleCarga->dt_licitacao = $date;
            $controleCarga->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga da licitacao: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateItem($nu_licitacao, $flag)
    {
        try{
            $controleCarga = ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
            $controleCarga->item = $flag;
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('Etc/GMT+3'));
            $controleCarga->dt_item = $date;
            $controleCarga->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do item: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateDetalhe($nu_licitacao, $flag)
    {
        try{
            $controleCarga = ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
            $controleCarga->detalhe = $flag;
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('Etc/GMT+3'));
            $controleCarga->dt_detalhe = $date;
            $controleCarga->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do detalhe: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateDownload($nu_licitacao, $flag)
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
            return $controleCarga;
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do download: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateAnexo($nu_licitacao, $flag)
    {
        try{
            $controleCarga = ControleCarga::firstOrCreate([
                'nu_licitacao' => $nu_licitacao
            ]);
            $controleCarga->anexo = $flag;
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('Etc/GMT+3'));
            $controleCarga->dt_anexo = $date;
            $controleCarga->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar controleCarga do anexo: ', ['exception' => $e->getMessage()]);
        }
    }
}