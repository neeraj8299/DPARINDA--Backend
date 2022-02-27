<?php

namespace App\Http\Controllers;

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
     * @param 
     * 
     * @return object
     */
    public function getProductListing(): object
    {
        return response()->json([
            "products" => []
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
        return response()->json([
            "detals" => [$id]
        ]);
    }
}
