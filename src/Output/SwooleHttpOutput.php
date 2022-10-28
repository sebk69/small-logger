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
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Swoole\Coroutine;
use Swoole\Coroutine\Http\Client;

class SwooleHttpOutput implements OutputInterface
{

    protected $outputConfig;

    /**
     * Return true if require dependencies are installed
     * @return bool
     */
    public static function checkCompatibility(): bool
    {
        return class_exists(Coroutine::class);
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

    /**
     * Write message to http service
     * @param string $message
     * @return OutputInterface
     */
    public function write(string $message): OutputInterface
    {
        if (Coroutine::getCid() == -1) {
            Coroutine\run(function () use ($message) {
                $this->write($message);
            });
        }

        Coroutine\go(function () use ($message) {
            $client = new Client($this->outputConfig->getHost(), $this->outputConfig->getPort(), $this->outputConfig->isSsl());

            $method = $this->outputConfig->getMethod();
            $client->$method($this->outputConfig->getUri(), [
                'body' => $message,
                'headers' => $this->outputConfig->getHeaders(),
            ]);
        });

        return $this;
    }


}