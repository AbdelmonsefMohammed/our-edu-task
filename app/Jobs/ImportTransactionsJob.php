<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

final class ImportTransactionsJob implements ShouldQueue
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

        foreach ($jsonData['transactions'] as $data) 
        {
            $transaction = Transaction::fromJsonFile($data)->toArray();
            $transaction['parentEmail']  = $data['parentEmail'];
            $validator = Validator::make($transaction, Transaction::rules());

            if ($validator->fails()) {
                continue;
            }
            $user = User::where('email', $transaction['parentEmail'])->first();


            if (! $user) 
            {
                // User dosen't exsist in User's table
                continue;
            }
            unset($transaction['parentEmail']);
            
            $transaction['user_id'] = $user->id;

            $validatedRecords[] = $transaction;
        }
        
        Transaction::insert($validatedRecords);

    }
}
