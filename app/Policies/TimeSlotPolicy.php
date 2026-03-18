<?php

namespace App\Policies;

use App\Models\TimeSlot;
use App\Models\User;

class TimeSlotPolicy
{
    public function update(User $user, TimeSlot $timeSlot): bool
    {
        return $user->id === $timeSlot->user_id;
    }

    public function delete(User $user, TimeSlot $timeSlot): bool
    {
        return $user->id === $timeSlot->user_id;
    }
}