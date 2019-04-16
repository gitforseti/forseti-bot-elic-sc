<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateLicitacao extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $col = new Column();
        $col->setName('nu_licitacao')
            ->setType('biginteger')
            ->setIdentity(true)
            ->setSigned(false);
        $table = $this->table('tb_elic_sc_lic_licitacao', ['id' => false, 'primary_key' => 'nu_licitacao']);
        $table->addColumn($col)
            ->addColumn('nm_processo', 'string', ['null'=> true])
            ->addColumn('nu_processo', 'string', ['null'=> true])
            ->addColumn('nu_edital', 'string', ['null'=> true])
            ->addColumn('nCdAnexo', 'string', ['null'=> true])
            ->addColumn('nCdModulo', 'string', ['null'=> true])
            ->addColumn('nCdSituacao', 'string', ['null'=> true])
            ->addColumn('tmpTipoMuralProcesso', 'string', ['null'=> true])
            ->addColumn('id_orgao', 'biginteger', ['null' => true, 'signed' => false])
            ->addColumn('id_modalidade', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('id_situacao', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('url_publica', 'string', ['limit' => 500, 'null'=> true])
            ->addColumn('nm_objeto', 'text', ['null'=> true])
            ->addColumn('dt_edital', 'datetime', ['null'=> true])
            ->addColumn('dt_abertura_proposta', 'datetime', ['null'=> true])
            ->addColumn('dt_fim_proposta', 'datetime', ['null'=> true])
            ->addColumn('dt_disputa', 'datetime', ['null'=> true])
            ->addColumn('flag_item', 'boolean', ['null'=> false, 'default' => false])
            ->addColumn('flag_anexo', 'boolean', ['null'=> false, 'default' => false])
            ->addForeignKey('id_orgao', 'tb_elic_sc_lic_orgao', 'id_orgao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('id_modalidade', 'tb_elic_sc_lic_modalidade', 'id_modalidade', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('id_situacao', 'tb_elic_sc_lic_situacao', 'id_situacao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addTimestamps()
            ->create();
        $table->save();
    }
}
