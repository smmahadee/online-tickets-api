<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{
    protected string $policyClass = TicketPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        return new TicketResource(Ticket::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket, TicketFilter $filters)
    {
        return new TicketResource($ticket->filter($filters)->first());
    }

    public function replace(ReplaceTicketRequest $request, string $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error("Ticket not found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, string $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error("Ticket not found", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->delete();

            return $this->ok("Ticket deleted successfully");

        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }
    }
}
