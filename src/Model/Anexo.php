<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:23
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $table = 'tb_elic_sc_lic_anexo';
    protected $primaryKey = 'id_anexo';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }
    public function tipoAnexo()
    {
        return $this->belongsTo(TipoAnexo::class, 'id_tipo_anexo');
    }
}