<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\SwitchLogic;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Log\BasicLog;
use Sebk\SmallLogger\Stream\Stream;
use Sebk\SmallLogger\SwitchLogic\DefaultFileSwitchLogic;
use Sebk\SmallLogger\SwitchLogic\DefaultSwitchLogic;

class DefaultFileSwitchLogicTest extends TestCase
{

    public function testSwitch()
    {
        // Create switch
        $filename = '/tmp/test.log';
        $filenameError = '/tmp/test.error.log';
        if (file_exists($filename)) {
            unlink($filename);
        }
        if (file_exists($filenameError)) {
            unlink($filenameError);
        }
        $switch = new DefaultFileSwitchLogic($filename, $filenameError);

        // Create BasicLog
        $date = '1976-05-02 20:41:27';
        $level = LogInterface::ERR_LEVEL_INFO;
        $message = 'This is a basic log test';

        $testLog = new BasicLog(
            \DateTime::createFromFormat('Y-m-d H:i:s', $date),
            $level,
            $message
        );

        // Get stream
        $stream = $switch->getStream($testLog, ['data' => 'some data']);
        $stream->write($testLog);

        // Create BasicLog
        $date = '1976-05-02 20:41:27';
        $level = LogInterface::ERR_LEVEL_ERROR;
        $message = 'This is a basic log test';

        $testLog = new BasicLog(
            \DateTime::createFromFormat('Y-m-d H:i:s', $date),
            $level,
            $message
        );

        // Get stream
        $stream = $switch->getStream($testLog, ['data' => 'some data']);
        $stream->write($testLog);

        // asserts
        $this->assertInstanceOf(Stream::class, $stream);
        $this->assertEquals("1976-05-02T20:41:27+00:00Z|INFO|This is a basic log test\n", file_get_contents($filename));
        $this->assertEquals("1976-05-02T20:41:27+00:00Z|ERROR|This is a basic log test\n", file_get_contents($filenameError));
    }

}