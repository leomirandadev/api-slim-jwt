<?php
namespace Models;

use DataManagerLam\DataManager;

class User extends DataManager {
  
  public $name = null;
  public $phone = null;
  public $email = null;

  function __construct() {
    $this->table = 'user';
  }

  /**
   * getAll
   *
   * @return void
   */
  public function getAll() {
    $users = $this->select();
    return $users;
  }

  /**
   * create
   *
   * @param  string $password
   *
   * @return void
   */
  public function create(string $password) {
    $passwordHash = md5( $password );
    $this->data = array(
      'name' => $this->name,
      'password_hash' => $passwordHash,
      'email' => $this->email
    );
    return $this->insert();
  }
}