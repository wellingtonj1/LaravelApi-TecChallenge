<?php

namespace Modules\Sales\Application;

use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;
use Modules\Sales\Domain\SaleProduct;
use Illuminate\Support\Collection;

class SaleService
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function createSale(array $productsData): void
    {
        $products = [];

        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $productName = $productData['product_name'];
            $productPrice = $productData['product_price'];
            $quantity = $productData['quantity'];

            $products[] = new SaleProduct($productId, $productName, $productPrice, $quantity);
        }

        $sale = new Sale(0, collect($products));
        $this->saleRepository->save($sale);
    }

    public function getSale(int $saleId): ?Sale
    {
        return $this->saleRepository->getSaleWithProducts($saleId);
    }

    public function getSales(): Collection
    {
        return $this->saleRepository->getAllSalesWithProducts();
    }
}
