<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Items;
use App\Services\WolfService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from api';

    protected $wolfService;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://api.restful-api.dev/objects');

        if ($response->successful()) {
            $items = $response->json();
            $wolfService = new WolfService();
            $quality = 0;
            $sellIn = 0;
            foreach ($items as $item) {
                // Ensure the necessary data exists in the item response
                if (isset($item['name'])) {
                    $name = $item['name'];
                    $item['quality'] = $quality;
                    $item['sellIn'] = $sellIn;

                    if ($item['data'] && count($item['data']) > 0) {
                        $data = json_encode($item['data']);
                    }

                    // Check if the item exists in the items
                    $objectItem = Items::where('name', $name)->first();

                    if ($objectItem) {
                        // Update the existing item's
                        $updatedItem = $wolfService->updateQuality($objectItem);
                        // updateQuality
                        $objectItem->quality = $updatedItem->quality;
                        $objectItem->save();
                        $this->info("Updated item: {$name}");
                    } else {
                        // Create a new item in the items
                        Items::create([
                            'name' => $name,
                            'quality' => $quality,
                            'sellIn' => $sellIn,
                            'data' => $data,
                        ]);
                        $this->info("Added new item: {$name}");
                    }
                } else {
                    $this->error('Invalid item data: ' . json_encode($item));
                }
            }

            $this->info('Item import process completed successfully.');
        } else {
            $this->error('Failed to fetch items from API. Status: ' . $response->status());
        }

        return 0;
    }
}
