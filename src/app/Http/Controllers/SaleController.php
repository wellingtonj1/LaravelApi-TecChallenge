<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'product_id' => 'required|integer',
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $this->saleService->createSale(
            $data['product_id'],
            $data['product_name'],
            $data['product_price'],
            $data['quantity']
        );

        return response()->json(['message' => 'Sale created successfully'], 201);
    }

    public function getSale($saleId)
    {
        $sale = $this->saleService->getSale($saleId);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        return response()->json($sale);
    }

    // Outros métodos...
}
