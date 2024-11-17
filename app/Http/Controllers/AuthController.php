<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     *
     * @OA\Info(
     *      version="1.0.0",
     *      title="Marco Api Document",
     *      description="This is the API documentation for our project.",
     *      @OA\Contact(
     *          email="alibabaeian670@gmail.com"
     *      )
     * )
     * @OA\Post(
     *      path="/api/login",
     *      summary="Login user",
     *      tags={"Auth"},
     *      description="Login user with phone number and code",
     *      @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          description="Login with phone number",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          description="Verification code",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="client_id", type="integer"),
     *             @OA\Property(property="client_secret", type="string")
     *         )
     *      ),
     *      @OA\Response(
     *          response=203,
     *          description="Verification code error",
     *      )
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Use Passport bearer token to access protected endpoints",
     *     name="Authorization",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="passport",
     * )
     */

    public function store(StoreAuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();
            return [
                'token' => $user->createToken(env('APP_NAME'))->plainTextToken,
            ];
        }
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
