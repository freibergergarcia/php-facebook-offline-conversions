<?php

namespace Acme\Model;

use Acme\Contracts\DataSourceInterface;

final class DataFactory
{
    /**
     * @var DataSourceInterface
     */
    private $sale;

    /**
     * @var DataSourceInterface
     */
    private $saleLine;

    /**
     * @var Sale array
     */
    private $dataSetContent = [];

    /**
     * @var array
     */
    private $jsonDataSet = [];

    /**
     * OfflineConversion constructor.
     *
     * @param DataSourceInterface $sale
     * @param DataSourceInterface $saleLine
     */
    public function __construct(
        DataSourceInterface $sale,
        DataSourceInterface $saleLine
    ) {
        $this->sale = $sale;
        $this->sale->readHeader()->readRecords(1, 10);

        $this->saleLine = $saleLine;
        $this->saleLine->readHeader()->readRecords(1, 50);
    }

    /**
     * @return void
     */
    public function buildSale(): void
    {
        foreach ($this->sale->getRecords() as $key => $item) {
            $this->dataSetContent[] = (new Sale())->setUp(
                $item['order_id'],
                $item['composite_key'],
                $item['sale_date'],
                $item['total'],
                $this->saleLine
            )->setContents();
        }
    }

    /**
     * @return string
     */
    public function dataSetToJson(): string
    {
        foreach ($this->dataSetContent as $sale) {
            $this->jsonDataSet[] = [
                'match_keys' => [
                    'email' => $sale->getMatchKeys()
                ],
                'currency' => $sale->getCurrency(),
                'value' => $sale->getValue(),
                'event_name' => $sale->getEventName(),
                'event_time' => $sale->getEventTime(),
                'contents' => $sale->getContents(),
                'custom_data' => [
                    'event_source' => 'in_store'
                ]
            ];
        }

        return json_encode($this->jsonDataSet);
    }

    /**
     * @return Sale|array
     */
    public function getDataSetContent()
    {
        return $this->dataSetContent;
    }
}
