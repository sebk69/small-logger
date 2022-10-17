<?php declare(strict_types=1);

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Log;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Log\CommonLog;

class CommonLogTest extends TestCase
{

    public function testGetters(): void
    {
        // Create BasicLog
        $testLog = new CommonLog(
            $date = new \DateTime(),
            $level = LogInterface::ERR_LEVEL_CRITICAL,
            $ip = '127.0.0.0',
            $userId = 'sebk',
            $method = 'GET',
            $uri = 'app/test.html',
            $httpProtocol = 'HTTP 1.0',
            $httpStatus = 200,
            $sizeInBytes = 128,
        );

        // Assert date
        $this->assertEquals(
            $date->format('Y-m-d H:i:s'),
            $testLog->getDateTime()->format('Y-m-d H:i:s')
        );

        // Assert ip
        $this->assertEquals(
            $ip,
            $testLog->getIp()
        );

        // Assert level
        $this->assertEquals(
            $level,
            $testLog->getLevel()
        );

        // Assert userId
        $this->assertEquals(
            $userId,
            $testLog->getUserId()
        );

        // Assert level
        $this->assertEquals(
            $method,
            $testLog->getMethod()
        );

        // Assert level
        $this->assertEquals(
            $uri,
            $testLog->getUri()
        );

        // Assert level
        $this->assertEquals(
            $httpProtocol,
            $testLog->getHttpProtocol()
        );

        // Assert level
        $this->assertEquals(
            $httpStatus,
            $testLog->getHttpStatus()
        );

        $this->assertEquals(
            $sizeInBytes,
            $testLog->getSizeInBytes()
        );
    }

}