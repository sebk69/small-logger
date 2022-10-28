<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\SwitchLogic;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\StreamInterface;
use Sebk\SmallLogger\Output\Config\FileOutputConfig;
use Sebk\SmallLogger\Output\OutputFactory;
use Sebk\SmallLogger\Formatter\BasicLogTextFormatter;
use Sebk\SmallLogger\Stream\Stream;

class DefaultFileSwitchLogic
{

    protected $streamLogs;
    protected $streamErrors;

    public function __construct(string $logFilename, string $errorFilename = null)
    {
        // Redirect errors to first file if none given
        if ($errorFilename == null) {
            $errorFilename = $logFilename;
        }

        // Create streams
        $this->streamLogs = new Stream(new BasicLogTextFormatter(), OutputFactory::get('file', new FileOutputConfig($logFilename)));
        $this->streamErrors = new Stream(new BasicLogTextFormatter(), OutputFactory::get('file', new FileOutputConfig($errorFilename)));
    }

    /**
     * Get stream for log
     * @param LogInterface $log
     * @param array $data
     * @return StreamInterface
     */
    public function getStream(LogInterface $log, array $data = []): StreamInterface
    {
        if (in_array($log->getLevel(), [LogInterface::ERR_LEVEL_ERROR, LogInterface::ERR_LEVEL_CRITICAL])) {
            return $this->streamErrors;
        }

        return $this->streamLogs;
    }

}