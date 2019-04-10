<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:24
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'tb_lote';
    protected $primaryKey = 'id_lote';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }

    public function itemLote()
    {
        return $this->hasMany(ItemLicitacao::class, 'id_lote');
    }
}