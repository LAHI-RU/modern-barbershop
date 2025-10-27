<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'service_id',
    'staff_id',
    'start_at',
    'end_at',
    'status',
    'notes',
  ];

  protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function service()
  {
    return $this->belongsTo(Service::class);
  }

  public function staff()
  {
    return $this->belongsTo(Staff::class);
  }
}
