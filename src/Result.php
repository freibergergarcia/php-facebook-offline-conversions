<?php

namespace Acme;

use Acme\Contracts\DataSourceInterface;

class Result
{
    /**
     * @var string
     */
    private $results = '';

    /**
     * @var DataSourceInterface
     */
    private $file;

    /**
     * @var string
     */
    private $currency = 'AUD';

    /**
     * @var string
     */
    private $event_name = 'Purchase';

    /**
     * @var string
     */
    private $event_source = 'in_store';

    /**
     * @todo   Refactor this function, it should only call a method and return the json
     *         SalesHeader must reflect general Sale information
     *         SalesLine must reflect each item and its quantities
     *
     * @param  DataSourceInterface $file
     * @return string
     */
    public function prepareDataToFacebook(DataSourceInterface $file): string
    {
        $this->file = $file;

        foreach ($this->file->getRecords() as $record) {
            $timestamp = strtotime('10/04/2019 12:00:00');
            $hashedEmail = self::hashMatchKey($record['Email']);
            $quantity = ($record['Quantity'] < 1) ? 1 : $record['Quantity'];

            // TODO: Create an object to store this
            $this->results .= <<<EOF
            {
              "match_keys": {
                "email": "$hashedEmail"
              },
              "currency": "$this->currency",
              "value": $record[Amount],
              "event_name": "$this->event_name",
              "event_time": "$timestamp",
              "contents": [
                {
                  "id": "$record[Stylecode]",
                  "quantity": $quantity
                }
              ],
              "custom_data": {
                "event_source": "$this->event_source"
              }
            },
EOF;
        }
        return $this->results;
    }

    /**
     * @param  string $matchKey
     * @return string
     */
    private static function hashMatchKey(string $matchKey): string
    {
        return hash("sha256", $matchKey);
    }
}
