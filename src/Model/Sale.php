<?php

namespace Acme\Model;

use Acme\Parser;
use JsonSerializable;
use League\Csv\ResultSet;

final class Sale implements JsonSerializable
{
    /**
     * @var string
     */
    private $order_id;

    /**
     * @var array of MatchKey
     */
    private $match_keys = [];

    /**
     * @var string
     */
    private $event_time;

    /**
     * @var string
     */
    private $event_name = 'Purchase';

    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $currency = 'AUD';

    /**
     * @var array
     */
    private $custom_data;

    /**
     * @var array
     */
    private $contents = [];

    /**
     * Sale constructor.
     * @param string $order_id
     * @param MatchKey $match_key
     * @param string $event_time
     * @param float $value
     * @param CustomData $custom_data
     * @param ResultSet $contents
     */
    public function __construct(
        string $order_id,
        MatchKey $match_key,
        string $event_time,
        float $value,
        CustomData $custom_data,
        ResultSet $contents
    ) {
        $this->order_id = $order_id;
        $this->match_keys = $match_key;
        $this->event_time = Parser::dateToTimestamp($event_time);
        $this->value = $value;
        $this->custom_data = $custom_data;
        $this->setContents($contents);
    }

    /**
     * @param ResultSet $contents
     */
    public function setContents(ResultSet $contents): void
    {
        $arrayOfSaleLine = iterator_to_array($contents, true);

        foreach ($arrayOfSaleLine as $key => $item) {
            if ($item['order_id'] === $this->order_id) {
                $this->contents[] = new Content(
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
                unset($arrayOfSaleLine[$key]);
            }
        }
        unset($this->order_id);
    }

    /**
     * @return array
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'match_keys' => $this->match_keys,
            'event_time' => $this->event_time,
            'event_name' => $this->event_name,
            'value' => $this->value,
            'currency' => $this->currency,
            'contents' => $this->contents,
            'custom_data' => $this->custom_data,
        ];
    }
}
