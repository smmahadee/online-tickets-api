<?php

namespace App\Policies\V1;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }
}
 