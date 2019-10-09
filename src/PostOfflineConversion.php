<?php

namespace Acme;

use Acme\Contracts\DataSourceInterface;
use Acme\Contracts\OfflineConversionInterface;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;

class PostOfflineConversion implements OfflineConversionInterface
{
    /**
     * @var Facebook
     */
    private $facebook;

    /**
     * @var $file
     */
    private $file;

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
     * @param FacebookConnector   $facebook
     * @param DataSourceInterface $file
     */
    public function __construct(FacebookConnector $facebook, DataSourceInterface $file)
    {
        $this->facebook = $facebook->getFacebook();
        $this->dataSet = $_ENV['VH_TEST_DATASET'];
        $this->file = $file;
        $this->file->readHeader()->readRecords(50, 200);
    }

    /**
     * @throws FacebookSDKException
     */
    public function sendRequest(): void
    {
        $conversions = (new Result())->prepareDataToFacebook($this->file);

        try {
            $this->response = $this->facebook->post(
                "/$this->dataSet/events",
                array(
                    'upload_tag' => 'store_data',
                    'data' => "[
                    $conversions
                  ]"
                )
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
}
