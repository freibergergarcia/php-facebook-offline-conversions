<?php


namespace Acme\Model;

use JsonSerializable;

final class Content implements JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $price;

    public function __construct(string $id, int $quantity, float $price)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }
}
