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
   * @param  array $args
   *
   * @return bool
   */
  public function create(array $args):bool {
    
    if ( !$this->checkAllData($args) ) return FALSE;

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
   * update
   *
   * @param  array $args
   * @param  int $id
   *
   * @return bool
   */
  public function update(int $id, array $args):bool {
    
    if ( !$this->checkAllData($args) ) return FALSE;

    $userModel = new User;
    $userModel->name = $args['name'];
    $userModel->email = $args['email'];
    
    if ( $userModel->getByIdPassword($id, $args['password']) ){
      if ( $userModel->changeAll($id, $args['password']) ) {
        $this->msg = 'User updated successfuly';
        return TRUE;
      }
      $this->msg = 'Error on change user data';
      return FALSE;
    }
    
    $this->msg = 'User not match';
    return FALSE;
  }

  /**
   * changePassword
   *
   * @param  array $args
   *
   * @return bool
   */
  public function changePassword(int $id, array $args):bool {

    if ( !$this->checkDataToChangePassword($args) ) return FALSE;

    $userModel = new User;

    if ( $userModel->getByIdPassword($id, $args['password']) ){
      if ($userModel->changePassword($id, $args['newPassword'])) {
        $this->msg = 'Password change successfuly';
        return TRUE;
      }
      $this->msg = 'Error on change password';
      return FALSE;
    }
    
    $this->msg = 'User not match';
    return FALSE;
  }

  /**
   * login
   *
   * @param  array $args
   *
   * @return bool
   */
  public function login(array $args):bool {

    if ( !$this->checkDataToLogin($args) ) return FALSE;

    $userModel = new User;
    $userModel->email = $args['email'];
    $result = $userModel->getByEmailPassword($args['password']);

    if ( $result ) {
      unset($result[0]['password_hash']);
      $this->output = $result;
      return TRUE;
    }
    
    $this->msg = 'User not found';
    return FALSE;
  }

  /**
   * checkAllData
   *
   * @param  array $args
   *
   * @return bool
   */
  private function checkAllData(array $args):bool {
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

  /**
   * checkDataToLogin
   *
   * @param  array $args
   *
   * @return bool
   */
  private function checkDataToLogin(array $args):bool {
    if (
      !isset($args['email']) || empty($args['email']) ||
      !isset($args['password']) || empty($args['password'])
    ){
      $this->msg = 'Data not validated';
      return FALSE;
    }

    return TRUE;
  }
 
  /**
   * checkDataToChangePassword
   *
   * @param  array $args
   *
   * @return bool
   */
  private function checkDataToChangePassword(array $args):bool {
    if (
      !isset($args['newPassword']) || empty($args['newPassword']) ||
      !isset($args['password']) || empty($args['password'])
    ){
      $this->msg = 'Data not validated';
      return FALSE;
    }

    return TRUE;
  }
}