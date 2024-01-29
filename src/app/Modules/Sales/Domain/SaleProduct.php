<?php

namespace Modules\Sales\Domain;
use JsonSerializable;


class SaleProduct implements JsonSerializable
{
    private int $productId;
    private string $productName;
    private float $productPrice;
    private int $quantity;

    public function __construct(int $productId, string $productName, float $productPrice, int $quantity)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
        $this->quantity = $quantity;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function jsonSerialize()
    {
        return [
            'productId' => $this->productId,
            'productName' => $this->productName,
            'productPrice' => $this->productPrice,
            'quantity' => $this->quantity,
        ];
    }

}
