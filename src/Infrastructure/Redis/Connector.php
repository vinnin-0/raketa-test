<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Redis;

use Raketa\BackendTestTask\Config;
use Raketa\BackendTestTask\Infrastructure\Facade\ConnectorInterface;
use Redis;
use RedisException;

class Connector implements ConnectorInterface
{
    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     *
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->build();
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        $isConnected = $this->redis->isConnected();
        if (!$isConnected && $this->checkRead() && $this->checkWrite()) {
            $isConnected = $this->redis->connect(
                Config::REDIS_HOST,
                Config::REDIS_PORT,
            );
        }
        if (!$isConnected) {
            throw new \RuntimeException('Could not connect to Redis server.', 500);
        }

        $this->redis->auth(Config::REDIS_PASSWORD);
        $this->redis->select(Config::REDIS_DATABASE ?? 0);
    }

    /**
     * @return bool
     */
    public function checkRead(): bool
    {
        try {
            $this->redis->ping();
            return true;
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf('Redis read check failed: %s', $e->getMessage()), 500);
        }
    }

    /**
     * @throws \RuntimeException
     * @return bool
     */
    public function checkWrite(): bool
    {
        try {
            $key = 'health_check:1';
            $this->set($key, 'test', 60);
            $result = $this->get($key);
            $this->delete($key);
            if ($result === 'test') {
                return true;
            }
            throw new \RuntimeException('Redis write check failed: value is different', 500);
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf('Redis write check failed: %s', $e->getMessage()), 500);
        }
    }

    /**
     * @throws ConnectorException
     */
    public function get(string $key): string
    {
        try {
            $data = $this->redis->get($key);
        } catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }

        return $data;
    }

    /**
     * @param $key
     * @return bool
     * @throws ConnectorException
     */
    public function has($key): bool
    {
        try {
            $exist = $this->redis->exists($key);
        }catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }
        return $exist;
    }

    /**
     * @throws ConnectorException
     */
    public function set(string $key, $value, int $ttl = 0): bool
    {
        try {
            $this->redis->setex($key, $ttl, $value);
        } catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }

        return true;
    }

    /**
     * @throws ConnectorException
     */
    public function delete(string $key): bool
    {
        try {
            $this->redis->del($key);
        } catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }

        return true;
    }
}
