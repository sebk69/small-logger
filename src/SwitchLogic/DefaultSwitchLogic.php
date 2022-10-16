<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\SwitchLogic;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\StreamInterface;
use Sebk\SmallLogger\Contracts\SwitchLogicInterface;
use Sebk\SmallLogger\Output\Config\StdOutputConfig;
use Sebk\SmallLogger\Output\StdOutput;
use Sebk\SmallLogger\Formatter\BasicLogTextFormatter;
use Sebk\SmallLogger\Stream\Stream;

class DefaultSwitchLogic implements SwitchLogicInterface
{

    protected Stream $streamStdOut;
    protected Stream $streamStdErr;

    public function __construct()
    {
        $this->streamStdOut = new Stream(new BasicLogTextFormatter(), new StdOutput(new StdOutputConfig(STDOUT)));
        $this->streamStdErr = new Stream(new BasicLogTextFormatter(), new StdOutput(new StdOutputConfig(STDERR)));
    }

    /**
     * @param LogInterface $log
     * @param array $data
     * @return StreamInterface
     */
    public function getStream(LogInterface $log, array $data = []): StreamInterface
    {
        if (in_array($log->getLevel(), LogInterface::ERR_LEVEL_ERROR, LogInterface::ERR_LEVEL_CRITICAL)) {
            return $this->streamStdErr;
        }

        return $this->streamStdOut;
    }

}