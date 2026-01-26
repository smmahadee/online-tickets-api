<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;

class AuthorTicketsController extends Controller
{
    public function index(User $author, TicketFilter $filters)
    {
        return TicketResource::collection(
            $author->tickets()->filter($filters)->paginate()
        );
    }

    public function store(StoreTicketRequest $request, User $author)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author->id,
        ];

        return new TicketResource(Ticket::create($model));
    }
}
