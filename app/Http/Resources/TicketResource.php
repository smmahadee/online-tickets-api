<?php

namespace App\Http\Resources;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Ticket */
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "type" => "ticket",
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    $request->routeIs('tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route('tickets.show', $this->id)
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'author',
                        'id' => $this->user_id
                    ],
                    'links' => [
                        'self' => route('authors.show', $this->user_id)
                    ]
                ]
            ],
            'included' => $this->whenLoaded('author', fn() => new AuthorResource($this->author))

        ];
    }
}
