<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:34
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class ItemLicitacao extends Model
{
    protected $table = 'tb_elic_sc_lic_item_licitacao';
    protected $primaryKey = 'id_item_licitacao';
    protected $guarded = [];

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function licitacao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }
}