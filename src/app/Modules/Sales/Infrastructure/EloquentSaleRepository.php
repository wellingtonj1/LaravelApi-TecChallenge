<?php

namespace Modules\Sales\Infrastructure;

use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;
use App\Models\Sale as SaleModel;
use Modules\Sales\Domain\SaleProduct;
use Illuminate\Support\Collection;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function save(Sale $sale): void
    {
        $saleModel = new SaleModel();
        $saleModel->products()->sync($sale->getProducts()->map(function ($product) {
            return [
                'id' => $product->getProductId(),
                'name' => $product->getProductName(),
                'price' => $product->getProductPrice(),
                'quantity' => $product->getQuantity(),
            ];
        })->all());

        $saleModel->save();
    }

    public function getById(int $saleId): ?Sale
    {
        $saleModel = SaleModel::find($saleId);

        if ($saleModel) {
            $products = $saleModel->products->map(function ($product) {
                return new SaleProduct(
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->pivot->quantity
                );
            });

            return new Sale($saleModel->id,$products);
        }

        return null;
    }

    public function getSaleWithProducts(int $saleId): ?Sale
    {
        $saleModel = SaleModel::with('products')->find($saleId);

        if ($saleModel) {
            $products = $saleModel->products->map(function ($product) {
                return new SaleProduct(
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->pivot->quantity
                );
            });

            return new Sale($saleModel->id,$products);
        }

        return null;
    }

    public function getAllSalesWithProducts(): Collection
    {
        $sales = SaleModel::with('products')->get();
        $salesWithProducts = $sales->map(function ($sale) {
            $products = $sale->products->map(function ($product) {
                return new SaleProduct(
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->pivot->quantity
                );
            });

            return new Sale($sale->id, collect($products));
        });

        return $salesWithProducts;
    }
}
