<?php
namespace Models;

use Utils\Model;

class User extends Model
{

    public function __construct()
    {
        $this->table = "user";
        $this->camps = [
            "id",
            "name",
            "email",
            "password_hash",
            "created_at",
            "updated_at",
        ];
        $this->sensiveCamps = ["password_hash"];
    }

}
