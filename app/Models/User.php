<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTime;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    protected $fillable = [ 'id','email','balance','currency','creationDate'];

    public static function rules(): array    
    {
            return [
                'id' => ['required', 'string', 'unique:users'],
                'email' => ['required', 'email', 'unique:users'],
                'balance' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'currency' => ['required', 'string'],
                'creationDate' => ['required', 'date'],
            ];
    }

    public static function fromJsonFile(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'email' => $data['email'],
            'balance' => $data['balance'],
            'currency' => $data['currency'],
            'creationDate'  => DateTime::createFromFormat('d/m/Y', $data['created_at'])->format('Y-m-d'),
        ]);
    }

    public function transactions() : HasMany 
    {
        return $this->hasMany(
            related: Transaction::class,
            foreignKey: 'user_id',
        ); 
    }

}
