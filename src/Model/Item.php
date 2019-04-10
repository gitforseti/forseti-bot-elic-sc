<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:34
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tb_elic_sc_lic_item';
    protected $primaryKey = 'id_item';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->hasMany(ItemLicitacao::class, 'id_item');
    }
}