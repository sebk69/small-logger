<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Log;

use Sebk\SmallLogger\Contracts\LogInterface;

class BasicLog implements LogInterface, \JsonSerializable
{

    public function __construct(
        protected \DateTime $dateTime,
        protected string $level,
        protected string $message,
    ) {}

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
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public function jsonSerialize()
    {
        return [
            'date' => $this->getDateTime(),
            'level' => $this->getLevel(),
            'message' => $this->getMessage(),
        ];
    }
}