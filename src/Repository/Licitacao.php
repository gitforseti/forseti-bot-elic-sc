<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 08/02/19
 * Time: 12:25
 */

namespace Forseti\Carga\ElicSC\Repository;

use Forseti\Carga\Bll\Model\Licitacao as LicitacaoModel;
use Forseti\Carga\Bll\Traits\ForsetiLoggerTrait;

class Licitacao
{
    use ForsetiLoggerTrait;

    const TRUE = 1;
    const FALSE = 0;

    public function update
    (
        $idPortal,
        $nuProcesso,
        $nmEdital,
        $orgao,
        $modalidade,
        $situacao,
        $txtObjeto,
        $nmPrazoImpugnacao,
        $txtObservacao,
        $dtEdital,
        $dtPublicacao,
        $dtIniEntregaProposta,
        $dtFimEntregaProposta,
        $dtDisputa
    )
    {

        $licitacao = self::findLicitacaoByIdPortal($idPortal)->first();

        if ($licitacao->where('flg_detalhes','!=',self::TRUE)
                      ->where('flg_processada','!=', self::TRUE)
                      ->first()
        )
        {
            try {



                $licitacao->update(
                    [
                        'nu_processo'             => $nuProcesso,
                        'nm_edital'               => $nmEdital,
                        'id_orgao'                => $orgao,
                        'id_modalidade'           => $modalidade,
                        'id_situacao'             => $situacao,
                        'txt_objeto'              => $txtObjeto,
                        'nm_prazo_impugnacao'     => $nmPrazoImpugnacao,
                        'txt_observacao'          => $txtObservacao,
                        'dt_edital'               => $dtEdital,
                        'dt_publicacao'           => $dtPublicacao,
                        'dt_ini_entrega_proposta' => $dtIniEntregaProposta,
                        'dt_fim_entrega_proposta' => $dtFimEntregaProposta,
                        'dt_disputa'              => $dtDisputa,
                        'flg_detalhes'            => self::TRUE
                    ]);

                $this->info('licitacao com detalhes atualizados', ['id_licitacao' => $licitacao->id_licitacao]);

            } catch (\Exception $e) {

                $this->error('Erro ao atualizar os detalhes da licitacao: ', ['exception' => $e->getMessage()]);
            }

            return $licitacao;
        }

        $this->debug('licitacao ja processada ', ['id_licitacao' => $licitacao->id_licitacao]);

    }

    public function idPortalSave($idPortal)
    {

        $condition = self::findLicitacaoByIdPortal($idPortal);

        if (!$condition->exists()) {

            try {
                $licitacao = new LicitacaoModel();

                $licitacao->id_portal = $idPortal;
                $licitacao->save();

                $this->info("id_portal da licitacao inserido", ['id_portal' => $idPortal]);

                return $licitacao;

            } catch (\Exception $e) {

                $this->error("erro ao inserir o id portal da licitacao", ['exception' => $e->getMessage()]);
            }
        }
    }

    public function addFlg($idPortal, $fieldName)
    {

        try {

            $licitacao = Licitacao::firstLicitacao($idPortal);

            $cargaUpdated = LicitacaoModel::find($licitacao->id_licitacao);

            $cargaUpdated->update(
                [
                    $fieldName => true
                ]);

            $this->info("flag adicionado a licitacao", ['flag' => $fieldName , 'id_licitacao' => $licitacao->id_licitacao]);

            return $cargaUpdated;

        } catch (\Exception $e) {

            $this->error('Erro atualizar o flag no banco de dados: ' . $e->getMessage());
        }
    }

    public static function licitacaoToProcess()
    {
        return LicitacaoModel::where('flg_processada', 0)->get();
    }

    public static function toSync($numeroLicitacao = null, $idLicitacao = null)
    {
        return LicitacaoModel::where('flg_detalhes', 1)
            //->where('flg_lote',1)
            //->where('flg_edital',1)
            ->where('flg_processada',1)
            ->where('flg_sincronizada',0)
            ->get();
    }


    public static function findLicitacaoByIdPortal($idPortal)
    {
        return LicitacaoModel::where('id_Portal', $idPortal);
    }

    public static function firstLicitacao($idPortal)
    {
        return self::findLicitacaoByIdPortal($idPortal)->first();
    }
}