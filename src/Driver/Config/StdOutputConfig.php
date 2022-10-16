<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Driver\Config;

use Sebk\SmallLogger\Contracts\DriverConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;

class StdOutputConfig implements OutputConfigInterface
{

    public function __construct(protected string $output)
    {
        if (!in_array($this->output, [STDOUT, STDERR])) {
            throw new DriverConfigException('The output parameter must be \'STDOUT\' or \'STDERR\'');
        }
    }

    public function getOutput(): string
    {
        return $this->output;
    }

}