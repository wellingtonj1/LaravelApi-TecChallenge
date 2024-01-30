<?php

namespace Tests\Unit\Modules\Sales\Application;

use App\Models\Product;
use Tests\TestCase;
use Modules\Sales\Application\SaleService;
use Modules\Sales\Domain\SaleRepositoryInterface;
use Modules\Sales\Domain\Sale;

class SaleServiceTest extends TestCase
{
    public function testCreateSale()
    {
        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);
        $product = Product::first();

        $saleId = $saleService->createSale([$product], 10);
        $this->assertIsInt($saleId);
        // check if the get of the id is the same
        $saleServiceGet = new SaleService($saleRepository);
        $result = $saleServiceGet->getSale($saleId);
        $this->assertInstanceOf(Sale::class, $result);
    }

    public function testAddProductsToSale()
    {
        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);
        $product = Product::first();

        $saleId = $saleService->createSale([$product], 10);

        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);
        $product = Product::get()[1];

        $saleId = $saleService->addProductsToSale($saleId, [$product], 3);
        $this->assertIsInt($saleId);

        $saleServiceGet = new SaleService($saleRepository);
        $result = $saleServiceGet->getSale($saleId);
        $this->assertInstanceOf(Sale::class, $result);
        $this->assertEquals(2, $result->getProducts()->count());

    }

    public function testGetSale()
    {
        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);

        $result = $saleService->getSale(9999);
        $this->assertNull($result);
    }

    public function testGetSales()
    {
        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);

        $result = $saleService->getSales();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
    }

    public function testCancelSale()
    {
        $saleRepository = $this->app->make(SaleRepositoryInterface::class);
        $saleService = new SaleService($saleRepository);

        $lastSale = $saleService->getSales()->last();
        $this->expectException(\Exception::class);
        $saleService->cancelSale($lastSale->getId());
    }

}
