<?php

/**
 * This file is a part of small-logger
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLogger\Output\Config;

use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Sebk\SmallLogger\Contracts\OutputConfigInterface;

class HttpConfig implements OutputConfigInterface
{

    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';

    /** Header keys */
    const HTTP_HEADER_AUTHORIZATION = 'Authorization';
    const HTTP_HEADER_CONTENT_TYPE = 'Content-Type';

    /** Header values */
    const HTTP_HEADER_TEXT_PLAIN = 'text/plain';
    const HTTP_HEADER_APPLICATION_JSON = 'application/json';
    const HTTP_HEADER_APPLICATION_XML = 'application/xml';

    public function __construct(
        protected string $host,
        protected int $port,
        protected bool $ssl,
        protected string $method = self::POST,
        protected string $uri = '/',
        protected array $hearders = []
    ) {
        if (!in_array($this->method, [static::GET, static::POST, static::PUT, static::DELETE])) {
            throw new OutputConfigException('Invalid method');
        }
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
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
     * Get all headers as array
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->hearders;
    }

    /**
     * Add a header
     * @param string $key
     * @param string $value
     * @return HttpConfig
     */
    public function addHeader(string $key, string $value): HttpConfig
    {
        $this->hearders[$key] = $value;

        return $this;
    }

    /**
     * Set content type to json
     * @return $this
     */
    public function setContentTypeJson(): HttpConfig
    {
        $this->hearders[static::HTTP_HEADER_CONTENT_TYPE] = static::HTTP_HEADER_APPLICATION_JSON;

        return $this;
    }

    /**
     * Set content type to text
     * @return $this
     */
    public function setContentTypeText(): HttpConfig
    {
        $this->hearders[static::HTTP_HEADER_CONTENT_TYPE] = static::HTTP_HEADER_TEXT_PLAIN;

        return $this;
    }

    /**
     * Set content type to xml
     * @return $this
     */
    public function setContentTypeXml(): HttpConfig
    {
        $this->hearders[static::HTTP_HEADER_CONTENT_TYPE] = static::HTTP_HEADER_APPLICATION_XML;

        return $this;
    }

    /**
     * Set authorization header
     * @param string $value
     * @return HttpConfig
     */
    public function setAuthorization(string $value): HttpConfig
    {
        $this->hearders[static::HTTP_HEADER_AUTHORIZATION] = $value;

        return $this;
    }

}