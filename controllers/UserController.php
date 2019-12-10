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

    $result = $userModel->getAll();
    if ( $result ) {
      $this->output = $result;
      return TRUE;
    }
    
    $this->msg = 'Users not found';
    return FALSE;
  }
  
  /**
   * getById
   *
   * @param  int $id
   *
   * @return bool
   */
  public function getById(int $id):bool {
    $userModel = new User;

    $result = $userModel->getById($id);
    if ( $result ) {
      $this->output = $result;
      return TRUE;
    }
    
    $this->msg = 'User not found';
    return FALSE;
  }

  /**
   * create
   *
   * @param  mixed $args
   *
   * @return bool
   */
  public function create(array $args):bool {
    
    if ( !$this->checkValidate($args) ) return FALSE;

    $userModel = new User;
    $userModel->name = $args['name'];
    $userModel->email = $args['email'];
    
    $result = $userModel->create($args['password']);
    if ( $result ) {
      $this->output = $result;
      return TRUE;
    }
    
    $this->msg = 'User not created';
    return FALSE;
  }

  /**
   * checkValidate
   *
   * @param  array $args
   *
   * @return bool
   */
  private function checkValidate(array $args):bool {
    if (
      !isset($args['name']) || empty($args['name']) ||
      !isset($args['email']) || empty($args['email']) ||
      !isset($args['password']) || empty($args['password'])
    ){
      $this->msg = 'Data not validated';
      return FALSE;
    }

    return TRUE;
  }
}