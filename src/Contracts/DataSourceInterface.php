<?php

namespace Acme\Contracts;

interface DataSourceInterface
{
    public function readHeader();

    public function readRecords(int $offset, int $limit);

    public function getHeader();

    public function getRecords();
}
