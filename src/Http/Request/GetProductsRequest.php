<?php

namespace Raketa\BackendTestTask\Http\Request;

use JsonException;

class GetProductsRequest extends AbstractRequest
{
    private string $category;

    /**
     * @throws JsonException
     */
    public function parseRequest(): void
    {
        $body = $this->parseJson();
        $this->category = $body['category'];
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
