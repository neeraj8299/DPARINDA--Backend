<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get Product Listing
     * 
     * @param Request $request
     * 
     * @return object
     */
    public function getProductListing(Request $request): object
    {
        $page_size = $request->query('page_size', 10);
        $data = Product::join('product_images', 'products.id', 'product_images.product_id')
            ->select('name', 'description', 'price', 'image_name')
            ->paginate($page_size);
        return response()->json([
            "products" => $data
        ]);
    }

    /**
     * Get Specific Product Details
     * 
     * @param $id
     * 
     * @return object
     */
    public function getProductDetails($id): object
    {
        $productDetails = Product::join('product_images', 'products.id', 'product_images.product_id')
            ->select('name', 'description', 'price', 'image_name')
            ->where('products.id', $id)
            ->first();

        $statusCode = config('api-config.STATUS_CODE.NOT_FOUND');
        if (!$productDetails) {
            $productDetails = config('api-config.MESSAGES.NOT_FOUND_REQUEST');
            $statusCode = config('api-config.STATUS_CODE.NOT_FOUND');
        }
        return response()->json([
            "data" => $productDetails
        ], $statusCode);
    }
}
