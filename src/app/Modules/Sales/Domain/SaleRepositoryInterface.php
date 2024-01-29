<?php

namespace Modules\Sales\Domain;

use Illuminate\Support\Collection;

interface SaleRepositoryInterface
{
    public function save(Sale $sale): int;

    public function getById(int $saleId): ?Sale;

    public function getSaleWithProducts(int $saleId): ?Sale;

    public function getAllSalesWithProducts(): Collection;

    public function delete(int $saleId): void;

}
