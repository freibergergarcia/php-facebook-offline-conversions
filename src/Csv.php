<?php

namespace Acme;

use Acme\Contracts\DataSourceInterface;
use League\Csv\AbstractCsv;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\ResultSet;
use League\Csv\Statement;

class Csv implements DataSourceInterface
{
    /**
     * @var AbstractCsv
     */
    private $csv;

    /**
     * @var array
     */
    private $header;

    /**
     * @var ResultSet
     */
    private $records;

    public function __construct(string $filePath)
    {
        $this->csv = Reader::createFromPath($filePath, 'r');
    }

    /**
     * @return $this
     */
    public function readHeader()
    {
        $this->csv->setHeaderOffset(0);
        $this->header = $this->csv->getHeader();

        return $this;
    }

    /**
     * @param int $offset
     * @param int $limit
     */
    public function readRecords(int $offset, int $limit)
    {
        try {
            $stmt = (new Statement())
                ->offset($offset)
                ->limit($limit);

            $this->records = $stmt->process($this->csv);
        } catch (Exception $e) {
            echo "Something went wrong: " . $e->getMessage();
        }
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return ResultSet
     */
    public function getRecords(): ResultSet
    {
        return $this->records;
    }
}
