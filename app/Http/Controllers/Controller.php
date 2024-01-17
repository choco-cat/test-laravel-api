<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Test API Documentation",
 *     version="0.1",
 *      @OA\Contact(
 *          email="chococat2014@gmail.com"
 *      ),
 * ),
 *  @OA\Server(
 *      description="Learning env",
 *      url="http://testlaravel/"
 *  ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
