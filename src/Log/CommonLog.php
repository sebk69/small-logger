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

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTION = 'OPTION';

    protected $dateTime;
    protected $level;
    protected $ip;
    protected $userId;
    protected $method;
    protected $uri;
    protected $httpProtocol;
    protected $httpStatus;
    protected $sizeInBytes;

    public function __construct(
        \DateTime $dateTime,
        string $level,
        string $ip,
        string $userId,
        string $method,
        string $uri,
        string $httpProtocol,
        int $httpStatus,
        int $sizeInBytes
    ) {
        $this->dateTime = $dateTime;
        $this->level = $level;
        $this->ip = $ip;
        $this->userId = $userId;
        $this->method = $method;
        $this->uri = $uri;
        $this->httpProtocol = $httpProtocol;
        $this->httpStatus = $httpStatus;
        $this->sizeInBytes = $sizeInBytes;
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