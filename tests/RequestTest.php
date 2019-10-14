<?php

namespace Acme;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class RequestTest extends TestCase
{
    /**
     * @var string
     */
    private $saleFilePath;

    /**
     * @var string
     */
    private $saleContentsFilePath;

    /**
     * @var Csv
     */
    private $saleHeader;

    /**
     * @var Csv
     */
    private $saleContents;

    /**
     * @var FacebookConnector
     */
    private $facebook;

    /**
     * @var
     */
    private $request;

    public function setUp(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env', __DIR__ . '/../.env.dev');

        $this->facebook = new FacebookConnector();

        $this->saleFilePath = __DIR__ . '/../assets/csv-example/SALEHEADER.csv';
        $this->saleContentsFilePath = __DIR__ . '/../assets/csv-example/SALELINE.csv';

        $this->saleHeader = new Csv($this->saleFilePath);
        $this->saleContents = new Csv($this->saleContentsFilePath);

        $this->saleHeader->readHeader()->readRecords(1, 10);
        $this->saleContents->readHeader()->readRecords(1, 50);

        $this->request = new Request($this->facebook, $this->saleHeader, $this->saleContents);
        $this->request->build();
    }

    public function testMustReturnAJsonObject()
    {
        self::assertThat($this->request->getBatch(), self::isJson());
    }

    public function testJsonMustReturnValidObject()
    {
        $decodedRequest = json_decode($this->request->getBatch());

        self::assertIsArray($decodedRequest);
        self::assertGreaterThan(1, $decodedRequest);
        self::assertObjectHasAttribute('match_keys', $decodedRequest[0]);
        self::assertObjectHasAttribute('contents', $decodedRequest[0]);
    }
}