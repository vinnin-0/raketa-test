<?php

namespace Raketa\BackendTestTask\Resource;

use Raketa\BackendTestTask\Domain\Product\Model\Product;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;

readonly class ProductsResource
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function toArray(string $category): array
    {
        return array_map(
            fn (Product $product) => [
                'id' => $product->getId(),
                'uuid' => $product->getUuid(),
                'category' => $product->getCategory(),
                'description' => $product->getDescription(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getPrice(),
            ],
            $this->productRepository->getByCategory($category)
        );
    }
}
