<?php

namespace Raketa\BackendTestTask\Infrastructure\Facade;

use Raketa\BackendTestTask\Infrastructure\Redis\ConnectorException;

interface ConnectorInterface
{
    /**
     * @param  string  $key
     * @return mixed
     * @throws ConnectorException
     */
    public function get(string $key);

    /**
     * @param  string  $key
     * @param $value
     * @param  int  $ttl
     * @return bool
     * @throws ConnectorException
     */
    public function set(string $key, $value, int $ttl = 0): bool;

    /**
     * @param  string  $key
     * @return bool
     * @throws ConnectorException
     */
    public function delete(string $key): bool;

    /**
     * @param  string  $key
     * @return bool
     * @throws ConnectorException
     */
    public function has(string $key): bool;
}
