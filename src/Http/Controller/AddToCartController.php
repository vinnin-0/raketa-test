<?php

namespace Raketa\BackendTestTask\Http\Controller;

use Doctrine\DBAL\Exception as DBException;
use JsonException;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart\Service\CartService;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Http\Request\AddToCartRequest;
use Raketa\BackendTestTask\Http\Resource\CartResource;
use Raketa\BackendTestTask\Http\Response\JsonResponse;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;
use RuntimeException;
use Throwable;

readonly class AddToCartController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CartService $cartService,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(AddToCartRequest $request): JsonResponse
    {
        try {
            $request->parseRequest();
            $product = $this->productRepository->getByUuid($request->getProductUuid())[0];
            $cart = $this->cartService->addItem($product, $request->getQuantity());
        } catch (JsonException) {
            return new JsonResponse(422, ['message' => 'Bad JSON'], []);
        } catch (NotFoundException $e) {
            return new JsonResponse(404, ['message' => $e->getMessage()], []);
        } catch (RuntimeException) {
            return new JsonResponse(500, ['message' => 'Internal Server Error'], []);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return new JsonResponse(500, ['message' => 'Internal Server Error'], []);
        }

        return new JsonResponse(200, new CartResource($this->productRepository, $cart), []);
    }
}
