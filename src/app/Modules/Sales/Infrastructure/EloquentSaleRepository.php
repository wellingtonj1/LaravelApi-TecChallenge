<?php

namespace Modules\Sales\Infrastructure;

use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;
use App\Models\Sale as SaleModel;
use Modules\Sales\Domain\SaleProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function save(Sale $sale): int
    {
        try {
            DB::beginTransaction();

            $saleModel = $sale->getId() == 0 ? new SaleModel() : SaleModel::find($sale->getId());
            $saleModel->save();

            $newProducts = $sale->getProducts()->map(function ($product) use ($saleModel) {
                return [
                    'id' => 0,
                    'sale_id' => $saleModel['id'],
                    'product_id' => $product->getProductId(),
                    'quantity' => $product->getQuantity(),
                ];
            })->all();

            $saleModel->products()->detach();
            $saleModel->products()->sync($newProducts);
            $saleModel->save();

            DB::commit();
            return $saleModel->id;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
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

    public function delete(int $saleId): void
    {
        SaleModel::destroy($saleId);
    }
}
