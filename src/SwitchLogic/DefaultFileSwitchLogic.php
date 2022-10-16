<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\SwitchLogic;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\StreamInterface;
use Sebk\SmallLogger\Driver\Config\FileOutputConfig;
use Sebk\SmallLogger\Driver\Config\StdOutputConfig;
use Sebk\SmallLogger\Driver\FileOutput;
use Sebk\SmallLogger\Driver\StdOutput;
use Sebk\SmallLogger\Formatter\BasicLogTextFormatter;
use Sebk\SmallLogger\Stream\Stream;

class DefaultFileSwitchLogic
{

    protected Stream $streamLogs;
    protected Stream $streamErrors;

    public function __construct(string $logFilename, string $errorFilename = null)
    {
        if ($errorFilename == null) {
            $errorFilename = $logFilename;
        }

        $this->streamLogs = new Stream(new BasicLogTextFormatter(), new FileOutput(new FileOutputConfig($logFilename)));
        $this->streamErrors = new Stream(new BasicLogTextFormatter(), new FileOutput(new FileOutputConfig($errorFilename)));
    }

    /**
     * @param LogInterface $log
     * @param array $data
     * @return StreamInterface
     */
    public function getStream(LogInterface $log, array $data = []): StreamInterface
    {
        if (in_array($log->getLevel(), LogInterface::ERR_LEVEL_ERROR, LogInterface::ERR_LEVEL_CRITICAL)) {
            return $this->streamErrors;
        }

        return $this->streamLogs;
    }

}