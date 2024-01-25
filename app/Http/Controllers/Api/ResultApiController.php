<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adapters\ResultListDataConverter;
use App\Models\Member;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultApiController extends Controller
{
    const COUNT_TOP_RESULTS = 10;

    /**
     * @OA\Get(
     *      path="/api/results",
     *      summary="Get top results",
     *      description="Display a top listing of the results.",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="User email (optional)",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     * )
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

        if ($selfData = $this->getUserData($email)) {
            $data['self'] = $selfData;
        }

        return response()->json(['data' => $data]);
    }

    /**
     * @OA\Post(
     *      path="/api/results/save",
     *      summary="Store a new result",
     *      description="Store a newly created result in storage.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"milliseconds"},
     *              @OA\Property(property="milliseconds", type="integer", example=100),
     *              @OA\Property(property="email", type="string", example="user@example.com"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $milliseconds = $request->get('milliseconds');
        $email = $request->get('email');

        $result = new Result(['milliseconds' => $milliseconds]);
        $result->save();

        if ($email) {
            Member::updateOrCreate(['email' => $email], ['email' => $email])->results()->save($result);
        }

        return response()->json(['status' => 'OK']);
    }

    /**
     * get self data
     *
     * @param string|null $email
     * @return array
     */
    private function getUserData(?string $email): array
    {
        if (!$email) {
            return [];
        }

        if (!$currentUser = Member::getUser($email)) {
            return [];
        }

        if (!$selfData = $currentUser->getUserResult()) {
            return [];
        }

        $converter = new ResultListDataConverter();
        $selfData = $converter->convert($selfData);
        return $selfData->first();
    }
}
