<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 09/04/19
 * Time: 16:33
 */

namespace Forseti\Carga\ElicSC\Model;

use Illuminate\Database\Eloquent\Model;

class MensagemChat extends Model
{
    protected $table = 'tb_elic_sc_lic_mensagem_chat';
    protected $primaryKey = 'id_mensagem';
    protected $guarded = [];

    public function orgao()
    {
        return $this->belongsTo(Licitacao::class, 'nu_licitacao');
    }
}