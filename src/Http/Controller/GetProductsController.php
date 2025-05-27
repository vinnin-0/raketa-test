<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Http\Controller;

use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Product\Repository\ProductRepository;
use Raketa\BackendTestTask\Http\Request\GetProductsRequest;
use Raketa\BackendTestTask\Http\Resource\ProductsResource;
use Raketa\BackendTestTask\Http\Response\JsonResponse;

readonly class GetProductsController
{
    public function __construct(
        private ProductRepository $repository,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(GetProductsRequest $request): JsonResponse
    {
        try {
            $request->parseRequest();
            $products = $this->repository->getByCategory($request->getCategory());
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return new JsonResponse($e->getCode(), ['message' => $e->getMessage()]);
        }

        return new JsonResponse(200, new ProductsResource($products));
    }
}
