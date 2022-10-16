<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output\Config;

use Sebk\SmallLogger\Contracts\OutputConfigInterface;

class FileOutputConfig implements OutputConfigInterface
{

    public function __construct(protected string $filename) {}

    /**
     * Get filename
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}