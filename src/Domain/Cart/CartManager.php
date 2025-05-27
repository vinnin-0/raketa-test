<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Cart;

use http\Exception\RuntimeException;
use Raketa\BackendTestTask\Domain\Cart\Model\Cart;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;
use Raketa\BackendTestTask\Infrastructure\Facade\ConnectorFacade;
use Raketa\BackendTestTask\Infrastructure\Redis\Connector;
use Raketa\BackendTestTask\Infrastructure\Redis\ConnectorException;

class CartManager
{

    private const CART_PREFIX = 'cart:';
    private const CART_TTL = 24 * 60 * 60; //24ч

    private ConnectorFacade $storage;

    public function __construct()
    {
        $this->storage = ConnectorFacade::getInstance('redis');
    }

    /**
     */
    public function saveCart(Cart $cart): void
    {
        $serializedCart = serialize($cart);
        $this->storage->set($this->makeKey(), $serializedCart, self::CART_TTL);
    }

    /**
     * @return Cart
     * @throws ConnectorException,
     * @throws \RuntimeException
     * @throws NotFoundException
     */
    public function getCart(): Cart
    {
        $value = $this->storage->get($this->makeKey());
        if (!$value) {
            throw new NotFoundException(sprintf('Cart not found for uuid %s', $this->makeKey()));
        }

        $cart = unserialize($value);
        if (!($cart instanceof Cart)) {
            throw new RuntimeException(sprintf('Cart is not valid: %s', $value), 500);
        }

        return $cart;
    }

    public function createCart(): Cart
    {
        // тут логика как заводятся покупатели и корзины
        return new Cart();
    }

    private function makeKey(): string
    {
        return sprintf('%s%s', self::CART_PREFIX, session_id());
    }
}
