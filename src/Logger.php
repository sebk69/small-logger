<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\SwitchLogicInterface;

class Logger
{

    protected static SwitchLogicInterface $switchLogic;

    public static function setSwitchLogic(SwitchLogicInterface $switchLogic): void
    {
        static::$switchLogic = $switchLogic;
    }

    public static function log(LogInterface $log)
    {
        static::$switchLogic->getStream()->write($log);
    }

}