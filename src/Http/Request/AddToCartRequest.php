<?php

namespace Raketa\BackendTestTask\Http\Request;

use JsonException;

class AddToCartRequest extends AbstractRequest
{
    private string $productUuid;
    private int $quantity;

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @throws JsonException
     */
    public function parseRequest(): void
    {
        $body = $this->parseJson();
        $this->quantity = $body['quantity'];
        $this->productUuid = $body['productUuid'];
    }
}
