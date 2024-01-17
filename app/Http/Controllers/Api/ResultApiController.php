<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adapters\ResultListDataConverter;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultApiController extends Controller
{
    const COUNT_TOP_RESULTS = 10;

    /**
     * Display a top listing of the results.
     */
    public function top(Request $request): JsonResponse
    {
        $email = $request->email;
        $topList = Result::getTop(self::COUNT_TOP_RESULTS);
        $converter = new ResultListDataConverter();
        $topData = $converter->convert($topList);

        $data = [
            'top' => $topData
        ];

        if ($email && $selfData = Result::getUserResult($email)) {
            $selfData = $converter->convert($selfData);
            $data['self'] = $selfData[0];
        }

        return response()->json($data);
    }
}
