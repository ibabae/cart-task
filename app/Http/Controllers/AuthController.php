<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
     *      title="CartTask Api Document",
     *      description="This is the API documentation for cart task.",
     *      @OA\Contact(
     *          email="alibabaeian670@gmail.com"
     *      )
     * )
     *
     * @OA\Post(
     *      path="/api/login",
     *      summary="Login user",
     *      tags={"Auth"},
     *      description="Login user with email & password",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", description="Email address"),
     *              @OA\Property(property="password", type="string", format="password", description="Password")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5...")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid credentials provided.")
     *          )
     *      )
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
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
        throw new AuthenticationException('Invalid credentials provided.');
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
