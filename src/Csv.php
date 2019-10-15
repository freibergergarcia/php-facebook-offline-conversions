<?php

declare(strict_types=1);

namespace Acme;

use Acme\Contracts\DataSourceInterface;
use CallbackFilterIterator;
use League\Csv\AbstractCsv;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\ResultSet;
use League\Csv\Statement;

final class Csv implements DataSourceInterface
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

    /**
     * Csv constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->csv = Reader::createFromPath($filePath, 'r');
    }

    /**
     * @return CallbackFilterIterator
     */
    public function getCsv(): CallbackFilterIterator
    {
        return $this->csv->getRecords();
    }

    /**
     * @return Csv
     */
    public function readHeader(): Csv
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
    public function getHeader()
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
