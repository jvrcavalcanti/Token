<?php

use PHPUnit\Framework\TestCase;
use Accolon\Token\Token;

final class TokenTest extends TestCase
{
    public function testTokenExpired(): void
    {
        Token::config("test", 0);
        $token = Token::make(["user" => "Test"]);
        sleep(1);

        $this->assertFalse(Token::verify($token));
    }

    public function testTokenNotExpired():void
    {
        Token::config("test", 1);
        $token = Token::make(["user" => "Test"]);

        $this->assertTrue(Token::verify($token));
    }

    public function testInvalidToken(): void
    {
        Token::config("test", 1);
        $token = Token::make(["user" => "Test"]);

        $this->assertFalse(Token::verify("test"));
    }

    public function testExtract(): void
    {
        Token::config("test", 1);
        $token = Token::make(["user" => "Test"]);

        $this->assertEquals(
            ["user" => "Test"],
            Token::extract($token)
        );
    }
}