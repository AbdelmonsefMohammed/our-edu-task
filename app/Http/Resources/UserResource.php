<?php

declare( strict_types = 1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    /**
     * @property-read User $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'email'         => $this->resource->email,
            'balance'       => $this->resource->balance,
            'currency'      => $this->resource->currency,
            'creationDate'  => $this->resource->creationDate,
            'transactions'  => TransactionResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'transactions'    
                ),
            ),
        ];
    }
}
