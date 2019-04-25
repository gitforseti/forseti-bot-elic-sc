<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 16/04/19
 * Time: 11:46
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\ElicSC\Model\Anexo;
use Forseti\Carga\ElicSC\Model\ControleCarga;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Model\TipoAnexo;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;

class AnexosRepository
{
    use ForsetiLoggerTrait;

    public function insertTipoAnexo($anexo)
    {
        try{
            return TipoAnexo::firstOrCreate([
                'nm_tipo_anexo' => $anexo->nCdAnexoTipo
            ]);
        }catch (\Exception $e) {
            $this->error('erro ao inserir tipoAnexo no banco: ', ['exception' => $e->getMessage()]);
        }
    }
    public function insertAnexo($nu_licitacao, $anexo, $tipoAnexo)
    {
        try{
            return Anexo::create([
                'nCdAnexo' => $anexo->codigo,
                'id_tipo_anexo' => $tipoAnexo['id_tipo_anexo'],
                'nu_licitacao' => $nu_licitacao,
                'nm_url' => $anexo->urlCompleta,
                'nm_descricao' => $anexo->descricao,
                'nm_arquivo' => $anexo->nmArquivoSugerido,
                'nm_arquivo_download' => $anexo->sNmArquivo,
                'nm_path' => null,
                'sDsParametroCriptografado' => $anexo->sDsParametroCriptografado,
                'dt_adicionado' => $anexo->data
            ]);

        }catch (\Exception $e) {
            $this->error('erro ao inserir anexo no banco: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateFlag($nu_licitacao, $flag)
    {
        try{
            $licitacao = Licitacao::find($nu_licitacao);
            $licitacao->flag_anexo = $flag;
            $licitacao->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar flag de anexo no banco: ', ['exception' => $e->getMessage()]);
        }
    }
    public function updateNmPath($id_anexo, $nm_path)
    {
        try{
            $anexo = Anexo::find($id_anexo);
            $anexo->nm_path = $nm_path;
            $anexo->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar flag de anexo no banco: ', ['exception' => $e->getMessage()]);
        }
    }


    public function controleCarga($nu_licitacao, $flag)
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