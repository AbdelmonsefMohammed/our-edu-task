<?php

declare( strict_types = 1);

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TransactionResource extends JsonResource
{
    /**
     * @property-read Transaction $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->resource->id,  
            'paidAmount'            => $this->resource->paidAmount,
            'currency'              => $this->resource->currency,
            'statusCode'            => $this->resource->statusCode,
            'paymentDate'           => $this->resource->paymentDate,
            'parentIdentification'  => $this->resource->parentIdentification,
        ];
    }
}
