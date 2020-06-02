<?php

use PHPUnit\Framework\TestCase;
use Accolon\Token\Token;

final class TokenTest extends TestCase
{
    public function testTokenExpired(): void
    {
        Token::config("test", 0);
        $data = ["Test", 1];
        $token = Token::make($data);

        $this->assertFalse(Token::verify($token));
    }

    public function testTokenNotExpired():void
    {
        Token::config("test", 1);
        $data = ["Test", 1];
        $token = Token::make($data);

        $this->assertTrue(Token::verify($token));
    }

    public function testInvalidToken(): void
    {
        Token::config("test", 1);
        $data = ["Test", 1];
        $token = Token::make($data);

        $this->assertFalse(Token::verify("test"));
    }

    public function testExtract(): void
    {
        Token::config("test", 1);
        $data = ["Test", 60];
        $token = Token::make($data);

        $this->assertEquals(
            $data,
            Token::extract($token)
        );
    }

    public function testComplexExtractArray()
    {
        Token::config("test", 1);
        $data = [
            "name" => "Test name",
            "email" => "test@gmail.com",
            "password" => "123456"
        ];

        $token = Token::make($data);

        $this->assertEquals(
            $data,
            Token::extract($token)
        );
    }

    public function testComplexExtractObject()
    {
        Token::config("test", 1);
        $data = json_decode(json_encode([
            "name" => "Test name",
            "email" => "test@gmail.com",
            "password" => "123456"
        ]));

        $token = Token::make($data);

        $this->assertEquals(
            $data,
            Token::extract($token)
        );
    }
}