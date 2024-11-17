<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\IndexProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ){}

    /**
     * @OA\Get(
     *      path="/api/product",
     *      summary="Index products",
     *      tags={"Product"},
     *      security={{"bearerAuth":{}}},
     *      description="list of products",
     *      @OA\Response(
     *          response=200,
     *          description="List of products",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="title", type="string", example="Mac M2 Pro"),
     *                      @OA\Property(property="price", type="integer", example=50000),
     *                      @OA\Property(property="stock", type="integer", example=6)
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return new IndexProductResource($this->productService->getProducts());
    }

    /**
     * @OA\Post(
     *      path="/api/product",
     *      summary="Store product",
     *      tags={"Product"},
     *      security={{"bearerAuth":{}}},
     *      description="Create a new product",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "price", "stock"},
     *              @OA\Property(property="title", type="string", format="text", description="Title of the product"),
     *              @OA\Property(property="price", type="number", format="float", description="Price of the product"),
     *              @OA\Property(property="stock", type="integer", format="int32", description="Stock number")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product has been created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", example="Mac m2 pro"),
     *              @OA\Property(property="price", type="number", example=100000000),
     *              @OA\Property(property="stock", type="integer", example=5)
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="text", example="Validation Failed"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="The price field is required."),
     *                  @OA\Property(
     *                      property="errors",
     *                      type="object",
     *                      @OA\Property(
     *                          property="price",
     *                          type="array",
     *                          @OA\Items(type="string", example="The price field is required.")
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        return $this->productService->createProduct($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *     summary="Get product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     description="Retrieve product details by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="1"
     *         ),
     *         description="ID of the product"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Mac M2"),
     *             @OA\Property(property="price", type="integer", example=50000),
     *             @OA\Property(property="stock", type="integer", example=6),
     *             @OA\Property(property="created_at", type="datetime", example="2024-11-17T10:47:20.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2024-11-17T10:47:20.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Not Found"),
     *             @OA\Property(property="message", type="string", example="No query results for model")
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        return $this->productService->getProductById($id);
    }

    /**
     * @OA\Put(
     *     path="/api/product/{id}",
     *     summary="Update product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     description="Update product details by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="1"
     *         ),
     *         description="ID of the product"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"title", "price", "stock"},
     *             @OA\Property(property="title", type="string", example="Mac M2 Pro"),
     *             @OA\Property(property="price", type="integer", example=55000),
     *             @OA\Property(property="stock", type="integer", example=8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Mac M2 Pro"),
     *             @OA\Property(property="price", type="integer", example=55000),
     *             @OA\Property(property="stock", type="integer", example=6),
     *             @OA\Property(property="created_at", type="datetime", example="2024-11-17T10:47:20.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2024-11-17T10:47:20.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="text", example="Validation Failed"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="message", type="string", example="The price field is required."),
     *                 @OA\Property(
     *                     property="errors",
     *                     type="object",
     *                     @OA\Property(
     *                         property="price",
     *                         type="array",
     *                         @OA\Items(type="string", example="The price field is required.")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Not Found"),
     *             @OA\Property(property="message", type="string", example="No query results for model")
     *         )
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        return $this->productService->updateProduct($id, $request->validated());
    }

    /**
     * @OA\Delete(
     *     path="/api/product/{id}",
     *     summary="Delete product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     description="Delete product by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="1"
     *         ),
     *         description="ID of the product"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delete Response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No query results",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Not Found"),
     *             @OA\Property(property="message", type="string", example="No query results for model")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->productService->deleteProduct($id);
    }
}
