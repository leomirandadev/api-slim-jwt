<?php

use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $user = $this->table('user')
        ->addColumn('name', 'string', ['limit' => 80])
        ->addColumn('password_hash', 'string', ['limit' => 40])
        ->addColumn('phone', 'string', ['limit' => 20])
        ->addColumn('email', 'string', ['limit' => 100])
        ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('updated', 'datetime', ['null' => true, 'update' => 'CURRENT_TIMESTAMP'])
        ->addIndex(['email'], ['unique' => true])
        ->create();
    }
    public function down()
    {
        return $this->execute('DROP TABLE user');
    }
}
