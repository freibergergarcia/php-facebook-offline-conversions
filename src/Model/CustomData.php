<?php

namespace Acme\Model;

use JsonSerializable;

final class CustomData implements JsonSerializable
{
    /**
     * @var string
     */
    private $event_source = 'in_store';

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'event_source' => $this->event_source,
        ];
    }
}
