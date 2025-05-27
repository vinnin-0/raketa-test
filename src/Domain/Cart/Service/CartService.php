<?php

namespace Raketa\BackendTestTask\Domain\Cart\Service;

use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart\CartManager;
use Raketa\BackendTestTask\Domain\Cart\Model\Cart;
use Raketa\BackendTestTask\Domain\Cart\Model\CartItem;
use Raketa\BackendTestTask\Domain\Product\Model\Product;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;
use Raketa\BackendTestTask\Infrastructure\Redis\ConnectorException;
use Ramsey\Uuid\Uuid;

readonly class CartService
{
    public function __construct(private CartManager $manager, private LoggerInterface $logger)
    {
    }

    /**
     * @throws ConnectorException
     */
    public function addItem(Product $product, int $quantity): Cart
    {
        try {
            $cart = $this->manager->getCart();
            $item = new CartItem(
                Uuid::uuid4()->toString(),
                $product->getUuid(),
                $product->getPrice(),
                $quantity
            );
            $cart->addItem($item);
            $this->manager->saveCart($cart);
        } catch (ConnectorException $e) {
            throw new ConnectorException(sprintf('Redis connecting issues: %s', $e->getMessage()), 500, $e);
        } catch (\RuntimeException|NotFoundException $e) {
            $this->logger->info($e->getMessage(), $e->getTrace());
            $cart = $this->manager->createCart();
        }

        return $cart;
    }
}
