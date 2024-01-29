<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Modules\Sales\Application\SaleService;

class SaleController extends Controller
{
    private SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function createSale(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        $products = Product::whereId($data['product_id'])->get()->toArray();

        $id = $this->saleService->createSale(
            $products,
            $data['quantity']
        );

        return response()->json(['id' => $id], 201);
    }

    public function addProductsToSale(Request $request, int $saleId)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        $products = Product::whereId($data['product_id'])->get()->toArray();
        // Adicione a lógica de validação conforme necessário

        $this->saleService->addProductsToSale($saleId, $products, $data['quantity']);

        return response()->json(['message' => 'Produtos adicionados à venda com sucesso'], 200);
    }

    public function getSale($saleId)
    {
        $sale = $this->saleService->getSale($saleId);
        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }
        return response()->json($sale);
    }

    public function getSales()
    {
        $sales = $this->saleService->getSales();
        return response()->json($sales);
    }

    public function cancelSale(int $saleId)
    {
        $this->saleService->cancelSale($saleId);
        return response()->json(['message' => 'Venda cancelada com sucesso'], 200);
    }
}
