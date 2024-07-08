<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateUserRequest;


class UserController extends Controller
{
    /**
     * @OA\POST(
     *      path="/api/v1/register",
     *      tags={"User"},
     *      operationId="registerNewUser", 
     *      summary="Create a new user with bearerAuth", 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name", "email", "password", "password_confirmation"},
     *                      @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="name"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      description="password"
     *                  ),
     *                  @OA\Property(
     *                      property="password_confirmation",
     *                      type="string",
     *                      description="Confirm password"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, 
     *          description="Successful operation", 
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422, 
     *          description="Validation error occurred", 
     *          @OA\JsonContent()
     *      )
     * )
     */

    public function store(CreateUserRequest $request)
    {
        $data = $request->only('name', 'email', 'password');
        $user = User::create($data);
        $access_token = $user->createToken('basic-token', ['product:read']);
        return response()->json([
            'user' => $user,
            'access_token' => $access_token->plainTextToken
        ], 200);
    }
}
