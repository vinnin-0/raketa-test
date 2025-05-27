<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Http\Resource;

use Raketa\BackendTestTask\Domain\Cart\Model\Cart;
use Raketa\BackendTestTask\Domain\Product\Model\Product;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;

readonly class CartResource implements ResourceInterface
{
    public function __construct(
        private ProductRepository $productRepository,
        private Cart $cart
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function toArray(): array
    {
        $data = [
            'uuid' => $this->cart->getUuid(),
            'customer' => [
                'id' => $this->cart->getCustomer()->getId(),
                'name' => implode(' ', [
                    $this->cart->getCustomer()->getLastName(),
                    $this->cart->getCustomer()->getFirstName(),
                    $this->cart->getCustomer()->getMiddleName(),
                ]),
                'email' => $this->cart->getCustomer()->getEmail(),
            ],
            'payment_method' => $this->cart->getPaymentMethod(),
        ];

        $total = 0;
        $data['items'] = [];
        $productsUuids = [];
        foreach ($this->cart->getItems() as $item) {
            $productsUuids[] = $item->getProductUuid();
        }

        $products = $this->productRepository->getByUuid($productsUuids);

        foreach ($this->cart->getItems() as $item) {
            $total += $item->getPrice() * $item->getQuantity();
            $product = $this->getProductByUuid($item->getProductUuid(), $products);

            $data['items'][] = [
                'uuid' => $item->getUuid(),
                'price' => $item->getPrice(),
                'total' => $total,
                'quantity' => $item->getQuantity(),
                'product' => [
                    'uuid' => $product->getUuid(),
                    'name' => $product->getName(),
                    'thumbnail' => $product->getThumbnail(),
                    'price' => $product->getPrice(),
                ],
            ];
        }

        $data['total'] = $total;

        return $data;
    }

    /**
     * @throws NotFoundException
     */
    private function getProductByUuid(string $uuid, array $products): Product
    {
        /** @var Product $product */
        foreach ($products as $product) {
            if ($product->getUuid() === $uuid) {
                return $product;
            }
        }
        throw new NotFoundException(sprintf('Product with uuid %s not found', $uuid));
    }
}
