<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:24
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
    protected $table = 'tb_elic_sc_lic_orgao';
    protected $primaryKey = 'id_orgao';
    protected $guarded = [];
    protected $fillable = ['nm_sigla_orgao','nm_orgao'];

    public function licitacao()
    {
        return $this->hasMany(Licitacao::class, 'id_orgao');
    }
}