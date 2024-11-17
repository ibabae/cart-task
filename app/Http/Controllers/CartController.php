<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @OA\Get(
     *      path="/api/cart",
     *      summary="Get the user's cart",
     *      tags={"Cart"},
     *      description="Fetches the current user's cart with products and their quantities",
     *      @OA\Response(
     *          response=200,
     *          description="Cart data",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="product", type="object",
     *                          @OA\Property(property="id", type="integer", example=2),
     *                          @OA\Property(property="title", type="string", example="Mac M2"),
     *                          @OA\Property(property="price", type="integer", example=70000000),
     *                          @OA\Property(property="stock", type="integer", example=10),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-17T08:00:15.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-17T13:39:12.000000Z")
     *                      ),
     *                      @OA\Property(property="quantity", type="string", example="1")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Unauthenticated.")
     *          )
     *      )
     * )
     */
    public function index()
    {
        return $this->cartService->getCart();
    }

 /**
 * @OA\Post(
 *      path="/api/cart",
 *      summary="Add product to cart",
 *      tags={"Cart"},
 *      description="Add a product to the user's cart",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"product_id", "quantity"},
 *              @OA\Property(property="product_id", type="integer", example=1, description="Product ID"),
 *              @OA\Property(property="quantity", type="integer", example=1, description="Quantity of the product")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Product added successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="success"),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      @OA\Property(property="product", type="object",
 *                          @OA\Property(property="id", type="integer", example=1),
 *                          @OA\Property(property="title", type="string", example="Mac M2 Pro"),
 *                          @OA\Property(property="price", type="integer", example=55000),
 *                          @OA\Property(property="stock", type="integer", example=8),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-17T07:17:20.000000Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-17T09:14:42.000000Z")
 *                      ),
 *                      @OA\Property(property="quantity", type="string", example="1")
 *                  )
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *           response=422,
 *           description="Validation failed due to either quantity exceeding available stock or product already existing in cart",
 *           @OA\JsonContent(
 *               @OA\Property(property="status", type="boolean", example=false),
 *               @OA\Property(
 *                   property="data",
 *                   type="object",
 *                   @OA\Property(property="message", type="string", example="The quantity exceeds the available stock for this product or Product is already in cart."),
 *                   @OA\Property(
 *                       property="errors",
 *                       type="object",
 *                       @OA\Property(
 *                           property="quantity",
 *                           type="array",
 *                           @OA\Items(type="string", example="The quantity exceeds the available stock for this product.")
 *                       ),
 *                       @OA\Property(
 *                           property="product_exists",
 *                           type="array",
 *                           @OA\Items(type="string", example="Product is already in cart.")
 *                       )
 *                   )
 *               )
 *           )
 *      )
 * )
 */

    public function store(StoreCartRequest $request)
    {
        return $this->cartService->addToCart($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="/api/cart/{product_id}",
     *      summary="Remove product from cart",
     *      tags={"Cart"},
     *      description="Remove a product from the user's cart",
     *      @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product removed successfully or cart is empty",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="product", type="object",
     *                          @OA\Property(property="id", type="integer", example=2),
     *                          @OA\Property(property="title", type="string", example="Mac M2"),
     *                          @OA\Property(property="price", type="integer", example=70000000),
     *                          @OA\Property(property="stock", type="integer", example=10),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-17T08:00:15.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-17T13:39:12.000000Z")
     *                      ),
     *                      @OA\Property(property="quantity", type="string", example="1")
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($productId)
    {
        return $this->cartService->removeFromCart($productId);
    }

    /**
     * @OA\Delete(
     *      path="/api/cart",
     *      summary="Clear the user's cart",
     *      tags={"Cart"},
     *      description="Remove all items from the authenticated user's cart.",
     *      security={{"bearer_token": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Cart cleared successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data", type="array", items={})
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized - Authentication required",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Unauthenticated.")
     *          )
     *      )
     * )
     */

    public function clear()
    {
        return $this->cartService->clearCart();
    }

}
