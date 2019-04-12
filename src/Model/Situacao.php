<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:24
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{
    protected $table = 'tb_elic_sc_lic_situacao';
    protected $primaryKey = 'id_situacao';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->hasMany(Licitacao::class, 'id_situacao');
    }

}