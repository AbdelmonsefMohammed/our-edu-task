<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Transactions;

use App\Jobs\ImportTransactionsJob;
use Treblle\Tools\Http\Enums\Status;
use App\Http\Requests\StoreJsonFileRequest;
use Illuminate\Contracts\Support\Responsable;
use Treblle\Tools\Http\Responses\MessageResponse;

final class StoreController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreJsonFileRequest $request) : Responsable
    {
        $jsonFile = $request->file('file');
        $fileName = $jsonFile->getClientOriginalName();
        $jsonFile->storeAs("JsonFiles/", $fileName, "public");
        $fileUrl = "/storage/JsonFiles/" . $fileName;

        $fileUrl = storage_path('app/public') . "/JsonFiles/" . $fileName;

        dispatch(new ImportTransactionsJob(
            fileUrl: $fileUrl,
        ));

        return new MessageResponse(
            data: [
                'message' => 'We are processing your request',
            ],
            status: Status::ACCEPTED
        );
    }
}
