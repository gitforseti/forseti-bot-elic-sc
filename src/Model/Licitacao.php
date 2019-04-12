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

    public function insert($licitacao, $detalhe, $dtEdital)
    {
        try {
            $orgao = Orgao::firstOrCreate([
                'nm_sigla_orgao' => $licitacao->unidadeCompradora,
                'nm_orgao' => '$detalhe->unidade_compradora'
            ]);
            $situacao = Situacao::firstOrCreate([
                'nm_situacao' => $licitacao->situacao
            ]);
            $modalidade = Modalidade::firstOrCreate([
                'nm_modalidade' => $licitacao->modalidade,
                'nm_abreviado' => null
            ]);
            Licitacao::firstOrCreate([
                'nu_licitacao' => $licitacao->codigo,
                'nm_processo' => $licitacao->processo,
                'nu_processo' => null, // verificar o que é isso
                'nu_edital' => '$detalhe->edital',
                'id_orgao' => $orgao['id_orgao'],
                'id_modalidade' => $modalidade['id_modalidade'],
                'id_situacao' => $situacao['id_situacao'],
                'url_publica' => null, // verificar o que é isso
                'nm_objeto' => $detalhe->objeto,
                'dt_edital' => $dtEdital,
                'dt_abertura_proposta' => $detalhe->terminoPropostas, // lembrar de alterar para abertura
                'dt_fim_proposta' => $detalhe->terminoPropostas,
                'dt_disputa' => null // verificar o que é isso
            ]);
        }catch (\Exception $e) {
            $this->error('Erro ao inserir licitacao: ', ['exception' => $e->getMessage()]);
        }
    }

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