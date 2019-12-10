<?php
namespace Models;

use DataManagerLam\DataManager;

class User extends DataManager {
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
}