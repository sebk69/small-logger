<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output;

use Sebk\SmallLogger\Contracts\OutputConfigInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;
use Sebk\SmallLogger\Output\Exception\OutputException;

class OutputFactory
{

    /**
     * List of driver classes by type ordered by priority
     */
    protected static $driversByType = [
        'std' => [StdOutput::class],
        'file' => [FileOutput::class],
        'http' => [SwooleHttpOutput::class, GuzzleHttpOutput::class]
    ];

    /**
     * Add a driver class
     * @param string $type
     * @param string $class
     * @return void
     * @throws OutputException
     */
    public static function addOutput(string $type, string $class)
    {
        if (!class_exists($class)) {
            throw new OutputException('Output class ' . $class . ' does not exists !');
        }

        if (!class_implements($class)) {
            throw new OutputException('Output class must implements ' . OutputInterface::class);
        }

        if (!array_key_exists($type, self::$driversByType)) {
            self::$driversByType[$type] = [];
        }

        self::$driversByType[$type][] = $class;
    }

    /**
     * Get a driver object
     * @param string $type
     * @param OutputConfigInterface $config
     * @return OutputInterface
     * @throws OutputException
     */
    public static function get(string $type, OutputConfigInterface $config): OutputInterface
    {
        if (!array_key_exists($type, self::$driversByType)) {
            throw new OutputException('There is no output class for type \'' . $type . '\'');
        }

        foreach (self::$driversByType[$type] as $driverClass) {
            try {
                $driver = new $driverClass();
                if ($driver->checkCompatibility()) {
                    return $driver->setConfig($config);
                }
            } catch (\Exception $e) {}
        }

        throw new OutputException('Can\'t get compatible output class for ' . $type . ' with this config');
    }

}