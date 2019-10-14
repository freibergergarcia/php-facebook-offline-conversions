<?php

namespace Acme;

use League\Csv\ResultSet;
use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
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


    public function setUp(): void
    {
        $this->saleFilePath = __DIR__ . '/../assets/csv-example/SALEHEADER.csv';
        $this->saleContentsFilePath = __DIR__ . '/../assets/csv-example/SALELINE.csv';

        $this->saleHeader = new Csv($this->saleFilePath);
        $this->saleContents = new Csv($this->saleContentsFilePath);

        $this->saleHeader->readHeader()->readRecords(1, 10);
        $this->saleContents->readHeader()->readRecords(1, 50);
    }

    public function testReadHeaderMustReturnAnCsvObject()
    {
        self::assertDirectoryExists(__DIR__ . '/../assets/csv-example/');
    }

    public function testReadHeaderMustReturn4Results()
    {
        $this->saleHeader->readHeader()->readRecords(1, 4);

        self::assertEquals(count($this->saleHeader->getHeader()), 4);
        self::assertEquals(count($this->saleContents->getHeader()), 4);
    }

    public function testReadContentsMustReturn3and9Results()
    {
        self::assertEquals(count($this->saleHeader->getRecords()), 3);
        self::assertEquals(count($this->saleContents->getRecords()), 8);
    }


    public function testCsvMustCreateAObjectFromASalesHeaderFile()
    {
        self::assertInstanceOf(Csv::class, $this->saleHeader);
        self::assertInstanceOf(Csv::class, $this->saleContents);
    }

    public function testReadRecordsMustReturnAnResultSetObject()
    {
        self::assertInstanceOf(ResultSet::class, $this->saleHeader->getRecords());
        self::assertInstanceOf(ResultSet::class, $this->saleContents->getRecords());
    }
}
