<?php

namespace Sebk\SmallLogger\Test\Output;

use Guzzle\Http\Client;
use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Sebk\SmallLogger\Output\GuzzleHttpOutput;
use Sebk\SmallLogger\Output\SwooleHttpOutput;

class SwooleHttpOutputTest extends TestCase
{

    public function testCalls()
    {
        // Test config
        $config = new HttpConfig($host = 'test.fr', $port = 8080, $ssl = true);

        $this->assertEquals(
            $host,
            $config->getHost()
        );

        $this->assertEquals(
            $port,
            $config->getPort()
        );

        $this->assertEquals(
            $ssl,
            $config->isSsl()
        );

        $this->assertEquals(
            HttpConfig::POST,
            $config->getMethod()
        );

        $this->assertEquals(
            '/',
            $config->getUri()
        );

        $this->assertIsArray($config->getHeaders());

        $httpOutput = (new SwooleHttpOutput())
            ->setConfig($config);

        // Test compatibility
        self::assertTrue($httpOutput::checkCompatibility());

        // Test write
        $httpOutput->write($message = 'This is an stdout message');
    }

}