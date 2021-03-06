<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateItem extends AbstractMigration
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
        $col->setName('id_item')
            ->setType('biginteger')
            ->setIdentity(true)
            ->setSigned(false);
        $table = $this->table('tb_elic_sc_lic_item', ['id' => false, 'primary_key' => 'id_item']);
        $table->addColumn($col)
            ->addColumn('nu_licitacao', 'biginteger', ['null' => true, 'signed' => false])
            ->addColumn('descricao', 'text', ['null'=> true])
            ->addColumn('descricao_detalhada', 'text', ['null'=> true])
            ->addColumn('nm_categoria', 'text', ['null'=> true])
            ->addColumn('unidade_medida', 'text', ['null'=> true])
            ->addColumn('nm_quantidade', 'text', ['null'=> true])
            ->addColumn('valor_referencia', 'text', ['null'=> true])
            ->addColumn('url_publica', 'string', ['limit' => 500,'null' => true])
            ->addForeignKey('nu_licitacao', 'tb_elic_sc_lic_licitacao', 'nu_licitacao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addTimestamps()
            ->create();
        $table->save();
    }
}

