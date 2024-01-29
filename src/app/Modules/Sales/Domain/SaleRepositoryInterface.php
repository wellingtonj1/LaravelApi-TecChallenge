<?php

namespace Modules\Sales\Domain;

use Illuminate\Support\Collection;

interface SaleRepositoryInterface
{
    public function save(Sale $sale): void;

    public function getById(int $saleId): ?Sale;

    public function getSaleWithProducts(int $saleId): ?Sale;

    public function getAllSalesWithProducts(): Collection;

}
