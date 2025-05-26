<?php

namespace Raketa\BackendTestTask\Http\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\Cart\CartManager;
use Raketa\BackendTestTask\Domain\Cart\Model\CartItem;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Resource\CartResource;
use Ramsey\Uuid\Uuid;

readonly class AddToCartController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CartResource $cartView,
        private CartManager $cartManager,
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $product = $this->productRepository->getByUuid($rawRequest['productUuid']);

        $cart = $this->cartManager->getCart();
        $cart->addItem(new CartItem(
            Uuid::uuid4()->toString(),
            $product->getUuid(),
            $product->getPrice(),
            $rawRequest['quantity'],
        ));

        $response = new JsonResponse();
        $response->getBody()->write(
            json_encode(
                [
                    'status' => 'success',
                    'cart' => $this->cartView->toArray($cart)
                ],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(200);
    }
}
