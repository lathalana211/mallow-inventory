<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->select([
                'id',
                'name',
                'code',
                'price',
                'tax_percentage',
                'stock_on_hand',
            ])
            ->orderBy('name')
            ->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    
public function lowStock(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
{
    $validated = $request->validate([
        'threshold' => ['sometimes', 'integer', 'min:0', 'max:1000000'],
    ]);

    $threshold = $validated['threshold'] ?? 10;

    $products = \App\Models\Product::query()
        ->select([
            'id',
            'name',
            'code',
            'price',
            'tax_percentage',
            'stock_on_hand',
        ])
        ->where('stock_on_hand', '<', $threshold)
        ->orderBy('stock_on_hand')
        ->get();

    return response()->json([
        'threshold' => $threshold,
        'products' => $products,
    ]);
}

}
