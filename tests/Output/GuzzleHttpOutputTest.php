<?php

namespace Sebk\SmallLogger\Test\Output;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Sebk\SmallLogger\Output\GuzzleHttpOutput;

class GuzzleHttpOutputTest extends TestCase
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

        $httpOutput = (new GuzzleHttpOutput())
            ->setConfig($config);

        // Test compatibility
        self::assertTrue($httpOutput::checkCompatibility());

        // Test write
        $client = $this->getMockBuilder(Client::class)
            ->getMock()
        ;
        $client
            ->method('post')
            ->willReturn(new Response(200))
        ;

        $httpOutput = $this->getMockBuilder(GuzzleHttpOutput::class)
            ->onlyMethods(['getClient'])
            ->getMock()
        ;
        $httpOutput->setConfig($config);
        $httpOutput->method('getClient')
            ->willReturn($client);

        $httpOutput->write($message = 'This is an stdout message', $client);
    }

}