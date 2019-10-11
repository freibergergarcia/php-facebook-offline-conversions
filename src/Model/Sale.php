<?php

namespace Acme\Model;

use Acme\Contracts\DataSourceInterface;
use Acme\Parser;

final class Sale
{
    /**
     * @var string
     */
    private $order_id;

    /**
     * @var array
     */
    private $match_keys = [];

    /**
     * @var int
     */
    private $event_time;

    /**
     * @var string
     */
    private $event_name = 'Purchase';

    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $currency = 'AUD';

    /**
     * @var array
     */
    private $custom_data = ['event_source' => 'in_store'];

    /**
     * @var array
     */
    private $contents;

    /**
     * @var DataSourceInterface
     */
    private $saleLine;

    /**
     * @param string $order_id
     * @param string $composite_key
     * @param string $event_time
     * @param float $value
     * @param DataSourceInterface $saleLine
     * @return $this
     */
    public function setUp(
        string $order_id,
        string $composite_key,
        string $event_time,
        float $value,
        DataSourceInterface $saleLine
    ) {
        $this->order_id = $order_id;
        $this->match_keys = Parser::hashMatchKey(
            Parser::formatEmail($composite_key)
        );
        $this->event_time = Parser::dateToTimestamp($event_time);
        $this->value = $value;
        $this->saleLine = $saleLine;

        return $this;
    }

    /**
     * @return $this
     */
    public function setContents()
    {
        $arrayOfSaleLine = iterator_to_array($this->saleLine->getRecords(), true);
        $orderId = $this->order_id;

        $this->contents = array_filter($arrayOfSaleLine, function ($var) use ($orderId) {
            return $var['order_id'] === $orderId;
        });
        unset($this->saleLine);

        return $this;
    }

    /**
     * @return string
     */
    public function getMatchKeys(): string
    {
        return $this->match_keys;
    }

    /**
     * @return int
     */
    public function getEventTime(): int
    {
        return $this->event_time;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->event_name;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function getCustomData(): array
    {
        return $this->custom_data;
    }

    /**
     * @return array
     */
    public function getContents(): array
    {
        foreach ($this->contents as $k => $content) {
            unset($this->contents[$k]['order_id']);
        }
        return array_values($this->contents);
    }
}
