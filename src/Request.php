<?php

namespace Acme;

use Acme\Contracts\DataSourceInterface;
use Acme\Contracts\OfflineConversionInterface;
use Acme\Model\CustomData;
use Acme\Model\MatchKey;
use Acme\Model\Sale;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookResponse;
use JsonSerializable;

final class Request implements OfflineConversionInterface, JsonSerializable
{
    private $sale;

    private $saleContents;

    private $dataSet;

    private $batch = [];

    private $response;

    private $facebook;

    public function __construct(
        FacebookConnector $facebook,
        DataSourceInterface $sale,
        DataSourceInterface $saleContents
    ) {
        $this->facebook = $facebook->getFacebook();

        $this->sale = $sale;
        $this->sale->readHeader()->readRecords(1, 10);

        $this->saleContents = $saleContents;
        $this->saleContents->readHeader()->readRecords(1, 50);
    }

    public function build()
    {
        foreach ($this->sale->getRecords() as $key => $item) {
            $this->batch[] = new Sale(
                $item['order_id'],
                new MatchKey($item['composite_key']),
                $item['event_time'],
                $item['value'],
                new CustomData(),
                $this->saleContents->getRecords()
            );
        }
    }

    public function getBatch()
    {
        return json_encode($this->batch, JSON_PRETTY_PRINT);
    }


    public function post(): void
    {
        try {
            $this->dataSet = $_ENV['VH_TEST_DATASET'];

            $this->response = $this->facebook->post(
                "/$this->dataSet/events",
                array(
                    'upload_tag' => 'store_data',
                    'data' => $this->getBatch()
                )
            );
        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    /**
     * @param string $eventDataSetId
     * @throws FacebookSDKException
     */
    public function delete(string $eventDataSetId): void
    {
        try {
            $this->response = $this->facebook->delete(
                "/$eventDataSetId"
            );
        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    public function getResponse(): FacebookResponse
    {
        return $this->response;
    }

    public function jsonSerialize()
    {
        return [
            $this->batch
        ];
    }
}
