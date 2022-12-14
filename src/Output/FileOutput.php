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
use Sebk\SmallLogger\Output\Config\FileOutputConfig;

class FileOutput implements OutputInterface
{

    protected FileOutputConfig $outputConfig;

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws OutputConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof FileOutputConfig) {
            throw new OutputConfigException('Config must be a \'' . FileOutputConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    /**
     * Write message in file
     * @param string $message
     * @return $this
     */
    public function write(string $message): FileOutput
    {
        $f = fopen($this->outputConfig->getFilename(), 'a');
        fwrite($f, $message . "\n");
        fclose($f);

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