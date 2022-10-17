<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Formatter;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Formatter\CommonLogFormatter;
use Sebk\SmallLogger\Log\CommonLog;

class CommonLogFormatterTest extends TestCase
{

    public function testFormatter()
    {

        $testLog = new CommonLog(
            $level = LogInterface::ERR_LEVEL_ERROR,
            $ip = '127.0.0.1',
            $userId = 'sebk',
            $method = CommonLog::METHOD_GET,
            $uri = '/test/12.html',
            $protocol = 'HTTP 1.0',
            $status = 200,
            $size = 256
        );

        $formatter = new CommonLogFormatter();
        $text = $formatter->format($testLog);

        $this->assertEquals(
            '127.0.0.1 - sebk [' .
            strftime('%d/%b/%Y:%H:%M:%S %z', $testLog->getDateTime()->getTimestamp()) . '] GET /test/12.html HTTP 1.0 200 256',
            $text
        );

    }

}