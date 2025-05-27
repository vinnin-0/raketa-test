<?php

namespace Raketa\BackendTestTask\Http\Resource;

use Raketa\BackendTestTask\Domain\Product\Model\Product;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;
use RuntimeException;

readonly class ProductsResource implements ResourceInterface
{
    /**
     * @param  array<Product>  $products
     */
    public function __construct(
        private array $products
    ) {
    }

    /**
     * @throws RuntimeException
     */
    public function toArray(): array
    {
        return array_map(
            static fn(Product $product) => [
                'uuid' => $product->getUuid(),
                'category' => $product->getCategory(),
                'description' => $product->getDescription(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getPrice(),
            ],
            $this->products
        );
    }
}
