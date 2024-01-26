<?php

namespace Tests\Unit\Modules\Sales\Application;

use Tests\TestCase;
use Modules\Sales\Application\SaleService;
use Modules\Sales\Domain\Sale;
use Modules\Sales\Domain\SaleRepositoryInterface;
use Mockery;

class SaleServiceTest extends TestCase
{
    public function testCreateSale()
    {
        $saleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $saleRepository->shouldReceive('save')->once();

        $saleService = new SaleService($saleRepository);

        $saleService->createSale(1, 'Product 1', 100.00, 2);
    }

    public function testGetSale()
    {
        $saleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $saleRepository->shouldReceive('getById')->andReturn(new Sale(1, 'Product 1', 100.00, 2));

        $saleService = new SaleService($saleRepository);

        $result = $saleService->getSale(1);

        $this->assertInstanceOf(Sale::class, $result);
        $this->assertEquals(1, $result->getProductId());
        // Outras asserções...
    }
}
