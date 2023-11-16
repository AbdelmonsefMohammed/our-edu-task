<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\CollectionResponse;

final class IndexController
{
    public function __construct(
        public UserRepository $userFilter
    ) 
    {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $statusCode = $request->query('statusCode');
        $currency   = $request->query('currency');
        $minAmount  = $request->query('minAmount');
        $maxAmount  = $request->query('maxAmount');
        $startDate  = $request->query('startDate');
        $endDate    = $request->query('endDate');

        $users = $this->userFilter->getUsers($statusCode, $currency, $minAmount, $maxAmount, $startDate, $endDate);


        return new JsonResponse(
            data: UserResource::collection(
                resource: $users,
            ),
            status: Status::OK->value,
        );

    }
}
