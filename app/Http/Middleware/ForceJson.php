<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);

        // if($request->method() == "DELETE" && $response->status() != 404) {
        //     return response()->noContent();
        // } else{
            $code = match (true) {
                $response->exception instanceof AuthenticationException => ['unauthenticated', Response::HTTP_UNAUTHORIZED],
                $response->exception instanceof AuthorizationException => ['unauthorized', Response::HTTP_FORBIDDEN],
                $response->exception instanceof ModelNotFoundException => ['Not Found', Response::HTTP_NOT_FOUND],
                $response->exception instanceof NotFoundHttpException => ['Not Found', Response::HTTP_NOT_FOUND],

                $response->exception instanceof ValidationException => ['Validation Failed', Response::HTTP_UNPROCESSABLE_ENTITY],
                $response->exception instanceof QueryException => ['Database Error', Response::HTTP_INTERNAL_SERVER_ERROR],
                $response->exception instanceof \PDOException => ['Database Error', Response::HTTP_INTERNAL_SERVER_ERROR],
                $response->exception instanceof Exception => ['error', Response::HTTP_UNPROCESSABLE_ENTITY],

                default => ['success', Response::HTTP_OK],
            };
            $status = ($response->getStatusCode() === 200) ? true : false;
            $originalData = $response->getOriginalContent();
            // dd($response->getStatusCode());

            return response()->json([
                'status' => $status,
                'data' => $originalData,
            ], $response->getStatusCode());
        // }
    }
}
