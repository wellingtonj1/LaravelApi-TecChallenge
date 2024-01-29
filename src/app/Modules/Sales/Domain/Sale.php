<?php

namespace Modules\Sales\Domain;

use Illuminate\Support\Collection;
use JsonSerializable;


class Sale implements JsonSerializable
{
    private int $id;
    private Collection $products;

    public function __construct(int $id, Collection $products)
    {
        $this->id = $id;
        $this->products = $products;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getTotalQuantity(): int
    {
        return $this->products->sum(function ($product) {
            return $product->getQuantity();
        });
    }

    private function groupProductsByIdAndSumQuantityPrice(): array
    {
        return $this->products->reduce(function ($carry, $product) {
            $productId = $product->getProductId();

            // Se já existe um registro para este productId, adicione a quantidade e preço
            if (isset($carry[$productId])) {
                $carry[$productId]['quantity'] += $product->getQuantity();
                $carry[$productId]['price'] += $product->getQuantity() * $product->getProductPrice();
            } else {
                // Se não, crie um novo registro
                $carry[$productId] = $this->createProductArray($product);
            }

            return $carry;
        }, []);
    }

    private function createProductArray($product): array
    {
        return [
            'product_id' => $product->getProductId(),
            'name' => $product->getProductName(),
            'price' => $product->getProductPrice() * $product->getQuantity(),
            'quantity' => $product->getQuantity(),
        ];
    }

    public function jsonSerialize()
    {
        $groupedProducts = $this->groupProductsByIdAndSumQuantityPrice();
        return [
            'id' => $this->id,
            'totalQuantity' => $this->getTotalQuantity(),
            'products' => array_values($groupedProducts)
        ];
    }

}
