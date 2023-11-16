<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Validation\Rule;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','paidAmount','currency','statusCode','paymentDate','parentIdentification'];

    public function user() : BelongsTo 
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public static function rules(): array    
    {
            return [
                'paidAmount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'currency' => ['required', 'string'],
                'parentEmail' => ['required', 'email'],
                'statusCode' => ['required', Rule::enum(TransactionStatus::class)],
                'paymentDate' => ['required', 'date'],
                'parentIdentification' => ['required', 'string'],
            ];
    }

    public static function fromJsonFile(array $data): self
    {
        return new self([
            'paidAmount'            => $data['paidAmount'],
            'currency'              => $data['Currency'],
            'statusCode'            => $data['statusCode'],
            'paymentDate'           => $data['paymentDate'],
            'parentIdentification'  => $data['parentIdentification'],
        ]);
    }

    protected $casts = [
        'statusCode' => TransactionStatus::class,
    ];
}
