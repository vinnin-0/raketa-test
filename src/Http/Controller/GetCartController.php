<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Http\Controller;

use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart\CartManager;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Http\Resource\CartResource;
use Raketa\BackendTestTask\Http\Response\JsonResponse;
use Throwable;

readonly class GetCartController
{
    public function __construct(
        private CartManager $cartManager,
        private LoggerInterface $logger,
        private ProductRepository $productRepository,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        try {
            $cart = $this->cartManager->getCart();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return new JsonResponse($e->getCode(), ['message' => $e->getMessage()]);
        }

        return new JsonResponse(200, new CartResource($this->productRepository, $cart));
    }
}
