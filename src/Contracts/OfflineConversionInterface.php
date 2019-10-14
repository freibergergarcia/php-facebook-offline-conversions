<?php

namespace Acme\Contracts;

use Facebook\FacebookResponse;

interface OfflineConversionInterface
{
    public function post(): void;

    public function delete(string $eventDataSetId): void;

    public function getResponse(): FacebookResponse;
}
