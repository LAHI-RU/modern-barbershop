<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'bio',
    'is_active',
    'user_id',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function availabilities()
  {
    return $this->hasMany(Availability::class);
  }

  public function appointments()
  {
    return $this->hasMany(Appointment::class);
  }

  public function user()
  {
    return $this->belongsTo(\App\Models\User::class);
  }
}
