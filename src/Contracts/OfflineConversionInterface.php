<?php

namespace Acme\Contracts;

use Facebook\FacebookResponse;

interface OfflineConversionInterface
{
    public function sendRequest(): void;

    public function getResponse(): FacebookResponse;
}
