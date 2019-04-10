<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateItemLicitacao extends AbstractMigration
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
        $col->setName('id_item_licitacao')
            ->setType('biginteger')
            ->setIdentity(true)
            ->setSigned(false);
        $table = $this->table('tb_elic_sc_lic_item_licitacao', ['id' => false, 'primary_key' => 'id_item_licitacao']);
        $table->addColumn($col)
            ->addColumn('nu_item', 'biginteger', ['null'=> true])
            ->addColumn('id_lote', 'biginteger', ['null' => false, 'signed' => false])
            ->addColumn('id_item', 'biginteger', ['null' => false, 'signed' => false])
            ->addColumn('nu_licitacao', 'string', ['null'=> false])
            ->addColumn('nm_quantidade', 'text', ['null'=> true])
            ->addColumn('url_publica', 'string', ['limit' => 500,'null' => true])
            ->addTimestamps()
            ->addForeignKey('id_lote', 'tb_elic_sc_lic_lote', 'id_lote', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('id_item', 'tb_elic_sc_lic_item', 'id_item', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('nu_licitacao', 'tb_elic_sc_lic_licitacao', 'nu_licitacao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
        $table->save();

    }
}
