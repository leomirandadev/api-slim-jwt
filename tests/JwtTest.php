<?php
namespace Tests;

use Jwt\JwtProcess;
use PHPUnit\Framework\TestCase;

class JwtTest extends TestCase
{
    public function testEncodeToken()
    {
        $this->assertEquals(true, is_string(JwtProcess::encode([])));
    }

    public function testDecodeToken()
    {
        $token = JwtProcess::encode([]);

        $jwt = new JwtProcess;
        $this->assertEquals(true, $jwt->decode($token));
    }
}
