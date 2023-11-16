<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

final class ImportUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $fileUrl,
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contents = File::get($this->fileUrl);

        $jsonData = json_decode($contents, true);

        $validatedRecords = [];

        foreach ($jsonData['users'] as $data) 
        {
            $user = User::fromJsonFile($data);

            $validator = Validator::make($user->toArray(), User::rules());

            if ($validator->fails()) {
                continue;
            }

            $validatedRecords[] = $user->toArray();
        }
        
        User::insert($validatedRecords);

    }
}
