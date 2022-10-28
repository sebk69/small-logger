<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Contracts;

interface OutputInterface
{

    /**
     * Return true if require dependencies are installed
     * @return bool
     */
    public static function checkCompatibility(): bool;

    /**
     * Set output config
     * @param OutputConfigInterface $outputConfig
     * @return mixed
     */
    public function setConfig(OutputConfigInterface $outputConfig);

    /**
     * Write message to output
     * @param mixed $message
     * @return OutputInterface
     */
    public function write(string $message);

}