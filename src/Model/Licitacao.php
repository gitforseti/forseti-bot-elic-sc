<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:22
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class Licitacao extends Model
{
    protected $table = 'tb_elic_sc_lic_licitacao';
    protected $primaryKey = 'nu_licitacao';
    protected $guarded = [];

    public function orgao()
    {
        return $this->belongsTo(Orgao::class, 'id_orgao');
    }
    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'id_modalidade');
    }
    public function situacao()
    {
        return $this->belongsTo(Situacao::class, 'id_situacao');
    }

    public function mensagemChat()
    {
        return $this->hasMany(MensagemChat::class , 'nu_licitacao');
    }
    public function controleCarga()
    {
        return $this->hasMany(ControleCarga::class , 'nu_licitacao');
    }
    public function historico()
    {
        return $this->hasMany(Historico::class , 'nu_licitacao');
    }
    public function itemLicitacao()
    {
        return $this->hasMany(ItemLicitacao::class , 'nu_licitacao');
    }
    public function lote()
    {
        return $this->hasMany(Lote::class , 'nu_licitacao');
    }
}