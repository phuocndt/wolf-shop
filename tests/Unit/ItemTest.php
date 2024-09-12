<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Items;
use App\Services\WolfService;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /**
     * @description update quality success
     * @CoversFunction updateQuality
     * @Group item
     */
    public function testUpdateQuality(): void
    {
        $itemTest = new Items();
        $itemTest->name = 'Apple AirPods';

        $wolfService = new WolfService();
        $itemUpdate = $wolfService->updateQuality($itemTest);

        $this->assertEquals(1, $itemUpdate->quality);
    }

    /**
     * @description update quality failed
     * @CoversFunction updateQuality
     * @Group item
     */
    public function testUpdateQuality1(): void
    {
        $itemTest = new Items();
        $itemTest->name = 'Apple AirPods';
        $itemTest->quality = 50;
        $itemTest->sellIn = -1;

        $wolfService = new WolfService();
        $itemUpdate = $wolfService->updateQuality($itemTest);

        $this->assertEquals(0, $itemUpdate->quality);
    }
}
