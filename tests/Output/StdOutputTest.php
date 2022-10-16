<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Output;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Output\Config\FileOutputConfig;
use Sebk\SmallLogger\Output\Config\StdOutputConfig;
use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Sebk\SmallLogger\Output\OutputFactory;
use Sebk\SmallLogger\Output\StdOutput;

class StdOutputTest extends TestCase
{

    public function testCalls()
    {

        $stdout = (new StdOutput())
            ->setConfig(new StdOutputConfig(STDOUT));
        $stderr = (new StdOutput())
            ->setConfig(new StdOutputConfig(STDERR));

        // Test compatibility
        self::assertTrue($stdout::checkCompatibility());
        self::assertTrue($stderr::checkCompatibility());

        // Test write don't fail on stdout
        $stdout->write('This is an stdout message');

        // Test write don't fail on stderr
        $stderr->write('This is an stderr message');

    }

    public function testFailure()
    {

        $this->expectException(OutputConfigException::class);

        (new StdOutput())
            ->setConfig(new FileOutputConfig('/tmp/test.log'));

    }

}