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

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email): void
    {
        $this->email = Parser::formatEmail($email);
        $this->email = Parser::hashMatchKey($this->email);
    }

    public function jsonSerialize()
    {
        return [
            'email' => $this->email
        ];
    }
}
