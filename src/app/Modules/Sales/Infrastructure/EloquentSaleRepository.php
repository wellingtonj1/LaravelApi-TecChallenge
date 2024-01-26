<?php

namespace Modules\Sales\Infrastructure;

use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;
use App\Models\Sale as SaleModel;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function save(Sale $sale): void
    {
        SaleModel::create([
            'product_id' => $sale->getProductId(),
            'product_name' => $sale->getProductName(),
            'product_price' => $sale->getProductPrice(),
            'quantity' => $sale->getQuantity(),
        ]);
    }

    public function getById(int $saleId): ?Sale
    {
        $saleModel = SaleModel::find($saleId);

        if ($saleModel) {
            return new Sale(
                $saleModel->product_id,
                $saleModel->product_name,
                $saleModel->product_price,
                $saleModel->quantity
            );
        }

        return null;
    }

    // Implementar outros métodos de consulta...
}
