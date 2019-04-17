<?php
/**
 * Created by PhpStorm.
 * User: antonio-augusto
 * Date: 16/04/19
 * Time: 11:47
 */

namespace Forseti\Carga\ElicSC\Repository;


use Forseti\Carga\ElicSC\Model\Item;
use Forseti\Carga\ElicSC\Model\Licitacao;
use Forseti\Carga\ElicSC\Traits\ForsetiLoggerTrait;

class ItensRepository
{
    use ForsetiLoggerTrait;

    public function insert($nu_licitacao, $item)
    {
        try{
            $licitacao = Licitacao::find($nu_licitacao);
            if(!$licitacao->flag_item){
                return Item::create([
                    'nu_licitacao' => $nu_licitacao,
                    'descricao' => $item->item,
                    'descricao_detalhada' => null,
                    'nm_categoria' => null,
                    'unidade_medida' => $item->unidadeMedida,
                    'nm_quantidade' => strval($item->quantidade),
                    'valor_referencia' => $item->valorReferencia,
                    'url_publica' => null
                ]);
            }
        }catch (\Exception $e) {
            $this->error('erro ao inserir item no banco: ', ['exception' => $e->getMessage()]);
        }
    }

    public function updateFlag($nu_licitacao, $flag)
    {
        try{
            $licitacao = Licitacao::find($nu_licitacao);
            $licitacao->flag_item = $flag;
            $licitacao->save();
        }catch (\Exception $e) {
            $this->error('erro ao atualizar flag do item no banco: ', ['exception' => $e->getMessage()]);
        }
    }
}