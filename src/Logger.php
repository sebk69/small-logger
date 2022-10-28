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
    /** @var \Closure[] */
    protected static array $shortcuts = [];

    /**
     * Se
     * @param SwitchLogicInterface $switchLogic
     * @return void
     */
    public static function setSwitchLogic(SwitchLogicInterface $switchLogic)
    {
        static::$switchLogic = $switchLogic;
    }

    /**
     * Write log
     * @param LogInterface $log
     * @param array $data
     * @return void
     */
    public static function log(LogInterface $log, array $data = [])
    {
        static::$switchLogic->getStream($log, $data)->write($log);
    }

    /**
     * Register a shortcut
     * @param string $name
     * @param \Closure $closure
     * @return void
     */
    public static function registerShortcut(string $name, \Closure $closure)
    {
        static::$shortcuts[$name] = $closure;
    }

    /**
     * Call a shortcut
     * For example after calling :
     * Logger::registerShortcut('info', function(string $message) {
     *   Logger::log(new BassicLog(new \DateTime, LogInterface::ERR_LEVEL_INFO, $message));
     * }
     * All application can use shortcut :
     * Logger::info('This is an info message');
     * @param $name
     * @param $arguments
     * @return void
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (array_key_exists($name, self::$shortcuts)) {
            $closure = self::$shortcuts[$name];
            $closure(...$arguments);
        }
        
        throw new \Exception("Static method $name doesn't exists in class Logger. Do you have forget to register shortcut ?");
    }

}