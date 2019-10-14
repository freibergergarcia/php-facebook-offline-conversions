<?php

namespace Acme\Model;

use Acme\Parser;
use JsonSerializable;

final class MatchKey implements JsonSerializable
{
    /**
     * @var string
     */
    private $email;

    /**
     * MatchKey constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = Parser::formatEmail($email);
        $this->email = Parser::hashMatchKey($this->email);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'email' => $this->email,
        ];
    }
}
