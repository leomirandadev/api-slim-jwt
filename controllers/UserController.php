<?php
namespace Controllers;
use Models\User;

class UserController {

  public $output = array();
  public $msg = '';

  /**
   * getAll
   *
   * @return bool
   */
  public function getAll():bool {
    $userModel = new User;
    
    if ( $userModel->getAll() ) {
      $this->output = $userModel;
      return TRUE;
    }
    
    $this->msg = 'Users not found';
    return FALSE;
  }
}