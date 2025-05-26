<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Http\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\Cart\CartManager;
use Raketa\BackendTestTask\Resource\CartResource;

readonly class GetCartController
{
    public function __construct(
        public CartResource $cartView,
        public CartManager $cartManager
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $response = new JsonResponse();
        $cart = $this->cartManager->getCart();

        if (! $cart) {
            $response->getBody()->write(
                json_encode(
                    ['message' => 'Cart not found'],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(404);
        } else {
            $response->getBody()->write(
                json_encode(
                    $this->cartView->toArray($cart),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );
        }

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(404);
    }
}
