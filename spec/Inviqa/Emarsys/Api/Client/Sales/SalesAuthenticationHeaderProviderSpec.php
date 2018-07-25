<?php

namespace spec\Inviqa\Emarsys\Api\Client\Sales;

use Inviqa\Emarsys\Api\Client\Sales\SalesConfiguration;
use PhpSpec\ObjectBehavior;

class SalesAuthenticationHeaderProviderSpec extends ObjectBehavior
{
    private const BEARER_TOKEN = 'AsdfasdFSAFDAwet32tqweG#';

    function let(SalesConfiguration $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_builds_an_authentication_header(SalesConfiguration $configuration)
    {
        $configuration->getBearerToken()->willReturn(self::BEARER_TOKEN);

        $authHeader = sprintf(
            'Authorization: Bearer %s',
            self::BEARER_TOKEN
        );

        $this->providerAuthenticationHeader()->shouldBe($authHeader);
    }
}
