<?php

namespace Database\Seeders;

use App\Models\StockEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            [
                'stock_no' => 1,
                'item_code' => 'ITEM001',
                'item_name' => 'Apple',
                'quantity' => 50,
                'location' => 'Warehouse A',
                'store_name' => 'Store Alpha',
                'in_stock_date' => now()->toDateString(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stock_no' => 2,
                'item_code' => 'ITEM002',
                'item_name' => 'Banana',
                'quantity' => 100,
                'location' => 'Warehouse B',
                'store_name' => 'Store Beta',
                'in_stock_date' => now()->toDateString(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stock_no' => 3,
                'item_code' => 'ITEM003',
                'item_name' => 'Orange',
                'quantity' => 75,
                'location' => 'Warehouse A',
                'store_name' => 'Store Gamma',
                'in_stock_date' => now()->toDateString(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        StockEntry::insert($entries);
    }
}
