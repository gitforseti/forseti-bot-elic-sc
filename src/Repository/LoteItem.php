<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 11/02/19
 * Time: 10:26
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\Bll\Model\LoteItem as LoteItemModel;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;
use Forseti\Carga\Bll\Model\Lote as LoteModel;

class LoteItem
{
    use ForsetiLoggerTrait;

    public function addLoteItem(LoteModel $lote, $nuItem, $nmItem, $nuQuantidade)
    {

        try {

            $loteItem = $lote->itemLote()->firstOrCreate([
                'nu_item'       => $nuItem,
                'nm_item'       => $nmItem,
                'nu_quantidade' => $nuQuantidade,
                'nm_produto'    => $nmItem,
            ]);

            $this->info("item do lote inserido", ['id_lote' => $lote->id_lote]);

            return $loteItem;

        } catch (\Exception $e) {

            $this->error('erro ao inserir as informacoes itens do lote', ['exception' => $e->getMessage()]);

        }
    }
}