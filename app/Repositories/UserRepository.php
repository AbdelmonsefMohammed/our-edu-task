<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

final class UserRepository
{
    public function getUsers($statusCode, $currency, $minAmount, $maxAmount, $startDate, $endDate) :  LengthAwarePaginator
    {

        $query = User::query();

        $query = $query->with(['transactions' =>function ($q) use ($statusCode, $minAmount, $maxAmount, $startDate, $endDate) {
                        if (isset($statusCode)) {
                            $q->where('statusCode', $statusCode);
                        }
                        if(isset($minAmount)) {
                            $q->where('paidAmount', '>=' , $minAmount);
                        }
                        if (isset($maxAmount)) {
                            $q->where('paidAmount', '<=' , $maxAmount);
                        }
                        if(isset($startDate)) {
                            $q->whereDate('paymentDate', '>=' , $startDate);
                        }
                        if (isset($endDate)) {
                            $q->whereDate('paymentDate', '<=' , $endDate);
                        }
                    }])->whereHas('transactions', function ($q) use ($statusCode, $minAmount, $maxAmount, $startDate, $endDate) {
                        if (isset($statusCode)) {
                            $q->where('statusCode', $statusCode);
                        }
                        if(isset($minAmount)) {
                            $q->where('paidAmount', '>=' , $minAmount);
                        }
                        if (isset($maxAmount)) {
                            $q->where('paidAmount', '<=' , $maxAmount);
                        }
                        if(isset($startDate)) {
                            $q->whereDate('paymentDate', '>=' , $startDate);
                        }
                        if (isset($endDate)) {
                            $q->whereDate('paymentDate', '<=' , $endDate);
                        }
                    });
        
        if (isset($currency)) {
            $query = $query->where('currency', $currency);
        }

        $users = $query->paginate(10);

        return $users;
    }
}