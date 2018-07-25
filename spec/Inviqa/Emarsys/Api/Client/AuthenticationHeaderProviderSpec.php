<?php

namespace spec\Inviqa\Emarsys\Api\Client;

use Inviqa\Emarsys\Api\Client\AuthenticationHeaderProvider;
use Inviqa\Emarsys\Api\Configuration;
use phpmock\prophecy\PHPProphet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthenticationHeaderProviderSpec extends ObjectBehavior
{
    const GMDATE = '2018-07-23T16:06:53+00:00';
    const RANDOM_BYTES = '010101010';
    const BIN2HEX = 'asdfa3rasd';
    const SECRET = "testSecret";
    const USER = "testUser";
    const BEARER_TOKEN = 'AsdfasdFSAFDAwet32tqweG#';

    function let(Configuration $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_builds_a_settings_authentication_header(Configuration $configuration)
    {
        $prophet = new PHPProphet();

        $gmdateMock = $prophet->prophesize('Inviqa\Emarsys\Api\Client');
        $gmdateMock->gmdate('c')->willReturn(self::GMDATE);
        $gmdateMock->reveal();

        $bin2hexMock = $prophet->prophesize('Inviqa\Emarsys\Api\Client');
        $bin2hexMock->bin2hex(Argument::any())->willReturn(self::BIN2HEX);
        $bin2hexMock->reveal();

        $configuration->getUsername()->willReturn(self::USER);
        $configuration->getSecret()->willReturn(self::SECRET);

        $passwordDigest = base64_encode(sha1(self::BIN2HEX. self::GMDATE . self::SECRET, false));

        $authHeader = sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            self::USER,
            $passwordDigest,
            self::BIN2HEX,
            self::GMDATE
        );

        $this->settingsAuthenticationHeader()->shouldBe($authHeader);
    }

    function it_builds_an_authentication_header(Configuration $configuration)
    {
        $configuration->getBearerToken()->willReturn(self::BEARER_TOKEN);

        $authHeader = sprintf(
            'Bearer %s',
            self::BEARER_TOKEN
        );

        $this->salesAuthenticationHeader()->shouldBe($authHeader);
    }
}
