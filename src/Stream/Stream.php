<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Stream;

use Sebk\SmallLogger\Contracts\FormatterInterface;
use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\StreamInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;

class Stream implements StreamInterface
{

    public function __construct(protected FormatterInterface $formatter, protected OutputInterface $output) {}

    /**
     * Write log
     * @param LogInterface $log
     * @return StreamInterface
     */
    public function write(LogInterface $log): StreamInterface
    {
        $this->output->write($this->formatter->format($log));

        return $this;
    }

    /**
     * Set formatter
     * @param FormatterInterface $formatter
     * @return StreamInterface
     */
    public function setFormatter(FormatterInterface $formatter): StreamInterface
    {
        $this->setFormatter($formatter);

        return $this;
    }

    /**
     * Set output
     * @param OutputInterface $output
     * @return StreamInterface
     */
    public function setOutput(OutputInterface $output): StreamInterface
    {
        $this->output = $output;

        return $this;
    }

}