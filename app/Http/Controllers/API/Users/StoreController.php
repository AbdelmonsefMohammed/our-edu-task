<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Jobs\ImportUsersJob;
use Treblle\Tools\Http\Enums\Status;
use App\Http\Requests\StoreJsonFileRequest;
use Illuminate\Contracts\Support\Responsable;
use Treblle\Tools\Http\Responses\MessageResponse;

final class StoreController
{

    public function __invoke(StoreJsonFileRequest $request) : Responsable
    {
        $jsonFile = $request->file('file');
        $fileName = $jsonFile->getClientOriginalName();
        $jsonFile->storeAs("JsonFiles/", $fileName, "public");
        $fileUrl = "/storage/JsonFiles/" . $fileName;

        $fileUrl = storage_path('app/public') . "/JsonFiles/" . $fileName;

        dispatch(new ImportUsersJob(
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
