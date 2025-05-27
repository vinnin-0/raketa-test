<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Http\Response;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Raketa\BackendTestTask\Http\Resource\ResourceInterface;

/**
 * Класс заглушка
 */
class JsonResponse implements ResponseInterface
{
    public const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json; charset=utf-8', 'Accept' => 'application/json'
    ];

    private array $body;
    private array $headers;
    private int $statusCode;

    public function __construct(
        int $statusCode = 200,
        array|ResourceInterface $body = [],
        array $headers = [],
    ) {
        $this->statusCode = $statusCode;
        $this->headers = array_merge(self::DEFAULT_HEADERS, $headers);
        if ($body instanceof ResourceInterface) {
            $this->body = $body->toArray();
        } else {
            $this->body = $body;
        }
    }

    /**
     * @throws \JsonException
     */
    protected function prepare()
    {
        $body = json_encode($this->body, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        foreach ($this->headers as $header => $value) {
            $this->withHeader($header, $value);
        }
        $this->getBody()->write($body);
        $this->withStatus($this->statusCode);
    }

    public function getProtocolVersion(): string
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader(string $name): bool
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader(string $name): array
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine(string $name): string
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader(string $name): MessageInterface
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody(): StreamInterface
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        // TODO: Implement withBody() method.
    }

    public function getStatusCode(): int
    {
        // TODO: Implement getStatusCode() method.
    }

    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        // TODO: Implement withStatus() method.
    }

    public function getReasonPhrase(): string
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
