<?php

namespace Acme\Contracts;

interface DataSourceInterface
{
    /**
     * @return mixed
     */
    public function readHeader();

    /**
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function readRecords(int $offset, int $limit);

    /**
     * @return mixed
     */
    public function getHeader();

    /**
     * @return mixed
     */
    public function getRecords();
}
