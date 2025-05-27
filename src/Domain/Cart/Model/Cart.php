<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Cart\Model;

use Raketa\BackendTestTask\Domain\Customer\Model\Customer;

final class Cart
{
    /**
     * @param  string  $uuid
     * @param  Customer  $customer
     * @param  string  $paymentMethod
     * @param  array<CartItem>  $items
     */
    public function __construct(
        readonly private string $uuid,
        readonly private Customer $customer,
        readonly private string $paymentMethod,
        private array $items,
    ) {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @return array<CartItem>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param  CartItem  $item
     * @return void
     */
    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }
}
