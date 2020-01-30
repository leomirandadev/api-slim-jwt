<?php


use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'    => 'Leonardo',
                'email'    => 'leoamiranda2@gmail.com',
                'password_hash' => md5('33333'),
            ],
            [
                'name'    => 'Roberto',
                'email'    => 'roberto_oloko@icloud.com',
                'password_hash' => md5('123'),
            ],
            [
                'name'    => 'Cassandra',
                'email'    => 'cassandra.voss@hotmail.com',
                'password_hash' => md5('09122'),
            ],
            [
                'name'    => 'Elizangela',
                'email'    => 'eliz_21@gmail.com',
                'password_hash' => md5('11111'),
            ],
        ];

        $posts = $this->table('user');
        $posts->insert($data)
              ->save();
    }
}
