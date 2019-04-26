<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 26/04/19
 * Time: 12:30
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\TipoAnexo;

class TipoAnexoRepository
{

    public function insert($anexo)
    {
        try{
            return TipoAnexo::firstOrCreate([
                'nm_tipo_anexo' => $anexo->nCdAnexoTipo
            ]);
        }catch (\Exception $e) {
            $this->error('erro ao inserir tipoAnexo no banco: ', ['exception' => $e->getMessage()]);
        }
    }
}