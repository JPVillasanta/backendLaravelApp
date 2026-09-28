<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /*
     * GET /api/products data is kept for one minute.
     * Every create, update, or delete clears it so old data is never shown.
     */
    private const PRODUCTS_CACHE_KEY = 'api.products.index';

    /**
     * Return all products. Cache avoids repeating the same database query.
     */
    public function index(): JsonResponse
    {
        $products = Cache::remember(self::PRODUCTS_CACHE_KEY, now()->addMinute(), function () {
            return Product::latest()->get();
        });

        return response()->json($products);
    }

    /**
     * Create a product from JSON sent by React.
     */
    public function store(Request $request): JsonResponse
    {
        $product = Product::create($this->validatedData($request));

        $this->clearProductCache();

        return response()->json($product, 201);
    }

    /**
     * Return one product using Laravel's route-model binding.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Update a product using the same validation rules as creation.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $product->update($this->validatedData($request));

        $this->clearProductCache();

        return response()->json($product->fresh());
    }

    /**
     * Delete a product, then clear the cached product list.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        $this->clearProductCache();

        return response()->json(null, 204);
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function clearProductCache(): void
    {
        Cache::forget(self::PRODUCTS_CACHE_KEY);
    }
}
