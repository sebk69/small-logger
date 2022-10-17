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
use Sebk\SmallLogger\SwitchLogic\DefaultSwitchLogic;
use function PHPUnit\Framework\assertEquals;

class DefaultSwitchLogicTest extends TestCase
{

    public function testSwitch()
    {

        // Create switch
        $switch = new DefaultSwitchLogic();

        // Create BasicLog
        $date = '1976-05-02 20:41:27';
        $level = LogInterface::ERR_LEVEL_CRITICAL;
        $message = 'This is a basic log test';

        $testLog = new BasicLog(
            \DateTime::createFromFormat('Y-m-d H:i:s', $date),
            $level,
            $message
        );

        // Get stream
        $stream = $switch->getStream($testLog, ['data' => 'some data']);

        // asserts
        $this->assertInstanceOf(Stream::class, $stream);

    }

}