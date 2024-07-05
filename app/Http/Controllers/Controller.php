<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="XML DB Import Project Documentation",
 *     version="1.0.0",
 *     description="API Documentation for XML db import",
 *     @OA\Contact(
 *         email="delvinnj02@gmail.com"
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
