<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Contracts;

interface LogInterface
{
    const ERR_LEVEL_DEPRECATED = 'DEPRECATED';
    const ERR_LEVEL_INFO = 'INFO';
    const ERR_LEVEL_ERROR = 'ERROR';
    const ERR_LEVEL_CRITICAL = 'CRITICAL';

    /**
     * Get error level of log
     * @return string
     */
    public function getLevel(): string;

}