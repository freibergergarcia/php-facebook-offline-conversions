<?php

namespace Acme\Contracts;

use Facebook\FacebookResponse;

interface OfflineConversionInterface
{
    public function post(): void;

    /**
     * @param string $eventDataSetId
     */
    public function delete(string $eventDataSetId): void;

    /**
     * @return FacebookResponse
     */
    public function getResponse(): FacebookResponse;
}
