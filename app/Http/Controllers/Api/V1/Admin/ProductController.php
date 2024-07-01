<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Operations about Products",
 * )
 */
class ProductController extends Controller
{
    /**
     * Get List of Products
     * @OA\Get (
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::with('media', 'principle', 'ingredients', 'category')->where('name', 'like', "%$keyword%")->get();

        return response(['products' => ProductResource::collection($products)]);
    }

    public function show(Product $product) {
        $product = $product->load('media', 'principle', 'ingredients', 'category');

        return response(['product' => new ProductDetailResource($product), 'message' => 'success']);
    }
}
