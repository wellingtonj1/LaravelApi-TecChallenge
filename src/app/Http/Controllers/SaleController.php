<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
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
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $products = Product::whereId($request['product_id'])->get()->toArray();
            $id = $this->saleService->createSale(
                $products,
                $request['quantity']
            );
            return response()->json(['id' => $id], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function addProductsToSale(Request $request, int $saleId)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $products = Product::whereId($request['product_id'])->get()->toArray();
            $this->saleService->addProductsToSale($saleId, $products, $request['quantity']);
            return response()->json(['message' => 'Produtos adicionados à venda com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
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
        try {
            $this->saleService->cancelSale($saleId);
            return response()->json(['message' => 'Venda cancelada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);
        return $validator;
    }
}
