<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
