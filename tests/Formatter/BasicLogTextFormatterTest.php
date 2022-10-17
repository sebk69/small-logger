<?php

namespace Sebk\SmallLogger\Test\Formatter;

use PHPUnit\Framework\TestCase;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Formatter\BasicLogTextFormatter;
use Sebk\SmallLogger\Log\BasicLog;

class BasicLogTextFormatterTest extends TestCase
{

    public function testFormatter()
    {

        $testLog = new BasicLog(
            $date = \DateTime::createFromFormat('Y-m-d H:i:s',  '1976-05-02 20:41:27'),
            $level = LogInterface::ERR_LEVEL_ERROR,
            $message = 'This is a test'
        );

        $formatter = new BasicLogTextFormatter();
        $text = $formatter->format($testLog);

        $this->assertEquals(
            '1976-05-02T20:41:27+00:00Z|ERROR|This is a test',
            $text
        );

    }

}