<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Formatter;

use Sebk\SmallLogger\Contracts\FormatterInterface;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Formatter\Exception\FormatterException;
use Sebk\SmallLogger\Log\BasicLog;

class BasicLogTextFormatter implements FormatterInterface
{

    const SEPARATOR = '|';

    /**
     * Format BasicLog log to standard string
     * @param BasicLog $log
     * @return string
     */
    public function format(LogInterface $log): mixed
    {
        if (!$log instanceof BasicLog) {
            throw new FormatterException(static::class . ' can format only ' . LogInterface::class . ' class that implements ' . BasicLog::class);
        }

        return $log->getDateTime()->format(\DateTime::ATOM) . 'Z' . static::SEPARATOR . $log->getLevel() . static::SEPARATOR . $log->getMessage();
    }

}