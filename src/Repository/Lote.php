<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 11/02/19
 * Time: 08:54
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\Bll\Model\Lote as LoteModel;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;
use Forseti\Carga\Bll\Model\Licitacao as LicitacaoModel;

class Lote
{
    use ForsetiLoggerTrait;

    public  function addLote(LicitacaoModel $licitacao, $nmLote)
    {

        try {

            $lote = $licitacao->lote()->firstOrCreate([
                'nm_lote' => $nmLote
            ]);

            $this->info('informacoes do lote inseridas ', ['id_licitacao' => $licitacao->id_licitacao]);

            return $lote;

        } catch (\Exception $e) {

            $this->error('erro ao inserir as informacoes do lote', ['exception' => $e->getMessage()]);
        }
    }

    public static function findLoteByIdLicitacao($idLicitacao)
    {
        return LoteModel::where('id_licitacao', $idLicitacao);
    }

    public static function firstLote($idLicitacao = null)
    {
        return self::findLoteByIdLicitacao($idLicitacao)->first();
    }

}