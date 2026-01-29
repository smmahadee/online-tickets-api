<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends ApiController
{
    public function index(User $author, TicketFilter $filters)
    {
        return TicketResource::collection(
            $author->tickets()->filter($filters)->paginate()
        );
    }

    public function store(StoreTicketRequest $request, User $author)
    {
        return new TicketResource(Ticket::create([...$request->mappedAttributes(), 'user_id' => $author->id]));
    }

    public function replace(ReplaceTicketRequest $request, string $author_id, string $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id != $author_id) {
                throw new ModelNotFoundException();
            }

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error("Ticket not found", 404);
        }
    }

    public function update(UpdateTicketRequest $request, string $author_id, string $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id != $author_id) {
                throw new ModelNotFoundException();
            }

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error("Ticket not found", 404);
        }
    }

    public function destroy(string $authorId, Ticket $ticket)
    {
        try {
            $author = User::findOrFail($authorId);
            $ticket = $author->tickets()->findOrFail($ticket->id);

            $ticket->delete();

            return $this->ok("Ticket deleted successfully");

        } catch (ModelNotFoundException $e) {
            return $this->error("Ticket not found", 404);
        }
    }
}
