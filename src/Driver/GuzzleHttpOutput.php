<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Driver;

use Guzzle\Http\Client;
use Sebk\SmallLogger\Driver\Exception\DriverConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;
use Sebk\SmallLogger\Driver\Config\HttpConfig;

class GuzzleHttpOutput implements OutputInterface
{

    protected HttpConfig $outputConfig;

    /**
     * Return true if require dependencies are installed
     * @return bool
     */
    public static function checkCompatibility(): bool
    {
        return class_exists(Client::class);
    }

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws DriverConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof HttpConfig) {
            throw new DriverConfigException('Config must be a \'' . HttpConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    /**
     * Write message to http service
     * @param string $message
     * @return OutputInterface
     */
    public function write(string $message): OutputInterface
    {
        $client = new Client([
            'base_uri' => ($this->outputConfig->isSsl() ? 'https://' : 'http://') . $this->outputConfig->getHost()
        ]);

        $method = $this->outputConfig->getMethod();
        $client->$method($this->outputConfig->getUri(), [
            'body' => $message,
            'headers' => $this->outputConfig->getHeaders(),
        ]);

        return $this;
    }


}