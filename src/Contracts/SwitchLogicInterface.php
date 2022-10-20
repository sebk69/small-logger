<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Contracts;

interface SwitchLogicInterface
{

    /**
     * Return stream from log to write and optional non logged data
     * @param LogInterface $log
     * @param array $data
     * @return StreamInterface
     */
    public function getStream(LogInterface $log, array $data = []): StreamInterface;

}