<?php
namespace Tests;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }
}
?>