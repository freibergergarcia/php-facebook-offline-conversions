<?php

namespace Acme\Model;

use JsonSerializable;

final class CustomData implements JsonSerializable
{
    /**
     * @var string
     */
    private $event_source = 'in_store';

    public function jsonSerialize()
    {
        return [
            'event_source' => $this->event_source
        ];
    }
}
