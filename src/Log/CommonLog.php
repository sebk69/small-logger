<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Log;

use Sebk\SmallLogger\Contracts\LogInterface;

class CommonLog implements LogInterface
{

    protected \DateTime $dateTime;

    public function __construct(
        protected string $level,
        protected string $ip,
        protected string $userId,
        protected string $method,
        protected string $uri,
        protected string $httpProtocol,
        protected int $httpStatus,
        protected int $sizeInBytes
    ) {
        $this->dateTime = new \DateTime();
    }

    /**
     * Get level
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getHttpProtocol(): string
    {
        return $this->httpProtocol;
    }

    /**
     * @return string
     */
    public function getHttpStatus(): string
    {
        return $this->httpStatus;
    }

    /**
     * @return string
     */
    public function getSizeInBytes(): string
    {
        return $this->sizeInBytes;
    }

}