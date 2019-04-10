<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:24
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    protected $table = 'tb_elic_sc_lic_modalidade';
    protected $primaryKey = 'id_modalidade';
    protected $guarded = [];

    public function licitacao()
    {
        return $this->hasMany(Licitacao::class, 'id_modalidade');
    }
}