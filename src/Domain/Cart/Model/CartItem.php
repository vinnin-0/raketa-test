<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Cart\Model;

final readonly class CartItem
{
    /**
     * @param  string  $uuid
     * @param  string  $productUuid
     * @param  float  $price
     * @param  int  $quantity
     */
    public function __construct(
        public string $uuid,
        public string $productUuid,
        public float $price,
        public int $quantity,
    ) {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
