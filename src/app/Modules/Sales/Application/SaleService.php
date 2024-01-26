<?php

namespace Modules\Sales\Application;

use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;

class SaleService
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function createSale(int $productId, string $productName, float $productPrice, int $quantity): void
    {
        $sale = new Sale($productId, $productName, $productPrice, $quantity);
        $this->saleRepository->save($sale);
    }

    public function getSale(int $saleId): ?Sale
    {
        return $this->saleRepository->getById($saleId);
    }

    // Outros métodos de consulta...
}
