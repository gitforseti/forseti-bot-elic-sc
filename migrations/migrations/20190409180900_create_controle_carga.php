<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateControleCarga extends AbstractMigration
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
            ->setType('string');
        $table = $this->table('tb_elic_sc_lic_controle_carga', ['id' => false, 'primary_key' => 'nu_licitacao']);
        $table->addColumn($col)
            ->addColumn('licitacao', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('item_lote', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_item_lote', 'datetime', ['null'=> true])
            ->addColumn('edital', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_edital', 'datetime', ['null'=> true])
            ->addColumn('ata', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_ata', 'datetime', ['null'=> true])
            ->addColumn('chat', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_chat', 'datetime', ['null'=> true])
            ->addColumn('historico', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_historico', 'datetime', ['null'=> true])
            ->addColumn('mongo', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('dt_mongo', 'datetime', ['null'=> true])
            ->addForeignKey('nu_licitacao', 'tb_elic_sc_lic_licitacao', 'nu_licitacao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addTimestamps()
            ->create();
        $table->save();
    }
}
