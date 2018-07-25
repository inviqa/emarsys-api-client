<?php

namespace Inviqa\Emarsys\Api;

use Psr\Http\Message\ResponseInterface;

interface Client
{
    public function sendCSVContent(string $csvFileAbsolutePath): ResponseInterface;

    public function requestAccountSettings(): string;
}
