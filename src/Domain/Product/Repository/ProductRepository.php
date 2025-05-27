<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Product\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Raketa\BackendTestTask\Domain\Product\Model\Product;
use Raketa\BackendTestTask\Infrastructure\Exception\NotFoundException;
use RuntimeException;

/**
 *
 */
class ProductRepository
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param  Connection  $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  string  $uuid
     * @return array<Product>
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function getByUuid(string|array $uuid): array
    {
        try {
            $rows = $this->connection->fetchAllAssociative(
                'SELECT * FROM products WHERE uuid in (?)',
                [[$uuid]]
            );
        } catch (Exception $e) {
            throw new RuntimeException('Failed to fetch products by uuid', 500, $e);
        }

        if (!$rows) {
            throw new NotFoundException(sprintf('Product with uuid %s not found', $uuid));
        }

        return array_map(
            fn(array $row): Product => $this->make($row),
            $rows
        );
    }

    /**
     * @param  string  $category
     * @return array<Product>
     * @throws NotFoundException
     * @throws RuntimeException
     */
    public function getByCategory(string $category): array
    {
        try {
            $rows = $this->connection->fetchAllAssociative(
                'SELECT * FROM products WHERE is_active = ? AND category = ?',
                [1, $category]
            );
        } catch (Exception $e) {
            throw new RuntimeException('Failed to fetch products by category', 500, $e);
        }

        if (empty($rows)) {
            throw new NotFoundException(sprintf('Product with category %s not found', $category));
        }

        return array_map(
            fn(array $row): Product => $this->make($row),
            $rows
        );
    }

    /**
     * @param  array  $row
     * @return Product
     */
    public function make(array $row): Product
    {
        return new Product(
            $row['uuid'],
            $row['is_active'],
            $row['category'],
            $row['name'],
            $row['description'],
            $row['thumbnail'],
            $row['price'],
        );
    }
}
