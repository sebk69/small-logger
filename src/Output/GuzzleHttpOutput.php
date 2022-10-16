<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output;

use GuzzleHttp\Client;
use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;
use Sebk\SmallLogger\Output\Config\HttpConfig;

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
     * @throws OutputConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof HttpConfig) {
            throw new OutputConfigException('Config must be a \'' . HttpConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    protected function getClient(): Client
    {
        return new Client([
            'base_uri' => ($this->outputConfig->isSsl() ? 'https://' : 'http://') .
                $this->outputConfig->getHost() .
                ($this->outputConfig->getPort() != 80 ? ':' . $this->outputConfig->getPort() : '')
        ]);
    }

    /**
     * Write message to http service
     * @param string $message
     * @return OutputInterface
     */
    public function write(string $message, $client = null): OutputInterface
    {
        $method = $this->outputConfig->getMethod();
        $this->getClient()->$method($this->outputConfig->getUri(), [
            'body' => $message,
            'headers' => $this->outputConfig->getHeaders(),
        ]);

        return $this;
    }


}