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

    protected $filename;
    
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}