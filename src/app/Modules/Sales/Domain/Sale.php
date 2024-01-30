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

    public function getId(): int
    {
        return $this->id;
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
                $carry[$productId]['amount'] += $product->getQuantity();
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
            'nome' => $product->getProductName(),
            'price' => $product->getProductPrice() * $product->getQuantity(),
            'amount' => $product->getQuantity(),
        ];
    }

    public function addProducts(array $productsData, int $quantity): void
    {
        foreach ($productsData as $product) {
            $this->products->push(new SaleProduct($product['id'], $product['name'], $product['price'], $quantity));
        }
    }

    public function jsonSerialize()
    {
        $groupedProducts = $this->groupProductsByIdAndSumQuantityPrice();
        return [
            'sales_id' => $this->id,
            'amount' => $this->getTotalQuantity(),
            'products' => array_values($groupedProducts)
        ];
    }

    public function cancel(): void
    {
        $this->products = new Collection();
    }

}
