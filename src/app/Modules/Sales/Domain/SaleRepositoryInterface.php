<?php

namespace Modules\Sales\Domain;

interface SaleRepositoryInterface
{
    public function save(Sale $sale): void;

    public function getById(int $saleId): ?Sale;

    // Outros métodos de consulta...
}
