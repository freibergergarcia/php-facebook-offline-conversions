<?php

namespace Acme;

use Acme\Contracts\DataSourceInterface;
use Acme\Contracts\OfflineConversionInterface;
use Acme\Model\CustomData;
use Acme\Model\MatchKey;
use Acme\Model\Sale;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use JsonSerializable;

/**
 * Class Request
 * @package Acme
 * @todo This object has too many responsibilities at the moment,
 *       maybe the build() and __construct could be done in a different
 *       object.
 */
final class Request implements OfflineConversionInterface, JsonSerializable
{
    /**
     * @var DataSourceInterface
     */
    private $sale;

    /**
     * @var DataSourceInterface
     */
    private $saleContents;

    /**
     * @var int
     */
    private $dataSet;

    /**
     * @var array
     */
    private $batch = [];

    /**
     * @var FacebookResponse
     */
    private $response;

    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * Request constructor.
     * @param FacebookConnector $facebook
     */
    public function __construct(
        FacebookConnector $facebook
    ) {
        $this->facebook = $facebook->getFacebook();
    }

    /**
     * @param DataSourceInterface $sale
     * @param DataSourceInterface $saleContents
     */
    public function build(
        DataSourceInterface $sale,
        DataSourceInterface $saleContents
    ): void {
        $this->sale = $sale;
        $this->sale->readHeader()->readRecords(1, 10);

        $this->saleContents = $saleContents;
        $this->saleContents->readHeader()->readRecords(1, 50);

        foreach ($this->sale->getRecords() as $item) {
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

    /**
     * @throws FacebookSDKException
     */
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
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
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
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getBatch(): string
    {
        return json_encode($this->batch, JSON_PRETTY_PRINT);
    }

    /**
     * @return FacebookResponse
     */
    public function getResponse(): FacebookResponse
    {
        return $this->response;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            $this->batch,
        ];
    }
}
