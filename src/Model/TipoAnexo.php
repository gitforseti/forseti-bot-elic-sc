<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:35
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class TipoAnexo extends Model
{
    protected $table = 'tb_elic_sc_lic_tipo_anexo';
    protected $primaryKey = 'id_tipo_anexo';
    protected $guarded = [];

    public function tipoAnexo()
    {
        return $this->hasMany(Anexo::class, 'id_tipo_anexo');
    }
}