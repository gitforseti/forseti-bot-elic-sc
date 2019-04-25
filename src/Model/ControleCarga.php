<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:33
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class ControleCarga extends Model
{
    protected $table = 'tb_elic_sc_lic_controle_carga';
    protected $primaryKey = 'nu_licitacao';
    protected $guarded = [];
    const UPDATED_AT = null;

    public function orgao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }
}