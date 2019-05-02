<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 16/04/19
 * Time: 11:46
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\ElicSC\Model\Anexo;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;

class AnexoRepository
{
    use ForsetiLoggerTrait;

    public function insert($nu_licitacao, $anexo)
    {
        try{
            return Anexo::create([
                'nCdAnexo' => $anexo->codigo,
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


}