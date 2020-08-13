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
        $token = JwtProcess::encode(['id' => 4]);

        $jwt = new JwtProcess;
        $jwt->decode($token);

        $this->assertEquals(4, $jwt->payload['id']);
    }
}
