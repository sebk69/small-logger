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
use Sebk\SmallLogger\Output\FileOutput;
use Sebk\SmallLogger\Output\OutputFactory;
use Sebk\SmallLogger\Output\StdOutput;

class FileOutputTest extends TestCase
{

    public function testCalls()
    {
        $filename = '/tmp/test.log';

        // Test config
        $config = new FileOutputConfig($filename);

        $this->assertEquals(
            $filename,
            $config->getFilename()
        );

        $fileOutput = (new FileOutput())
            ->setConfig($config);

        // Test compatibility
        self::assertTrue($fileOutput::checkCompatibility());

        // Test write
        if (file_exists($filename)) {
            unlink($filename);
        }

        $fileOutput->write($message = 'This is an stdout message');

        $this->assertEquals(
            $message . "\n",
            file_get_contents($filename)
        );
    }

}