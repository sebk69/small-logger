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

    public function testGetters()
    {
        // Create BasicLog
        $date = new \DateTime();
        $level = LogInterface::ERR_LEVEL_ERROR;
        $ip = '127.0.0.1';
        $userId = 'sebk';
        $method = CommonLog::METHOD_GET;
        $uri = '/test/12.html';
        $httpProtocol = 'HTTP 1.0';
        $httpStatus = 200;
        $sizeInBytes = 256;

        $testLog = new CommonLog($date, $level, $ip, $userId, $method, $uri, $httpProtocol, $httpStatus, $sizeInBytes);

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