<?php

namespace Acme;

use Acme\Contracts\OfflineConversionInterface;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;

class DeleteOfflineConversion implements OfflineConversionInterface
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @var
     */
    private $response;

    /**
     * @var mixed
     */
    private $dataSet;

    /**
     * OfflineConversion constructor.
     *
     * @param FacebookConnector $facebook
     */
    public function __construct(FacebookConnector $facebook)
    {
        $this->facebook = $facebook->getFacebook();
        $this->dataSet = $_ENV['VH_TEST_DATASET'];
    }

    /**
     * @throws FacebookSDKException
     */
    public function sendRequest(): void
    {
        try {
            $this->response = $this->facebook->delete(
                "/$this->dataSet"
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

    public function setDataSet(int $dataSet)
    {
        $this->dataSet = $dataSet;
        return $this;
    }
}
