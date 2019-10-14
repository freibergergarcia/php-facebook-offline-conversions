<?php

namespace Acme;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testMustReturnHashedKey()
    {
        self::assertEquals(
            Parser::hashMatchKey('freibergergarcia@gmail.com'),
            '6dba944d897751d94d04dc57ad69ab9807538643b276e1ac7e3d9f773ad9a4bb'
        );
    }
}
