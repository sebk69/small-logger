<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output;

use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;
use Sebk\SmallLogger\Output\Config\StdOutputConfig;

class StdOutput implements OutputInterface
{

    protected StdOutputConfig $outputConfig;

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws OutputConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof StdOutputConfig) {
            throw new OutputConfigException('Config must be a \'' . StdOutputConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    /**
     * Write message in file
     * @param string $message
     * @return $this
     */
    public function write(string $message): StdOutput
    {
        fwrite($this->outputConfig->getOutput(), $message . "\n");

        return $this;
    }

    /**
     * No dependencies
     * @return bool
     */
    public static function checkCompatibility(): bool
    {
        return true;
    }

}