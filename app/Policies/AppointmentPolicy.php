<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
  /**
   * Global before check: allow admins to do anything.
   */
  public function before(User $user, $ability)
  {
    if ($user->is_admin) {
      return true;
    }
  }

  public function view(User $user, Appointment $appointment): bool
  {
    return $user->id === $appointment->user_id;
  }

  public function update(User $user, Appointment $appointment): bool
  {
    return $user->id === $appointment->user_id;
  }

  public function delete(User $user, Appointment $appointment): bool
  {
    return $user->id === $appointment->user_id;
  }
}
