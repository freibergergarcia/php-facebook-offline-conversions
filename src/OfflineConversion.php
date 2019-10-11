<?php

namespace Acme;

use Acme\Contracts\OfflineConversionInterface;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;

final class OfflineConversion implements OfflineConversionInterface
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @var mixed
     */
    private $dataSet;

    /**
     * @var
     */
    private $response;

    /**
     * OfflineConversion constructor.
     *
     * @param FacebookConnector $facebook
     */
    public function __construct(
        FacebookConnector $facebook
    ) {
        $this->facebook = $facebook->getFacebook();
        $this->dataSet = $_ENV['VH_TEST_DATASET'];
    }

    /**
     * @param string $json
     * @throws FacebookSDKException
     */
    public function post(string $json): void
    {
        try {
            $this->response = $this->facebook->post(
                "/$this->dataSet/events",
                array(
                    'upload_tag' => 'store_data',
                    'data' => "$json"
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

    /**
     * @return FacebookResponse
     */
    public function getResponse(): FacebookResponse
    {
        return $this->response;
    }
}
