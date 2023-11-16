<?php

declare( strict_types = 1 );

namespace App\Enums;

enum TransactionStatus: int
{
    case AUTHORIZED = 1;
    case DECLINE    = 2;
    case REFUNDED   = 3;

}