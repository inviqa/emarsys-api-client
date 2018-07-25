<?php

namespace Inviqa\Emarsys\Api;

interface Configuration
{
    public function isTestMode(): bool;

    public function getEndpointUrl(): string;

    public function getSalesEndpointUrl(): string;

    public function getUsername(): string;

    public function getSecret(): string;

    public function getBearerToken(): string;

    public function getMerchantCode(): string;
}
