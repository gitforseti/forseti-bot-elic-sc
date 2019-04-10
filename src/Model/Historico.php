<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:33
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $table = 'tb_elic_sc_lic_historico';
    protected $primaryKey = 'id_historico';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }
}