<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

class CreateAnexo extends AbstractMigration
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
        $col->setName('id_anexo')
            ->setType('biginteger')
            ->setIdentity(true)
            ->setSigned(false);
        $table = $this->table('tb_elic_sc_lic_anexo', ['id' => false, 'primary_key' => 'id_anexo']);
        $table->addColumn($col)
            ->addColumn('id_tipo_anexo', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('nu_licitacao', 'string', ['null'=> false])
            ->addColumn('nm_url', 'string', ['null'=> false])
            ->addColumn('nm_arquivo', 'string', ['null'=> false])
            ->addColumn('nm_arquivo_download', 'string', ['null'=> false])
            ->addColumn('nm_path', 'string', ['null'=> false])
            ->addColumn('dt_adicionado', 'datetime', ['null'=> false])
            ->addTimestamps()
            ->addForeignKey('id_tipo_anexo', 'tb_elic_sc_lic_tipo_anexo', 'id_tipo_anexo', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('nu_licitacao', 'tb_elic_sc_lic_licitacao', 'nu_licitacao', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
        $table->save();
    }
}
