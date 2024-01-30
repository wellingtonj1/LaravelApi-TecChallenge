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

    public function createSale(array $productsData, int $quantity): int
    {
        return $this->saleRepository->save($this->createSaleEntity($productsData, $quantity));
    }

    public function addProductsToSale(int $saleId, array $productsData, int $quantity): int
    {
        $sale = $this->saleRepository->getById($saleId);
        if ($sale) {
            $sale->addProducts($productsData, $quantity);
            return $this->saleRepository->save($sale);
        }
        throw new \Exception('Sale not found');
    }

    public function getSale(int $saleId): ?Sale
    {
        return $this->saleRepository->getSaleWithProducts($saleId);
    }

    public function getSales(): Collection
    {
        return $this->saleRepository->getAllSalesWithProducts();
    }

    private function createSaleEntity(array $productsData, int $quantity): Sale
    {
        $products = [];

        foreach ($productsData as $product) {
            $products[] = new SaleProduct($product['id'], $product['name'], $product['price'], $quantity);
        }

        return new Sale(0, collect($products));
    }

    public function cancelSale(int $saleId): void
    {
        $sale = $this->saleRepository->getById($saleId);
        if ($sale) {
            $this->saleRepository->delete($saleId);
            return;
        }
        throw new \Exception('Sale not found');
    }
}
