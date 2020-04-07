<?php

require_once "./vendor/autoload.php";

use Accolon\Token\Bcrypt;
use PHPUnit\Framework\TestCase;

class BcryptTest extends TestCase
{
    public function testBase()
    {
        $password = "test";

        $hash = Bcrypt::make($password);

        $this->assertTrue(Bcrypt::verify($password, $hash));
    }
}