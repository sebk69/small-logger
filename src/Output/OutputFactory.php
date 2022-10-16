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
    protected array $driversByType = [
        'std' => [StdOutput::class],
        'file' => [FileOutput::class],
        'http' => [SwooleHttpOutput::class, GuzzleHttpOutput::class]
    ];

    /**
     * Add a driver class
     * @param string $type
     * @param string $class
     * @return $this
     * @throws OutputException
     */
    public function addOutput(string $type, string $class): OutputFactory
    {
        if (!class_exists($class)) {
            throw new OutputException('Output class ' . $class . ' does not exists !');
        }

        if (!class_implements($class)) {
            throw new OutputException('Output class must implements ' . OutputInterface::class);
        }

        if (!array_key_exists($type, $this->driversByType)) {
            $this->driversByType[$type] = [];
        }

        $this->driversByType[$type][] = $class;

        return $this;
    }

    /**
     * Get a driver object
     * @param string $type
     * @param OutputConfigInterface $config
     * @return OutputInterface
     * @throws OutputException
     */
    public function get(string $type, OutputConfigInterface $config): OutputInterface
    {
        if (!array_key_exists($type, $this->driversByType)) {
            throw new OutputException('There is no output class for type \'' . $type . '\'');
        }

        foreach ($this->driversByType[$type] as $driverClass) {
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