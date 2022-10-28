<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output\Config;

use Sebk\SmallLogger\Contracts\OutputConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;

class StdOutputConfig implements OutputConfigInterface
{

    protected $output;

    public function __construct($output)
    {
        $this->output = $output;
        
        if (!in_array($this->output, [STDOUT, STDERR])) {
            throw new OutputConfigException('The output parameter must be \'STDOUT\' or \'STDERR\'');
        }
    }

    public function getOutput()
    {
        return $this->output;
    }

}