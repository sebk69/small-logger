<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Test\Output;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Output\Config\FileOutputConfig;
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Sebk\SmallLogger\Output\Config\StdOutputConfig;
use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Sebk\SmallLogger\Output\Exception\OutputException;
use Sebk\SmallLogger\Output\FileOutput;
use Sebk\SmallLogger\Output\OutputFactory;
use Sebk\SmallLogger\Output\StdOutput;
use Sebk\SmallLogger\Output\SwooleHttpOutput;

class OutputFactoryTest extends TestCase
{

    public function testTypes(): void
    {

        // Test standard output
        $stdout = (new OutputFactory())->get('std', new StdOutputConfig(STDOUT));

        $this->assertInstanceOf(
            StdOutput::class,
            $stdout
        );

        $this->assertTrue($stdout->checkCompatibility());

        // Test file output
        $file = (new OutputFactory())->get('file', new FileOutputConfig('/tmp/test.log'));

        $this->assertInstanceOf(
            FileOutput::class,
            $file
        );

        $this->assertTrue($file->checkCompatibility());


        // Test http output
        $http = (new OutputFactory())->get('http', new HttpConfig(
            'test.com',
            8080,
            true
        ));

        $this->assertInstanceOf(
            SwooleHttpOutput::class,
            $http
        );

        $this->assertTrue($http->checkCompatibility());

        // Test new type
        $factory = (new OutputFactory())->addOutput('test', SwooleHttpOutput::class);

        $http = $factory->get('test', new HttpConfig(
            'test.com',
            8080,
            true
        ));

        $this->assertInstanceOf(
            SwooleHttpOutput::class,
            $http
        );
    }

    public function testFailure()
    {

        $this->expectException(OutputException::class);

        (new OutputFactory())->get('test', new HttpConfig(
            'test.com',
            8080,
            true
        ));

    }

}