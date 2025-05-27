<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Facade;

use Raketa\BackendTestTask\Infrastructure\Redis\Connector;
use Redis;

class ConnectorFacade
{
    /**
     * @var ConnectorFacade
     */
    protected static ConnectorFacade $instance;
    /**
     * @var ConnectorInterface
     */
    public ConnectorInterface $connector;

    /**
     * @param  ConnectorInterface  $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param  string  $driverType
     * @return ConnectorInterface
     */
    private static function createDriver(string $driverType): ConnectorInterface
    {
        return match (strtolower($driverType)) {
            'redis' => new Connector(),
            default => throw new \InvalidArgumentException("Unsupported cache driver: {$driverType}"),
        };
    }

    /**
     * @param  string  $driverType
     * @return self
     */
    public static function getInstance(string $driverType): self
    {
        if (self::$instance === null) {
            $driver = self::createDriver($driverType);
            self::$instance = new self($driver);
        }

        return self::$instance;
    }


    /**
     * @param  string  $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->connector->get($key);
    }

    /**
     * @param  string  $key
     * @param $value
     * @param  int  $ttl
     * @return bool
     */
    public function set(string $key, $value, int $ttl = 0): bool
    {
        return $this->connector->set($key, $value, $ttl);
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return $this->connector->delete($key);
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->connector->has($key);
    }
}
