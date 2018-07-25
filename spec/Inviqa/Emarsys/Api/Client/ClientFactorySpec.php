<?php

namespace spec\Inviqa\Emarsys\Api\Client;

use Inviqa\Emarsys\Api\Client\AuthenticationHeaderProvider;
use Inviqa\Emarsys\Api\Client\HttpClient;
use Inviqa\Emarsys\Api\Configuration;
use PhpSpec\ObjectBehavior;
use test\Inviqa\Emarsys\TestClient;

class ClientFactorySpec extends ObjectBehavior
{
    function let(AuthenticationHeaderProvider $authenticationHeaderProvider, Configuration $configuration)
    {
        $this->beConstructedWith($authenticationHeaderProvider, $configuration);
    }

    function it_builds_a_test_client_when_is_test_mode_is_enabled(Configuration $configuration)
    {
        $configuration->isTestMode()->willReturn(true);

        $this->buildClient()->shouldBeAnInstanceOf(TestClient::class);
    }

    function it_builds_an_http_client_when_is_test_mode_is_disabled(Configuration $configuration)
    {
        $configuration->isTestMode()->willReturn(false);
        $configuration->getEndpointUrl()->willReturn('');
        $configuration->getSalesEndpointUrl()->willReturn('');

        $this->buildClient()->shouldBeAnInstanceOf(HttpClient::class);
    }
}
