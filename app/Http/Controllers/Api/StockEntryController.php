<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockEntry;

class StockEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockEntry::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('item_code', 'like', "%$search%")
                  ->orWhere('item_name', 'like', "%$search%")
                  ->orWhere('store_name', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%");
            });
        }

        if ($sort = $request->input('sort')) {
            foreach ($sort as $field => $dir) {
                $query->orderBy($field, $dir);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $page = $request->input('page', 1);
        $size = $request->input('size', 10);
        $total = $query->count();
        $data = $query->skip(($page - 1) * $size)->take($size)->get();

        $res = [
            'data' => $data,
            'last_page' => ceil($total / $size),
            'total' => $total,
        ];
        return $res;
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'entries' => 'required|array',
            'entries.*.item_code' => 'required|string',
            'entries.*.item_name' => 'required|string',
            'entries.*.quantity' => 'required|integer',
            'entries.*.location' => 'required|string',
            'entries.*.store_name' => 'required|string',
            'entries.*.in_stock_date' => 'required|date',
        ]);

        $entries = [];
        foreach ($request->entries as $entry) {
            $maxStockNo = StockEntry::max('stock_no') ?? 0;
            $entries[] = [
                'stock_no' => $maxStockNo + 1,
                'item_code' => $entry['item_code'],
                'item_name' => $entry['item_name'],
                'quantity' => $entry['quantity'],
                'location' => $entry['location'],
                'store_name' => $entry['store_name'],
                'in_stock_date' => $entry['in_stock_date'],
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        StockEntry::insert($entries);

        return response()->json(['message' => 'Stock entries saved successfully.']);
    }

    public function destroy($id)
    {
        $stock = StockEntry::findOrFail($id);
        $stock->delete();

        return response()->json(['message' => 'Stock entry deleted successfully.']);
    }
}
