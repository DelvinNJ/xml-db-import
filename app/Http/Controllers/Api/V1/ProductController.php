<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Requests\Api\V1\CreateProductRequest;
use App\Http\Requests\Api\V1\UpdateProductRequest;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/products",
     *     summary="Get list of products",
     *     tags={"Products"},
     *     operationId="getProducts",
     *     security={
     *              {"Bearer": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */

    public function index()
    {
        $products = Product::paginate(20);
        return ProductResource::collection($products);
    }


    public function store(CreateProductRequest $request)
    {
        $data = $request->all();
        $product = Product::create($data);
        return new ProductResource($product);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products/{id}",
     *     summary="Get a product details",
     *     tags={"Products"},
     *     operationId="getSingleProducts",
     *     security={
     *              {"Bearer": {}}
     *     },
     *      @OA\Parameter(
     *          in="path",
     *          name="id", 
     *          required=true, 
     *          description="Getting a single product details",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ), 
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product->refresh());
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/products/{id}", 
     *      summary="Delete a product", 
     *      operationId="deleteSingleProduct",
     *      tags={"Products"},
     *      security={
     *              {"Bearer": {}}
     *     },
     *      @OA\Parameter(
     *          in="path",
     *          name="id", 
     *          required=true, 
     *          description="Product id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200, 
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404, 
     *          description="Resource Not Found",
     *          @OA\JsonContent()
     *      ),
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'message' => 'Successful operation'
        ], 202);
    }
}
