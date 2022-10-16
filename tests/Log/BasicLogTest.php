<?php declare(strict_types=1);

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Log;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Log\BasicLog;

class BasicLogTest extends TestCase
{

    public function testGetters(): void
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

        // Assert date
        $this->assertEquals(
            $date,
            $testLog->getDateTime()->format('Y-m-d H:i:s')
        );

        // Assert level
        $this->assertEquals(
            $level,
            $testLog->getLevel()
        );

        // Assert message
        $this->assertEquals(
            $message,
            $testLog->getMessage()
        );
    }

    public function testSerialization(): void
    {
        // Create BasicLog
        $date = '1976-05-02 20:41:27';
        $level = LogInterface::ERR_LEVEL_CRITICAL;
        $message = 'This is a basic log test';

        $testLog = new \Sebk\SmallLogger\Log\BasicLog(
            \DateTime::createFromFormat('Y-m-d H:i:s', $date),
            $level,
            $message
        );

        // Create array from serialization
        $data = json_decode(json_encode($testLog), true);

        // Check keys
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('level', $data);
        $this->assertArrayHasKey('message', $data);

        // Check number of keys
        $this->assertEquals(3, count($data));

        // Check values
        $this->assertEquals($data['date']['date'], \DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s.u'));
        $this->assertEquals($data['level'], $level);
        $this->assertEquals($data['message'], $message);
    }

    public function testLevels(): void
    {
        $this->assertEquals(LogInterface::ERR_LEVEL_DEPRECATED, 'DEPRECATED');
        $this->assertEquals(LogInterface::ERR_LEVEL_INFO, 'INFO');
        $this->assertEquals(LogInterface::ERR_LEVEL_ERROR, 'ERROR');
        $this->assertEquals(LogInterface::ERR_LEVEL_CRITICAL, 'CRITICAL');
    }

}