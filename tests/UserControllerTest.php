<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use Controllers\UserController;

class UserControllerTest extends TestCase
{
    public function testGetAll()
    {
        $userController = new UserController;
        $this->assertEquals(TRUE, $userController->getAll());
    }
}
?>