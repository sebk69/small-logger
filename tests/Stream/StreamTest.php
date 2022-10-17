<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Stream;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Formatter\BasicLogTextFormatter;
use Sebk\SmallLogger\Log\BasicLog;
use Sebk\SmallLogger\Output\Config\FileOutputConfig;
use Sebk\SmallLogger\Output\Config\StdOutputConfig;
use Sebk\SmallLogger\Output\FileOutput;
use Sebk\SmallLogger\Output\StdOutput;
use Sebk\SmallLogger\Stream\Stream;
use function PHPUnit\Framework\assertEquals;

class StreamTest extends TestCase
{

    public function testStream()
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

        $filename = '/tmp/test.log';
        if (file_exists($filename)) {
            unlink($filename);
        }
        $stream = new Stream(new BasicLogTextFormatter(), (new FileOutput())->setConfig(new FileOutputConfig($filename)));

        $stream->write($testLog);
        $text = file_get_contents($filename);

        $this->assertEquals("1976-05-02T20:41:27+00:00Z|CRITICAL|This is a basic log test\n", $text);

    }

}