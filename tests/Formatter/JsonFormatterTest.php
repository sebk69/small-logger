<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Formatter;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Formatter\JsonFormatter;
use Sebk\SmallLogger\Log\BasicLog;

class JsonFormatterTest extends TestCase
{

    public function testFormatter()
    {

        // Create BasicLog
        $date = '1976-05-02 20:41:27';
        $level = LogInterface::ERR_LEVEL_CRITICAL;
        $message = 'This is a basic log test';

        $testLog = new BasicLog(
            \DateTime::createFromFormat('Y-m-d H:i:s', $date),
            $level,
            $message
        );

        // Format
        $formatter = new JsonFormatter();
        $array = json_decode($formatter->format($testLog), true);

        // asserts
        self::assertIsArray($array);

        self::assertArrayHasKey('date', $array);
        self::assertArrayHasKey('level', $array);
        self::assertArrayHasKey('message', $array);

        self::assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s.u'), $array['date']['date']);
        self::assertEquals($level, $array['level']);
        self::assertEquals($message, $array['message']);
    }

}