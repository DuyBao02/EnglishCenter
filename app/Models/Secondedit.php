<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Secondedit extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'data' => 'json',
    ];

    protected $fillable = [
        'user_id',
        'data',
        'daytime',
    ];

}
