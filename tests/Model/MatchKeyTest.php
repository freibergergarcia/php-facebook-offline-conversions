<?php

namespace Acme;

use Acme\Model\MatchKey;
use PHPUnit\Framework\TestCase;

class MatchKeyTest extends TestCase
{
    public function testJsonSerializeMustReturnAValidJson()
    {
        $matchKey = new MatchKey('bruno.garcia@pvhba.com');
        self::assertIsArray($matchKey->jsonSerialize());
        self::assertThat(json_encode($matchKey->jsonSerialize()), self::isJson());
    }

    public function testCanConstructMatchKeyClass()
    {
        self::assertInstanceOf(MatchKey::class, new MatchKey('freibergergarcia@gmail.com'));
    }

    public function testCannotExtendMatchKeyClass()
    {
        self::assertClassHasAttribute('email', MatchKey::class);
    }
}
