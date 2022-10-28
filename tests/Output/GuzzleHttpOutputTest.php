<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Output;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Sebk\SmallLogger\Output\GuzzleHttpOutput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

        self::assertTrue(is_array($config->getHeaders()));

        $httpOutput = (new GuzzleHttpOutput())
            ->setConfig($config);

        // Test compatibility
        self::assertTrue($httpOutput::checkCompatibility());
    }

}