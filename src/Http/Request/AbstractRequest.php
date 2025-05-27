<?php

namespace Raketa\BackendTestTask\Http\Request;

use JsonException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractRequest implements RequestInterface
{
    /**
     * @throws JsonException
     */
    protected function parseJson()
    {
        return json_decode($this->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    abstract protected function parseRequest(): void;

    /**
     * @inheritDoc
     */
    public function getProtocolVersion(): string
    {
        // TODO: Implement getProtocolVersion() method.
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        // TODO: Implement withProtocolVersion() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * @inheritDoc
     */
    public function hasHeader(string $name): bool
    {
        // TODO: Implement hasHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeader(string $name): array
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine(string $name): string
    {
        // TODO: Implement getHeaderLine() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withAddedHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader(string $name): MessageInterface
    {
        // TODO: Implement withoutHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getBody(): StreamInterface
    {
        // TODO: Implement getBody() method.
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        // TODO: Implement withBody() method.
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget(): string
    {
        // TODO: Implement getRequestTarget() method.
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        // TODO: Implement withRequestTarget() method.
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        // TODO: Implement getMethod() method.
    }

    /**
     * @inheritDoc
     */
    public function withMethod(string $method): RequestInterface
    {
        // TODO: Implement withMethod() method.
    }

    /**
     * @inheritDoc
     */
    public function getUri(): UriInterface
    {
        // TODO: Implement getUri() method.
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {
        // TODO: Implement withUri() method.
    }
}
